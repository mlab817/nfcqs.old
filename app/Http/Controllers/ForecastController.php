<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ForecastController extends Controller
{
    /**
     * Generate forecast.
     *
     * @param Request $request
     */
    public function forecast(Request $request)
    {
        $cropId = $request->input('key');
        $remarks = trim($request->input('remarks'));

        // remarks is a required
        if ($remarks == '' OR $remarks == null) {
            return ['remarks' => 'Remarks is required.'];
        } elseif (strlen($remarks) > 75) {
            return ['remarks' => 'Remarks length must not exceed 75 characters.'];
        }

        $commodity = DB::table('crop')
            ->select('src_commodities.crop_type', 'crop.remarks')
            ->leftJoin('src_commodities', 'crop.src_commodity_id', '=', 'src_commodities.id')
            ->where('crop.id', $cropId)
            ->first();

        // create new copy of commodity data
        // duplicate raw data every run of forecast
        // delete null remarks once first run is completed
        $cropId = $this->duplicate($cropId, $remarks, ($commodity->crop_type == 'Crop') ? 'crop' : 'non_crop', $commodity->remarks);

        $commodity = DB::table('crop')
            ->select('crop.*', 'src_commodities.commodity', 'src_commodities.crop_type')
            ->leftJoin('src_commodities', 'crop.src_commodity_id', '=', 'src_commodities.id')
            ->where('crop.id', $cropId)
            ->first();

        if ($commodity != null) {
            if ($commodity->crop_type == 'Crop') {

                // get shifters
                $areaShifter = $request->input('area');
                $yieldShifter = $request->input('yield');
                $consumptionShifter = $request->input('consumption');

                // remove percent sign
                $areaShifter = str_replace('%', '', $areaShifter);
                $yieldShifter = str_replace('%', '', $yieldShifter);
                $consumptionShifter = str_replace('%', '', $consumptionShifter);

                // percent to decimal value
                $areaShifter = ($areaShifter == '' OR $areaShifter == null) ? 0 : $areaShifter;
                $yieldShifter = ($yieldShifter == '' OR $yieldShifter == null) ? 0 : $yieldShifter;
                $consumptionShifter = ($consumptionShifter == '' OR $consumptionShifter == null) ? 0 : $consumptionShifter;

                // rules and conditions
                $validator = Validator::make(
                    [
                        'area' => $areaShifter,
                        'yield' => $yieldShifter,
                        'consumption' => $consumptionShifter,
                    ], [
                        'area' => 'required|numeric',
                        'yield' => 'required|numeric',
                        'consumption' => 'required|numeric',
                    ]
                );

                // vaidations
                if ($validator->fails()) {
                    return $validator->errors();
                } else {

                    // delete old record
                    $deleted = DB::table('shifter')
                        ->where('crop_id', $cropId)
                        ->delete();

                    if ($areaShifter != 0 OR $yieldShifter != 0 OR $consumptionShifter != 0) {

                        // insert new record
                        $inserted = DB::table('shifter')
                            ->insertGetId([
                                'crop_id' => $cropId,
                                'area' => ($areaShifter != 0) ? $areaShifter / 100 : 0,
                                'yield' => ($yieldShifter != 0) ? $yieldShifter / 100 : 0,
                                'consumption' => ($consumptionShifter != 0) ? $consumptionShifter / 100 : 0,
                                'production' => 0,
                            ]);
                    }
                }

                // forecast year will start right after 
                // the last  actual data
                $year = DB::table('crop_data')
                    ->where('crop_id', $cropId)
                    ->where('harvested_area_ha', '<>', 0)
                    ->where('production_mt', '<>', 0)
                    ->orderBy('year', 'DESC')
                    ->first();

                # Delete Old Result
                DB::table('crop_forecast')
                    ->where('crop_id', $cropId)
                    ->delete();
                
                # Logarithmic Time Trend
                $this->logarithmicTimeTrendProduction($cropId, $year->year, 'crop');
                $this->logAgrConsumption($cropId, 'crop', 1);

                # Annualized Growth Rate
                $this->annualizedGrowthRateProduction($cropId, $year->year, 'crop');
                $this->logAgrConsumption($cropId, 'crop', 2);

                # Auto ARIMA
                $this->autoArima($cropId, 'crop');
                $this->getAutoArimaResult($cropId, 'crop');

            } else {

                // get shifters
                $productionShifter = $request->input('production');
                $consumptionShifter = $request->input('consumption');

                // remove percent sign
                $productionShifter = str_replace('%', '', $productionShifter);
                $consumptionShifter = str_replace('%', '', $consumptionShifter);

                // percent to decimal value
                $productionShifter = ($productionShifter == '' OR $productionShifter == null) ? 0 : $productionShifter;
                $consumptionShifter = ($consumptionShifter == '' OR $consumptionShifter == null) ? 0 : $consumptionShifter;

                // rules and conditions
                $validator = Validator::make(
                    [
                        'production' => $productionShifter,
                        'consumption' => $consumptionShifter,
                    ], [
                        'production' => 'required|numeric',
                        'consumption' => 'required|numeric',
                    ]
                );

                // vaidations
                if ($validator->fails()) {
                    return $validator->errors();
                } else {

                    // delete old record
                    $deleted = DB::table('shifter')
                        ->where('crop_id', $cropId)
                        ->delete();

                    if ($productionShifter != 0 OR $consumptionShifter != 0) {

                        // insert new record
                        $inserted = DB::table('shifter')
                            ->insertGetId([
                                'crop_id' => $cropId,
                                'production' => ($productionShifter != 0) ? $productionShifter / 100 : 0,
                                'consumption' => ($consumptionShifter != 0) ? $consumptionShifter / 100 : 0,
                                'area' => 0,
                                'yield' => 0,
                            ]);
                    }
                }

                // forecast year will start right after 
                // the last  actual data
                $year = DB::table('non_crop_data')
                    ->where('crop_id', $cropId)
                    ->where('production_mt', '<>', 0)
                    ->orderBy('year', 'DESC')
                    ->first();

                # Delete Old Result
                DB::table('non_crop_forecast')
                    ->where('crop_id', $cropId)
                    ->delete();

                # Logarithmic Time Trend
                $this->logarithmicTimeTrendProduction($cropId, $year->year, 'non_crop');
                $this->logAgrConsumption($cropId, 'non_crop', 1);

                # Annualized Growth Rate
                $this->annualizedGrowthRateProduction($cropId, $year->year, 'non_crop');
                $this->logAgrConsumption($cropId, 'non_crop', 2);

                # Auto ARIMA
                $this->autoArima($cropId, 'non_crop');
                $this->getAutoArimaResult($cropId, 'non_crop');

            }
        }

        return "Forecast data successfully generated!";
    }

    /**
     * Duplicate crop raw data.
     * 
     * crop
     * crop_annualized_growth_rate  / non_crop_annualized_growth_rate
     * crop_data                    / non_crop_data
     * crop_slope                   / non_crop_slope
     * population
     * population_growth_rate
     * 
     *
     * @param Integer $cropId
     * @param String $remarks
     * @param String $type
     * @param Object $oldRemarks
     * 
     * @return Integer $cropId
     */
    private function duplicate($cropId, $remarks, $type, $oldRemarks)
    {
        // crop 
        // ===========================
        $crop = DB::table('crop')
            ->where('id', $cropId)
            ->first();
        
        // do some changes to data
        unset($crop->id);
        $crop->remarks = $remarks;

        // insert new data
        $newCropId = DB::table('crop')
            ->insertGetId((array) $crop);
        // ===========================



        // crop_annualized_growth_rate
        // non_crop_annualized_growth_rate
        // ===========================
        $agr = DB::table($type . '_annualized_growth_rate')
            ->where('crop_id', $cropId)
            ->first();
        
        // do some changes to data
        unset($agr->id);
        $agr->crop_id = $newCropId;

        // insert new data
        DB::table($type . '_annualized_growth_rate')
            ->insert((array) $agr);
        // ===========================



        // crop_slope
        // non_crop_slope
        // ===========================
        $slope = DB::table($type . '_slope')
            ->where('crop_id', $cropId)
            ->first();

        // do some changes to data
        unset($slope->id);
        $slope->crop_id = $newCropId;

        // insert new data
        DB::table($type . '_slope')
            ->insert((array) $slope);
        // ===========================



        // crop_data
        // non_crop_data
        // ===========================
        $data = DB::table($type . '_data')
            ->where('crop_id', $cropId)
            ->get();

        foreach ($data as $key => $val) {

            // do some changes to data
            unset($val->id);
            $val->crop_id = $newCropId;
            
            // insert new data
            DB::table($type . '_data')
                ->insert((array) $val);
        }
        // ===========================



        // population
        // ===========================
        $data = DB::table('population')
            ->where('crop_id', $cropId)
            ->get();

        foreach ($data as $key => $val) {

            // do some changes to data
            unset($val->id);
            $val->crop_id = $newCropId;
            
            // insert new data
            DB::table('population')
                ->insert((array) $val);
        }
        // ===========================



        // population_growth_rate
        // ===========================
        $data = DB::table('population_growth_rate')
            ->where('crop_id', $cropId)
            ->get();

        foreach ($data as $key => $val) {

            // do some changes to data
            unset($val->id);
            $val->crop_id = $newCropId;
            
            // insert new data
            DB::table('population_growth_rate')
                ->insert((array) $val);
        }
        // ===========================



        // delete old crop record
        // ===========================
        if ($oldRemarks == null) {
            DB::table('crop')->where('id', $cropId)->delete();
            DB::table($type . '_annualized_growth_rate')->where('crop_id', $cropId)->delete();
            DB::table($type . '_slope')->where('crop_id', $cropId)->delete();
            DB::table($type . '_data')->where('crop_id', $cropId)->delete();
            DB::table('population')->where('crop_id', $cropId)->delete();
            DB::table('population_growth_rate')->where('crop_id', $cropId)->delete();
        }
        // ===========================



        // copy files
        // ===========================
        $area = 'uploads/commodity-data/auto-arima/input/area-' . $cropId . '.csv';
        $yield = 'uploads/commodity-data/auto-arima/input/yield-' . $cropId . '.csv';
        $production = 'uploads/commodity-data/auto-arima/input/production-' . $cropId . '.csv';
        
        $__area = 'uploads/commodity-data/auto-arima/input/area-' . $newCropId . '.csv';
        $__yield = 'uploads/commodity-data/auto-arima/input/yield-' . $newCropId . '.csv';
        $__production = 'uploads/commodity-data/auto-arima/input/production-' . $newCropId . '.csv';

        if (file_exists($area)) {
            copy($area, $__area);
        }

        if (file_exists($yield)) {
            copy($yield, $__yield);
        }

        if (file_exists($production)) {
            copy($production, $__production);
        }
        // ===========================



        return $newCropId;
    }
    
    /**
     * Logarithmic Time Trend
     * for production forecast.
     *
     * @param int $cropId
     * @param int $year
     * @param string $table
     */
    private function logarithmicTimeTrendProduction(int $cropId, int $year, string $table)
    {
        // slope values
        $slope = DB::table($table . '_slope')
            ->where('crop_id', $cropId)
            ->first();

        // details of the crop
        $actual = DB::table($table . '_data')
            ->where('crop_id', $cropId)
            ->where('year', $year)
            ->first();

        // get all years to forecast
        $years = DB::table('population')
            ->select('year', 'population')
            ->where('crop_id', $cropId)
            ->where('year', '>', $year)
            ->orderBy('year', 'ASC')
            ->get();

        // get shifter value
        $shifter = DB::table('shifter')
            ->where('crop_id', $cropId)
            ->first();

        // shifters
        $areaShifter = ($shifter != null) ? $shifter->area : 0;
        $yieldShifter = ($shifter != null) ? $shifter->yield : 0;
        $productionShifter = ($shifter != null) ? $shifter->production : 0;

        if ($table == 'crop') {

            // get commodity seed ratio
            $commodity = DB::table('crop')
                ->select('seed_ratio')
                ->leftJoin('src_commodities', 'crop.src_commodity_id', '=', 'src_commodities.id')
                ->where('crop.id', $cropId)
                ->first();

            // start values
            $area = $actual->harvested_area_ha;
            $yield = $actual->yield_mt_ha;

            // start forecasting
            if (sizeof($years) != 0) {
                foreach ($years as $key) {

                    // forecast values
                    $area = $area * (1 + $slope->area + $areaShifter);
                    $yield = $yield * (1 + $slope->yield + $yieldShifter);
                    $production = $area * $yield;

                    // forecast production
                    // yield minus seed ratio
                    $pSeedRatio = $area * ($yield - $commodity->seed_ratio);
                    
                    // save forecast values
                    $inserted = DB::table($table . '_forecast')
                        ->insert([ 
                            'crop_id' => $cropId,
                            'model' => 1,
                            'year' => $key->year,
                            'area' => $area,
                            'yield' => $yield,
                            'production' => $production,
                            'p_seed_ratio' => $pSeedRatio,
                            'per_capita_consumption_kg_yr' => 0,
                            'consumption' => 0
                        ]);

                }
            }
        } else {

            // start values
            $production = $actual->production_mt;

            // start forecasting
            if (sizeof($years) != 0) {
                foreach ($years as $key) {

                    // forecast values
                    $production = $production * (1 + $slope->production + $productionShifter);

                    // save forecast values
                    $inserted = DB::table($table . '_forecast')
                        ->insert([ 
                            'crop_id' => $cropId,
                            'model' => 1,
                            'year' => $key->year,
                            'production' => $production,
                            'per_capita_consumption_kg_yr' => 0,
                            'consumption' => 0
                        ]);
                }
            }
        }
    }

    /**
     * Annualized Growth Rate
     * for production forecast.
     *
     * @param int       $cropId
     * @param int       $year
     * @param string    $table
     */
    private function annualizedGrowthRateProduction($cropId, $year, $table)
    {
        // annualized growth rate values
        $agr = DB::table($table . '_annualized_growth_rate')
            ->where('crop_id', $cropId)
            ->first();

        // details of the crop
        $actual = DB::table($table . '_data')
            ->where('crop_id', $cropId)
            ->where('year', $year)
            ->first();

        // get all years to forecast
        $years = DB::table('population')
            ->select('year', 'population')
            ->where('crop_id', $cropId)
            ->where('year', '>', $year)
            ->orderBy('year', 'ASC')
            ->get();

        // get shifter value
        $shifter = DB::table('shifter')
            ->where('crop_id', $cropId)
            ->first();

        // shifters
        $areaShifter = ($shifter != null) ? $shifter->area : 0;
        $yieldShifter = ($shifter != null) ? $shifter->yield : 0;
        $productionShifter = ($shifter != null) ? $shifter->production : 0;

        if ($table == 'crop') {

            // get commodity seed ratio
            $commodity = DB::table('crop')
                ->select('seed_ratio')
                ->leftJoin('src_commodities', 'crop.src_commodity_id', '=', 'src_commodities.id')
                ->where('crop.id', $cropId)
                ->first();

            // start values
            $area = $actual->harvested_area_ha;
            $yield = $actual->yield_mt_ha;
            $production = $area * $yield;

            // start forecasting
            if (sizeof($years) != 0) {
                foreach ($years as $key) {

                    // forecast values
                    $area = $area * (1 + $agr->area + $areaShifter);
                    $yield = $yield * (1 + $agr->yield + $yieldShifter);
                    $production = $area * $yield;

                    // forecast production
                    // yield minus seed ratio
                    $pSeedRatio = $area * ($yield - $commodity->seed_ratio);
                    
                    // save forecast values
                    $inserted = DB::table($table . '_forecast')
                        ->insert([ 
                            'crop_id' => $cropId,
                            'model' => 2,
                            'year' => $key->year,
                            'area' => $area,
                            'yield' => $yield,
                            'production' => $production,
                            'p_seed_ratio' => $pSeedRatio,
                            'per_capita_consumption_kg_yr' => 0,
                            'consumption' => 0
                        ]);

                }
            }
        } else {

            // start values
            $production = $actual->production_mt;

            // start forecasting
            if (sizeof($years) != 0) {
                foreach ($years as $key) {

                    // forecast values
                    $production = $production * (1 + $agr->production + $productionShifter);

                    // save forecast values
                    $inserted = DB::table($table . '_forecast')
                        ->insert([ 
                            'crop_id' => $cropId,
                            'model' => 2,
                            'year' => $key->year,
                            'production' => $production,
                            'per_capita_consumption_kg_yr' => 0,
                            'consumption' => 0
                        ]);

                }
            }
        }
    }

    /**
     * Logarithmic Time Trend & Annualized Growth Rate
     * for consumption forecast.
     *
     * @param int       $cropId
     * @param string    $table
     * @param int       $model
     */
    private function logAgrConsumption($cropId, $table, $model)
    {
        // slope values
        $slope = DB::table($table . '_slope')
            ->where('crop_id', $cropId)
            ->first();

        // annualized growth rate values
        $agr = DB::table($table . '_annualized_growth_rate')
            ->where('crop_id', $cropId)
            ->first();

        // last actual given data
        $actual = DB::table('crop')
            ->select('per_capita_year as year', 'per_capita_consumption_kg_yr')
            ->where('id', $cropId)
            ->first();

        // get all years to forecast
        $years = DB::table('population')
            ->select('year', 'population')
            ->where('crop_id', $cropId)
            ->where('year', '>', $actual->year)
            ->orderBy('year', 'ASC')
            ->get();

        // forecast per capita consumption
        $perCapitaConsumption = $actual->per_capita_consumption_kg_yr;

        // get shifter value
        $shifter = DB::table('shifter')
            ->where('crop_id', $cropId)
            ->first();

        // consumption shifter
        $consumptionShifter = ($shifter != null) ? $shifter->consumption : 0;

        // start forecasting
        if (sizeof($years) != 0) {
            foreach ($years as $key) {

                // forecast per capita consumption
                $perCapitaConsumption = ($model == 1) ? $perCapitaConsumption * (1 + $slope->consumption + $consumptionShifter) : $perCapitaConsumption * (1 + $agr->consumption + $consumptionShifter);
                
                // compute consumption in metric tone
                $consumption = $perCapitaConsumption / 1000 * $key->population;

                // save forecast values
                $saved = DB::table($table . '_forecast')
                    ->where([
                        'crop_id' => $cropId,
                        'model' => $model,
                        'year' => $key->year,
                    ])
                    ->update([ 
                        'per_capita_consumption_kg_yr' => $perCapitaConsumption,
                        'consumption' => $consumption
                    ]);
            }
        }
    }

    /**
     * AUTO ARIMA. Where the IP address of the 
     * Windows Server is 115.146.161.125
     *
     * @param int       $cropId
     * @param string    $table
     */
    private function autoArima($cropId, $table)
    {
        if ($table == 'crop') {
            
            // run auto-arima using r
            // from windows-based server
            $url = 'http://115.146.161.125/nfcqs/app.php?type=crop&area=area-' . $cropId . '.csv&yield=yield-' . $cropId . '.csv';
            file_get_contents($url);

            // download the generated result
            // from windows-based server
            $area = "http://115.146.161.125/nfcqs/output/area-"  . $cropId .  ".csv";
            $yield = "http://115.146.161.125/nfcqs/output/yield-"  . $cropId .  ".csv";

            file_put_contents("uploads/commodity-data/auto-arima/output/area-" . $cropId . ".csv", fopen($area, 'r'));
            file_put_contents("uploads/commodity-data/auto-arima/output/yield-" . $cropId . ".csv", fopen($yield, 'r'));

        } else {
            
            // run auto-arima using r
            // from windows-based server
            $url = 'http://115.146.161.125/nfcqs/app.php?type=non-crop&production=production-' . $cropId . '.csv';
            file_get_contents($url);

            // download the generated result
            // from windows-based server
            $production = "http://115.146.161.125/nfcqs/output/production-"  . $cropId .  ".csv";
            file_put_contents("uploads/commodity-data/auto-arima/output/production-" . $cropId . ".csv", fopen($production, 'r'));

        }
    }

    /**
     * Get the result of AUTO ARIMA.
     *
     * @param int       $cropId
     * @param string    $table
     */
    private function getAutoArimaResult($cropId, $table)
    {
        $data = [];

        if ($table == 'crop') {

            // result file
            $aPath = '/home/nfcqs/public_html/public/uploads/commodity-data/auto-arima/output/area-' . $cropId . '.csv';
            $yPath = '/home/nfcqs/public_html/public/uploads/commodity-data/auto-arima/output/yield-' . $cropId . '.csv';

            // get shifter value
            $shifter = DB::table('shifter')
                ->where('crop_id', $cropId)
                ->first();

            // max year with actual data
            // only those years that columns
            // `harvested_area_ha` & `production_mt`
            // is not zero
            $actual = DB::table('crop_data')
                ->where('crop_id', $cropId)
                ->where('harvested_area_ha', '<>', 0)
                ->where('production_mt', '<>', 0)
                ->orderBy('year', 'DESC')
                ->first();

            // get population forecast
            // year after observed data
            $yearsProduction = DB::table('population')
                ->where('crop_id', $cropId)
                ->where('year', '>', $actual->year)
                ->get();

            // reading *area* data in csv format
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv;
            $excel = $reader->load($aPath);

            // set active sheet
            $excel->setActiveSheetIndex(0);
            $sheet = $excel->getActiveSheet();

            // last row of data
            $lastRow = $excel->getActiveSheet()->getHighestRow();

            // data begins at row 2
            $row = 2;

            if (sizeof($yearsProduction) != 0) {
                foreach ($yearsProduction as $key) {
                    if ($row <= $lastRow) {
                    
                        $d = [
                            'year' => $key->year,
                            'area' => $sheet->getCell('B' . $row)->getValue(),
                            'yield' => 0,
                            'production' => 0,

                            // growth rate
                            'area_growth_rate' => 0,
                            'yield_growth_rate' => 0,

                            // average value
                            'area_ave' => 0,
                            'yield_ave' => 0,

                        ];

                        $data[] = $d;
                        $row++;

                    } else {
                        break;
                    }
                } 
            }

            // reading *yield* data in csv format
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv;
            $excel = $reader->load($yPath);

            // set active sheet
            $excel->setActiveSheetIndex(0);
            $sheet = $excel->getActiveSheet();

            // last row of data
            $lastRow = $excel->getActiveSheet()->getHighestRow();

            // data begins at row 2
            $row = 2;

            if (sizeof($data) != 0) {
                for ($i = 0; $i < sizeof($data); $i++) {
                    if ($row <= $lastRow) {
                        $data[$i]['yield'] = $sheet->getCell('B' . $row)->getValue();
                    } else {
                        break;
                    }

                    $row++;
                }
            }

            // average growth rate
            $aveGrowthRateArea = 0;
            $aveGrowthRateYield = 0;
            $count = 0;

            // shifters
            $areaShifter = ($shifter != null) ? $shifter->area : 0;
            $yieldShifter = ($shifter != null) ? $shifter->area : 0;

            // compute growth rate
            if (sizeof($data) != 0) {
                for ($i = 1; $i < sizeof($data); $i++) {

                    // previous index
                    $preIndex = $i - 1;

                    // difference of value for current & previous year
                    $diffArea = $data[$i]['area'] - $data[$preIndex]['area'];
                    $diffYield = $data[$i]['yield'] - $data[$preIndex]['yield'];

                    // get growth rate
                    $data[$i]['area_growth_rate'] = ($diffArea != 0) ? $areaShifter + ($diffArea / $data[$preIndex]['area']) : 0;
                    $data[$i]['yield_growth_rate'] = ($diffYield != 0) ? $yieldShifter + ($diffYield / $data[$preIndex]['yield']) : 0;

                    // average growth rate
                    $aveGrowthRateArea += $data[$i]['area_growth_rate'];
                    $aveGrowthRateYield += $data[$i]['yield_growth_rate'];
                    $count++;

                }
            }

            // compute average growth rate
            $aveGrowthRateArea = ($aveGrowthRateArea != 0) ? $aveGrowthRateArea / $count : 0;
            $aveGrowthRateYield = ($aveGrowthRateYield != 0) ? $aveGrowthRateYield / $count : 0;

            // initial values
            $aveArea = $actual->harvested_area_ha;
            $aveYield = $actual->yield_mt_ha;

            // compute average growth rate per year 
            // a year after the last given data
            if (sizeof($data) != 0) {
                for ($i = 0; $i < sizeof($data); $i++) {

                    $aveArea = $aveArea * (1 + $aveGrowthRateArea);
                    $aveYield = $aveYield * (1 + $aveGrowthRateYield);

                    $data[$i]['area_ave'] = $aveArea;
                    $data[$i]['yield_ave'] = $aveYield;

                }
            }
            
            // save forecast production data
            if (sizeof($data) != 0) {
                for ($i = 0; $i < sizeof($data); $i++) {

                    // save the data
                    DB::table('crop_forecast')
                        ->insert([
                            'crop_id' => $cropId,
                            'model' => 3,
                            'year' => $data[$i]['year'],
                            
                            # 'area' => $data[$i]['area'],
                            # 'yield' => $data[$i]['yield'],
                            # 'production' => $data[$i]['area'] * $data[$i]['yield'],

                            'area' => $data[$i]['area_ave'],
                            'yield' => $data[$i]['yield_ave'],
                            'production' => $data[$i]['area_ave'] * $data[$i]['yield_ave'],

                            // arima does not compute production
                            // with seed ratio variable
                            'p_seed_ratio' => 0,

                            // arima does not compute consumption
                            'per_capita_consumption_kg_yr' => 0,
                            'consumption' => 0

                        ]);
                }
            }

        } else {

            // result file
            $pPath = '/home/nfcqs/public_html/public/uploads/commodity-data/auto-arima/output/production-' . $cropId . '.csv';

            // get shifter value
            $shifter = DB::table('shifter')
                ->where('crop_id', $cropId)
                ->first();

            // max year in the observed data
            // only those years that column
            // `production_mt` is not zero
            $actual = DB::table('non_crop_data')
                ->where('crop_id', $cropId)
                ->where('production_mt', '<>', 0)
                ->orderBy('year', 'DESC')
                ->first();

            // get population forecast
            // year after observed data
            $yearsProduction = DB::table('population')
                ->where('crop_id', $cropId)
                ->where('year', '>', $actual->year)
                ->get();

            // reading *production* data in csv format
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv;
            $excel = $reader->load($pPath);

            // set active sheet
            $excel->setActiveSheetIndex(0);
            $sheet = $excel->getActiveSheet();

            // last row of data
            $lastRow = $excel->getActiveSheet()->getHighestRow();

            // data begins at row 2
            $row = 2;

            if (sizeof($yearsProduction) != 0) {
                foreach ($yearsProduction as $key) {
                    if ($row <= $lastRow) {
                    
                        $d = [
                            'year' => $key->year,
                            'production' => $sheet->getCell('B' . $row)->getValue(),
                            'production_growth_rate' => 0,
                        ];

                        $data[] = $d;
                        $row++;

                    } else {
                        break;
                    }
                } 
            }

            // average growth rate
            $aveGrowthRateProduction = 0;
            $count = 0;

            // production shifter
            $productionShifter = ($shifter != null) ? $shifter->production : 0;

            // compute growth rate
            if (sizeof($data) != 0) {
                for ($i = 1; $i < sizeof($data); $i++) {
                    
                    // previous index
                    $preIndex = $i - 1;

                    // difference of value for current & previous year
                    $diffProduction = $data[$i]['production'] - $data[$preIndex]['production'];

                    // get growth rate
                    $data[$i]['production_growth_rate'] = ($diffProduction != 0) ? $productionShifter + ($diffProduction / $data[$preIndex]['production']) : 0;

                    // average growth rate
                    $aveGrowthRateProduction += $data[$i]['production_growth_rate'];
                    $count++;

                }
            }

            // compute average growth rate
            $aveGrowthRateProduction = ($aveGrowthRateProduction != 0) ? $aveGrowthRateProduction / $count : 0;

            // last actual production data
            $production = $actual->production_mt;

            // save forecast production data
            if (sizeof($data) != 0) {
                for ($i = 0; $i < sizeof($data); $i++) {

                    // compute new production value
                    $production = $production * (1 + $aveGrowthRateProduction);

                    // save the data
                    DB::table('non_crop_forecast')
                        ->insert([
                            'crop_id' => $cropId,
                            'model' => 3,
                            'year' => $data[$i]['year'],
                            'production' => $production,

                            // arima does not compute consumption
                            'per_capita_consumption_kg_yr' => 0,
                            'consumption' => 0

                        ]);
                }
            }
        }
    }

    /**
     * Get index of the value
     * given from 2D array.
     *
     * @param array $data
     * @param string $key
     * @param $val
     */
    private function getIndex($data = [], $key = '', $val)
    {
        if (sizeof($data) != 0) {
            for ($i = 0; $i < sizeof($data); $i++) {
                if ($data[$i][$key] == $val) {
                    return $i;
                }
            }
        }

        return -1;
    }
}