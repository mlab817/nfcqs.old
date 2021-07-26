<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;

/**
 * Set maximum execution time
 * to 5 minutes.
 */
ini_set('max_execution_time', 300);

class DownloadController extends Controller
{
    /**
     * Download Forecast Result.
     *
     * @param Request $request
     */
    public function provinceForecast(Request $request)
    {
        $province = $request->input('province');
        $model = $request->input('model');
        $download = $request->input('download');
        
        $model = ($model == null OR $model == '') ? 2 : $model;
        $download = ($download == null OR $download == '') ? true : false;

        $years = [];
        $forecast = [];

        // get province details
        $p = DB::table('src_provinces')
            ->where('province', $province)
            ->first();

        // province id
        $provinceId = ($p != null) ? $p->id : 0;

        // get list of commodities of the province
        $__commodities = DB::table('crop')
            ->select('src_commodities.*', 'crop.id as crop_id', 'crop.conversion_rate', 'crop.remarks')
            ->leftJoin('src_commodities', 'crop.src_commodity_id', '=', 'src_commodities.id')
            ->where('src_province_id', $provinceId)
            ->where('crop.user_id', Auth::user()->id)
            ->groupBy('crop.id')
            ->orderBy('src_commodities.id', 'ASC')
            ->get();

        if (sizeof($__commodities) != 0) {
            foreach ($__commodities as $c) {

                // crop type commodity
                $__years = DB::table('crop_forecast')
                    ->leftJoin('crop', 'crop_forecast.crop_id', '=', 'crop.id')
                    ->where([
                        'crop.src_commodity_id' => $c->id,
                        'crop.src_province_id' => $provinceId
                    ])
                    ->distinct('crop_forecast.year')
                    ->groupBy('crop_forecast.year')
                    ->orderBy('crop_forecast.year', 'ASC')
                    ->get();

                if (sizeof($__years) != 0) {
                    foreach ($__years as $y) {
                        $years[] = $y->year;
                    }
                } 

                // non-crop type commodity
                $__years = DB::table('non_crop_forecast')
                    ->leftJoin('crop', 'non_crop_forecast.crop_id', '=', 'crop.id')
                    ->where([
                        'crop.src_commodity_id' => $c->id,
                        'crop.src_province_id' => $provinceId
                    ])
                    ->distinct('non_crop_forecast.year')
                    ->groupBy('non_crop_forecast.year')
                    ->orderBy('non_crop_forecast.year', 'ASC')
                    ->get();

                if (sizeof($__years) != 0) {
                    foreach ($__years as $y) {
                        if (!in_array($y->year, $years)) {
                            $years[] = $y->year;
                        }
                    }
                } 

            }
        }

        if (sizeof($__commodities) != 0) {
            foreach ($__commodities as $c) {
                if (sizeof($years) != 0) {

                    $__f = [];

                    for ($i = 0; $i < sizeof($years); $i++) {
                        if ($c->crop_type == 'Crop') {
                            $__d = DB::table('crop_forecast')
                                ->where([
                                    'crop_forecast.year' => $years[$i],
                                    'crop_forecast.crop_id' => $c->crop_id,
                                    'crop_forecast.model' => $model
                                ])
                                ->orderBy('crop_forecast.id', 'DESC')
                                ->first();

                            $__p = DB::table('population')
                                ->where([
                                    'population.year' => $years[$i],
                                    'population.crop_id' => $c->crop_id
                                ])
                                ->first();

                            $__f[$years[$i]] = [
                                'area_ha' => @$__d->area,
                                'yield_mt_ha' => @$__d->yield,
                                'production_mt' => @$__d->production,
                                'converted_production_mt' => @$__d->production * @$c->conversion_rate,
                                'per_capita_kg_year' => @$__d->per_capita_consumption_kg_yr,
                                'population' => @$__p->population,
                                'consumption_mt' => @$__d->consumption
                            ];
                        } else {
                            $__d = DB::table('non_crop_forecast')
                                ->where([
                                    'non_crop_forecast.year' => $years[$i],
                                    'non_crop_forecast.crop_id' => $c->crop_id,
                                    'non_crop_forecast.model' => $model
                                ])
                                ->orderBy('non_crop_forecast.id', 'DESC')
                                ->first();

                            $__p = DB::table('population')
                                ->where([
                                    'population.year' => $years[$i],
                                    'population.crop_id' => $c->crop_id
                                ])
                                ->first();

                            $__f[$years[$i]] = [
                                'production_mt' => @$__d->production,
                                'converted_production_mt' => @$__d->production * @$c->conversion_rate,
                                'per_capita_kg_year' => @$__d->per_capita_consumption_kg_yr,
                                'population' => @$__p->population,
                                'consumption_mt' => @$__d->consumption
                            ];
                        }
                    }
                    
                    $forecast[] = [
                        'commodity' => $c->commodity . ' --- ' . $c->remarks, 
                        'crop_type' => $c->crop_type,
                        'conversion_rate' => $c->conversion_rate,
                        'forecast' => $__f
                    ];

                }
            }
        }

        if (sizeof($forecast) != 0) {
            if ($download) {
            
                // template
                $template = 'template/per-province.xlsx';
                $generated = 'template/Forecast Result - ' . $province . '.xlsx';
                
                // create xlsx reader
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx;
                $excel = $reader->load($template);

                for ($i = 0; $i < sizeof($forecast); $i++) {
                    if ($forecast[$i]['crop_type'] == 'Crop') {
                        $clonedWorksheet = clone $excel->getSheetByName('CROP');
                        $clonedWorksheet->setTitle(substr(strtoupper($forecast[$i]['commodity']), 0, 30));
                    } else {
                        $clonedWorksheet = clone $excel->getSheetByName('NON-CROP');
                        $clonedWorksheet->setTitle(substr(strtoupper($forecast[$i]['commodity']), 0, 30));
                    }
                    
                    // add new sheet
                    $excel->addSheet($clonedWorksheet);

                    // get sheet index
                    $sheetIndex = $excel->getIndex(
                        $excel->getSheetByName(
                            substr(strtoupper($forecast[$i]['commodity']), 0, 30)
                        )
                    );

                    // make sheet active
                    $excel->setActiveSheetIndex($sheetIndex);
                    $sheet = $excel->getActiveSheet();
                    $row = 3;

                    // headers
                    if ($province == '...Philippines') {
                        $sheet->setCellValue('J2', 'IMPORT');
                        $sheet->setCellValue('K2', 'EXPORT');
                    }

                    if ($forecast[$i]['crop_type'] == 'Crop') {
                        if (sizeof($forecast[$i]['forecast']) != 0) {
                            $__yrs = array_keys($forecast[$i]['forecast']);

                            for ($j = 0; $j < sizeof($__yrs); $j++) {
                                
                                $sheet->setCellValue('B' . $row, $__yrs[$j]);
                                $sheet->setCellValue('C' . $row, $forecast[$i]['forecast'][$__yrs[$j]]['area_ha']);
                                $sheet->setCellValue('D' . $row, $forecast[$i]['forecast'][$__yrs[$j]]['yield_mt_ha']);
                                $sheet->setCellValue('E' . $row, $forecast[$i]['forecast'][$__yrs[$j]]['production_mt']);
                                $sheet->setCellValue('F' . $row, $forecast[$i]['forecast'][$__yrs[$j]]['converted_production_mt']);
                                $sheet->setCellValue('G' . $row, $forecast[$i]['forecast'][$__yrs[$j]]['per_capita_kg_year']);
                                $sheet->setCellValue('H' . $row, $forecast[$i]['forecast'][$__yrs[$j]]['population']);
                                $sheet->setCellValue('I' . $row, $forecast[$i]['forecast'][$__yrs[$j]]['consumption_mt']);

                                // difference between converted production and consumption
                                $diff = $forecast[$i]['forecast'][$__yrs[$j]]['converted_production_mt'] - $forecast[$i]['forecast'][$__yrs[$j]]['consumption_mt'];

                                if ($diff < 1) {
                                    // demand out
                                    $sheet->setCellValue('J' . $row, abs($diff));
                                    $sheet->setCellValue('K' . $row, 0);
                                } else {
                                    // supply out
                                    $sheet->setCellValue('J' . $row, 0);
                                    $sheet->setCellValue('K' . $row, $diff);
                                }
                                
                                $row++;
                            }
                        }
                    } else {
                        if (sizeof($forecast[$i]['forecast']) != 0) {
                            $__yrs = array_keys($forecast[$i]['forecast']);

                            for ($j = 0; $j < sizeof($__yrs); $j++) {
                                
                                $sheet->setCellValue('B' . $row, $__yrs[$j]);
                                $sheet->setCellValue('C' . $row, $forecast[$i]['forecast'][$__yrs[$j]]['production_mt']);
                                $sheet->setCellValue('D' . $row, $forecast[$i]['forecast'][$__yrs[$j]]['converted_production_mt']);
                                $sheet->setCellValue('E' . $row, $forecast[$i]['forecast'][$__yrs[$j]]['per_capita_kg_year']);
                                $sheet->setCellValue('F' . $row, $forecast[$i]['forecast'][$__yrs[$j]]['population']);
                                $sheet->setCellValue('G' . $row, $forecast[$i]['forecast'][$__yrs[$j]]['consumption_mt']);

                                // difference between converted production and consumption
                                $diff = $forecast[$i]['forecast'][$__yrs[$j]]['converted_production_mt'] - $forecast[$i]['forecast'][$__yrs[$j]]['consumption_mt'];

                                if ($diff < 1) {
                                    // demand out
                                    $sheet->setCellValue('H' . $row, abs($diff));
                                    $sheet->setCellValue('I' . $row, 0);
                                } else {
                                    // supply out
                                    $sheet->setCellValue('H' . $row, 0);
                                    $sheet->setCellValue('I' . $row, $diff);
                                }
                                
                                $row++;
                            }
                        }
                    }
                }

                // remove blank sheets (crop)
                $sheetIndex = $excel->getIndex($excel->getSheetByName('CROP'));
                $excel->removeSheetByIndex($sheetIndex);

                // remove blank sheets (non-crop)
                $sheetIndex = $excel->getIndex($excel->getSheetByName('NON-CROP'));
                $excel->removeSheetByIndex($sheetIndex);

                // save file with its content
                $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($excel);
                $writer->setPreCalculateFormulas(true);
                $writer->save($generated);
                
                // download the file
                return response()->download($generated);
            } else {
                $chart = [];

                for ($i = 0; $i < sizeof($forecast); $i++) {
                    if ($forecast[$i]['forecast'] != 0) {

                        $commodityChart = [];
                        $commodityChart[] = ['Year', 'Production', 'Consumption'];
                        $__yrs = array_keys($forecast[$i]['forecast']);

                        for ($j = 0; $j < sizeof($__yrs); $j++) {
                            $commodityChart[] = [
                                " " . $__yrs[$j] . " ",
                                $forecast[$i]['forecast'][$__yrs[$j]]['converted_production_mt'],
                                $forecast[$i]['forecast'][$__yrs[$j]]['consumption_mt']
                            ];
                        }

                        $chart[] = [
                            $forecast[$i]['commodity'],
                            $commodityChart
                        ];
                    }
                }

                return view('dashboard.province')->with([
                    'chart' => $chart,
                    'model' => $model,
                    'province' => $province
                ]);
            }
        }
    }
}