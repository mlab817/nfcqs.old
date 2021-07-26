<?php

namespace App\Http\Controllers;

use App\Imports\CommodityDataImport;
use App\Imports\PopulationDataImport;
use App\Models\Crop;
use App\Models\Population;
use App\Models\SrcCommodity;
use App\Models\SrcProvince;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Reader\Csv;

class InputController extends Controller
{
    /**
	 * List of commodities
     * by province.
	 *
	 * @param  Request
	 */
	public function commodities(Request $request)
	{
        $provinces = SrcProvince::with('crops')->whereHas('crops', function ($query) {
            $query->where('user_id', auth()->id());
        })->get();

        return view('input.commodities')->with([
            'data' => $provinces
        ]);
    }

    /**
	 * Add commodity.
	 *
	 * @param  Request
	 */
	public function addCommodity(Request $request)
	{
        $commodities = SrcCommodity::all('id','commodity');
        $provinces = SrcProvince::all('id','province');

        return view('input.add')->with([
            'commodities' => $commodities->mapWithKeys(function ($c) { return [$c->id => $c->commodity]; })->prepend('Select Commodity',''),
            'provinces' => $provinces->mapWithKeys(function ($c) { return [$c->id => $c->province]; })->prepend('Select Province', ''),
        ]);
    }

    /**
	 * Save commodity.
	 *
	 * @param  Request
	 */
	public function saveCommodity(Request $request)
	{
	    $data = $request->all();
	    $data['population'] = str_replace(',', '', $request->population);

	    $validator = Validator::make($data, [
            'commodity_id'      => 'required|exists:src_commodities,id',
            'conversion_rate'   => 'required|numeric|min:0|max:100',
            'province_id'       => 'required|exists:src_provinces,id',
            'population'        => 'required|integer',
            'year'              => 'required|integer|min:1900|max:'.date('Y'),
            'per_capita'        => 'required|numeric|min:0',
            'per_capita_year'   => 'required|numeric|min:1900|max:'.date('Y'),
            'commodity_data'    => 'required|mimes:csv,txt',
            'pop_growth_rate'   => 'required|mimes:csv,txt'
        ]);

	    if ($validator->fails()) {
	        return $validator->errors();
        }

        $commodityId = $request->commodity_id;
        $commodity = SrcCommodity::find($commodityId);

        $conversionRate = $request->conversion_rate;

        $provinceId = $request->province_id;
        $province = SrcProvince::find($provinceId);

        $population = $request->population;
        $year = $request->year;
        $perCapita = $request->per_capita;
        $perCapitaYear = $request->per_capita_year;

        // remove commas & percent sign to number
        $population = str_replace(',', '', $population);
        $conversionRate = str_replace('%', '', $conversionRate);
        
        // files
        $commodityData = $request->file('commodity_data');
        $popGrowthRate = $request->file('pop_growth_rate');

        // file repo destination
        $commodityDest = Storage::putFileAs('/public/uploads/commodity-data', $commodityData,  Str::snake($province->province) . '_' . Str::snake($commodity->commodity) . '-' . Str::random(6) . '.csv');
        $popGrowthDest = Storage::putFileAs('/public/uploads/pop-growth-rate', $popGrowthRate, Str::snake($province->province) . '_' . Str::snake($commodity->commodity) . '-' . Str::random(6) . '.csv');

        // identify type of crop
        $typeCrop = SrcCommodity::find($commodityId);

//        dd($request->except('crop_data_filename','pop_data_filename'));

        // create crop
        $crop = auth()->user()->crops()->create([
            'src_commodity_id' => $request->commodity_id,
            'conversion_rate' => $request->conversion_rate,
            'src_province_id' => $request->province_id,
            'population' => $request->population,
            'year' => $request->year,
            'per_capita' => $request->per_capita,
            'per_capita_year' => $request->per_capita_year,
            'commodity_data' => $request->commodity_data,
            'pop_growth_rate' => $request->pop_growth_rate,
            'crop_data_filename' => $commodityDest,
            'pop_data_filename' => $popGrowthDest
        ]);

        $this->importCommodityData($commodityData, $crop->id, $conversionRate, $typeCrop->crop_type);

        // TODO: Save data to database
        $this->handlePopulationProjection($population, $crop->id, $request->file('pop_growth_rate'));

        $this->runModelsInPython($commodityData, $crop->id);

//
//        // save population
        $crop->populations()->create([
            'year' => $year,
            'population' => $population
        ]);


        // import commodity data
        $this->importCommodityData($commodityData, $crop->id, $conversionRate, $typeCrop->crop_type);

        if ($typeCrop->crop_type == 'crops') {

            // compute slope
            $slopeArea = $this->calculateSlope($crop->id, 'crop_data', 'ln_area');
            $slopeYield = $this->calculateSlope($crop->id, 'crop_data', 'ln_yield');
            $slopeConsumption = $this->calculateSlope($crop->id, 'crop_data', 'ln_consumption');

            // save slope
            DB::table('crop_slope')
                ->insert([
                    'crop_id' => $crop->id,
                    'area' => $slopeArea,
                    'yield' => $slopeYield,
                    'consumption' => $slopeConsumption
                ]);

            // compute annualize growth rate
            $agrArea = $this->calculateAnnGrowthRate($crop->id, 'crop_data', 'harvested_area_ha');
            $agrYield = $this->calculateAnnGrowthRate($crop->id, 'crop_data', 'yield_mt_ha');
            $agrConsumption = $this->calculateAnnGrowthRate($crop->id, 'crop_data', 'per_capita_consumption_kg_yr');

            // save anualize growth rate
            DB::table('crop_annualized_growth_rate')
                ->insert([
                    'crop_id' => $crop->id,
                    'area' => $agrArea,
                    'yield' => $agrYield,
                    'consumption' => $agrConsumption
                ]);

        } elseif ($typeCrop->crop_type == 'Non-crops') {

            // compute slope
            $slopeProduction = $this->calculateSlope($crop->id, 'non_crop_data', 'ln_production');
            $slopeConsumption = $this->calculateSlope($crop->id, 'non_crop_data', 'ln_consumption');

            // save slope
            DB::table('non_crop_slope')
                ->insert([
                    'crop_id' => $crop->id,
                    'production' => $slopeProduction,
                    'consumption' => $slopeConsumption
                ]);

            // compute annualize growth rate
            $agrProduction = $this->calculateAnnGrowthRate($crop->id, 'non_crop_data', 'production_mt');
            $agrConsumption = $this->calculateAnnGrowthRate($crop->id, 'non_crop_data', 'per_capita_consumption_kg_yr');

            // save anualize growth rate
            DB::table('non_crop_annualized_growth_rate')
                ->insert([
                    'crop_id' => $crop->id,
                    'production' => $agrProduction,
                    'consumption' => $agrConsumption
                ]);

        }
//
//        // import population growth rate
//        $this->importPopGrowthRate($popGrowthDest, $crop->id, $population);
//
//        // create file source for auto-arima model
        $this->createAutoArimaSrcData($crop->id, $typeCrop->crop_type);

        return "Successfully saved.";
    }

    /**
     * Import commodity data.
     *
     * @param [type] $commodityData
     * @param [type] $cropId
     * @param [type] $rate
     * @param [type] $cropType
     */
    private function importCommodityData($path, $cropId, $rate, $cropType)
    {
        $crop = Crop::find($cropId);

        $data = Excel::toArray(new CommodityDataImport, $path);

        $commodityData = collect([]);

        if ($cropType == 'crops') {
            foreach ($data[0] as $row) {
                if (strtolower($row[0]) != 'year') {
                    $area = (float) str_replace(',','',$row[1]);
                    $production = (float) str_replace(',','',$row[2]);
                    $consumption = (float) str_replace(',','',$row[3]);
                    $yield = round((float) $production / $area, 2) ?? null;

                    // apply conversion rate upon validation
                    $commodityData->push([
                        'year'          => (int) $row[0],
                        'harvested_area_ha'          => $area,
                        'production_mt'    => $production,
                        'yield_mt_ha'         => $yield,
                        'converted_area' => $area * $rate,
                        'converted_production' => $production * $rate,
                        'converted_yield' => $yield * $rate,
                        'per_capita_consumption_kg_year'    => $consumption,
                        'ln_area'       => log($area),
                        'ln_yield'      => log($yield),
                        'ln_consumption'=> (float) log($consumption),
                    ]);
                }
            }

            foreach ($commodityData as $item) {
                $crop->crop_data()->create($item);
            }
        } else {
            // no data
            foreach ($data[0] as $row) {
                if (strtolower($row[0]) != 'year') {
                    $production = (float)  str_replace(',','',$row[1]);
                    $consumption = (float) str_replace(',','',$row[2]);

                    // apply conversion rate upon validation
                    $commodityData->push([
                        'year'          => (int) $row[0],
                        'production_mt' => $production,
                        'converted_production' => $production * $rate,
                        'per_capita_consumption_kg_year' => $consumption,
                        'ln_production' => log($production),
                        'ln_consumption' => log($consumption),
                    ]);
                }
            }

            foreach ($commodityData as $item) {
                $crop->non_crop_data()->create($item);
            }
        }
    }

    /**
     * Call Run LTT backend
     *
     * TODO: ensure that this data is received by backend
     */
    private function runModelsInPython($file, $cropId)
    {
        $url = config('nfcqs.PYTHON_APP');

        Http::attach('file', $file)->post($url, [
            'user_id' => auth()->id(),
            'crop_id' => $cropId,
        ]);
    }

    /**
     * Generate source data for AUTO ARIMA
     *
     * @param [type] $cropId
     * @param [type] $cropType
     */
    private function createAutoArimaSrcData($cropId, $cropType)
    {
        if ($cropType == 'crops') {

            // file path
            $areaPath = 'uploads/commodity-data/auto-arima/input/area-' . $cropId . '.csv';
            $yieldPath = 'uploads/commodity-data/auto-arima/input/yield-' . $cropId . '.csv';
            $consumptionPath = 'uploads/commodity-data/auto-arima/input/consumption-' . $cropId . '.csv';

            // initialize
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
            
            // create blank files
            $writer->save($areaPath);
            $writer->save($yieldPath);
            $writer->save($consumptionPath);
            
            // get crop data
            $data = DB::table('crop_data')
                ->where('crop_id', $cropId)
                ->orderBy('year', 'ASC')
                ->get();

            if (sizeof($data) != 0) {

                // populate data to area
                $reader = new Csv;
                $excel = $reader->load($areaPath);
                $excel->setActiveSheetIndex(0);
                $sheet = $excel->getActiveSheet();
                $row = 2;

                // set headers
                $sheet->setCellValue('A1', 'YEAR');
                $sheet->setCellValue('B1', 'AREA');

                // set file content
                foreach ($data as $key) {

                    // only if harvested area is not zero
                    if ($key->harvested_area_ha != 0) {

                        $sheet->setCellValue('A' . $row, $key->year);
                        $sheet->setCellValue('B' . $row, $key->harvested_area_ha);
                        $row++;

                    }
                }

                // save the file
                $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($excel);
                $writer->setEnclosure('');
        	    $writer->save($areaPath);

                // populate data to yield
                $reader = new Csv;
                $excel = $reader->load($yieldPath);
                $excel->setActiveSheetIndex(0);
                $sheet = $excel->getActiveSheet();
                $row = 2;

                // set headers
                $sheet->setCellValue('A1', 'YEAR');
                $sheet->setCellValue('B1', 'YIELD');

                // set file content
                foreach ($data as $key) {

                    // only if yield is not zero
                    if ($key->yield_mt_ha != 0) {

                        $sheet->setCellValue('A' . $row, $key->year);
                        $sheet->setCellValue('B' . $row, $key->yield_mt_ha);
                        $row++;

                    }
                }

                // save the file
                $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($excel);
                $writer->setEnclosure('');
                $writer->save($yieldPath);

                // populate data to consumption
                $reader = new Csv;
                $excel = $reader->load($consumptionPath);
                $excel->setActiveSheetIndex(0);
                $sheet = $excel->getActiveSheet();
                $row = 2;

                // set headers
                $sheet->setCellValue('A1', 'YEAR');
                $sheet->setCellValue('B1', 'CONSUMPTION');

                // set file content
                foreach ($data as $key) {

                    // only if per capita consumption is not zero
                    if ($key->per_capita_consumption_kg_yr != 0) {

                        $sheet->setCellValue('A' . $row, $key->year);
                        $sheet->setCellValue('B' . $row, $key->per_capita_consumption_kg_yr);
                        $row++;

                    }
                }

                // save the file
                $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($excel);
                $writer->setEnclosure('');
                $writer->save($consumptionPath);
                
            }
        } else {

            // file path
            $productionPath = 'uploads/commodity-data/auto-arima/input/production-' . $cropId . '.csv';
            $consumptionPath = 'uploads/commodity-data/auto-arima/input/consumption-' . $cropId . '.csv';

            // initialize
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
            
            // create blank file
            $writer->save($productionPath);
            $writer->save($consumptionPath);
            
            // get crop data
            $data = DB::table('non_crop_data')
                ->where('crop_id', $cropId)
                ->orderBy('year', 'ASC')
                ->get();

            if (sizeof($data) != 0) {

                // populate data to production
                $reader = new Csv;
                $excel = $reader->load($productionPath);
                $excel->setActiveSheetIndex(0);
                $sheet = $excel->getActiveSheet();
                $row = 2;

                // set headers
                $sheet->setCellValue('A1', 'YEAR');
                $sheet->setCellValue('B1', 'PRODUCTION');

                // set file content
                foreach ($data as $key) {

                    // only if production is not zero
                    if ($key->production_mt != 0) {

                        $sheet->setCellValue('A' . $row, $key->year);
                        $sheet->setCellValue('B' . $row, $key->production_mt);
                        $row++;

                    }
                }

                // save the file
                $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($excel);
                $writer->setEnclosure('');
                $writer->save($productionPath);

                // populate data to consumption
                $reader = new Csv;
                $excel = $reader->load($consumptionPath);
                $excel->setActiveSheetIndex(0);
                $sheet = $excel->getActiveSheet();
                $row = 2;

                // set headers
                $sheet->setCellValue('A1', 'YEAR');
                $sheet->setCellValue('B1', 'CONSUMPTION');

                // set file content
                foreach ($data as $key) {

                    // only if per capita consumption is not zero
                    if ($key->per_capita_consumption_kg_yr != 0) {

                        $sheet->setCellValue('A' . $row, $key->year);
                        $sheet->setCellValue('B' . $row, $key->per_capita_consumption_kg_yr);
                        $row++;

                    }
                }

                // save the file
                $writer = new \PhpOffice\PhpSpreadsheet\Writer\Csv($excel);
                $writer->setEnclosure('');
                $writer->save($consumptionPath);
                
            }
        }
    }

    /**
     * Add shifters.
     *
     * @param Request $request
     */
    public function addShifter(Request $request)
    {
        $cropId = $request->input('key');

        $shifter = DB::table('shifter')
            ->where('crop_id', $cropId)
            ->first();

        $commodity = DB::table('src_commodities')
            ->select('src_commodities.crop_type')
            ->leftJoin('crops', 'src_commodities.id', '=', 'crops.src_commodity_id')
            ->where('crops.id', $cropId)
            ->first();

        return view('input.shifter')->with([
            'key' => $cropId,
            'shifter' => $shifter,
            'commodity' => $commodity
        ]);
    }

    /**
     * Import baseline data.
     * 
     * @return void
     */
    public function importBaseline()
    {
        // xlsx file path
        $path = 'uploads/baseline-data/baseline.xlsx';

        // reading commodity data in csv format
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx;
        $excel = $reader->load($path);

        // no. of sheets (provinces)
        $noSheets = $excel->getSheetCount();

        // truncate existing datab
        DB::table('src_baseline')->truncate();
        DB::table('src_baseline_data')->truncate();

        // read every sheet of the file
        for ($i = 0; $i < $noSheets; $i++) {

            // set active sheet
            $excel->setActiveSheetIndex($i);
            $sheet = $excel->getActiveSheet();

            // get province name
            $province = $sheet->getTitle();

            // get province id
            $_province = DB::table('src_provinces')
                ->where('province', trim($province))
                ->first();

            // province id
            $provinceId = ($_province != null) ? $_province->id : 0;

            // sheet dimension
            $lastColumn = $sheet->getHighestColumn();
            $lastRow = $sheet->getHighestRow();

            // get column name / index
            $lastColumnIndex = \PhpOffice\PhpSpreadsheet\Cell::columnIndexFromString($lastColumn);

            // it is assumed that 
            // first set of inputs
            // are consumption data
            $isComsumption = true;

            // data container
            // consumption & production
            $data = [];

            // loop to columns
            for ($colIndex = 1; $colIndex <= $lastColumnIndex; $colIndex++) {

                // get column name
                $colName = \PhpOffice\PhpSpreadsheet\Cell::stringFromColumnIndex($colIndex);

                // year must be at row 2
                $year = $sheet->getCell($colName . '2')->getCalculatedValue();

                // row 1 -> consumption label
                // row 2 -> the years
                for ($row = 1; $row <= $lastRow; $row++) {

                    // get commodity
                    $_commodity = $sheet->getCell('A' . $row)->getCalculatedValue();

                    // check if the data being read is productrion
                    if (STRTOUPPER($_commodity) == 'PRODUCTION') {
                        $isComsumption = false;
                    } elseif (STRTOUPPER($_commodity) == 'CONSUMPTION') {
                        $isComsumption = true;
                    }

                    // get commodity id
                    $commodity = DB::table('src_commodities')
                        ->where('commodity', trim($_commodity))
                        ->first();

                    // province id
                    $commodityId = ($commodity != null) ? $commodity->id : 0;

                    // check if commodity is valid
                    // and found in the record
                    if ($commodityId != 0) {

                        // check if commodity exist
                        $exist = DB::table('src_baseline')
                            ->where([
                                'src_province_id' => $provinceId,
                                'src_commodity_id' => $commodityId
                            ])
                            ->count();

                        // insert once
                        if (!$exist) {
                            $baselineId = DB::table('src_baseline')
                                ->insertGetId([
                                    'src_province_id' => $provinceId,
                                    'src_commodity_id' => $commodityId
                                ]);
                        }

                        // get baseline data
                        if (is_numeric($year)) {

                            // get the data
                            $val = $sheet->getCell($colName . $row)->getCalculatedValue();

                            // populate container
                            if ($isComsumption) {

                                // create array index
                                $data[$commodityId . '-' . $provinceId . '-'. $year] = [
                                    'commodity_id' => $commodityId,
                                    'province_id' => $provinceId,
                                    'year' => $year,
                                    'consumption' => $val,
                                    'production' => 0
                                ];

                            } else {

                                // update array value
                                $data[$commodityId . '-' . $provinceId . '-'. $year]['production'] = $val;

                            }
                        }
                    }
                }
            }

            if (sizeof($data) != 0) {
                foreach ($data as $k => $v) {

                    // get baseline id
                    $baselineId = DB::table('src_baseline')
                        ->where([
                            'src_province_id' => $v['province_id'],
                            'src_commodity_id' => $v['commodity_id']
                        ])
                        ->first();

                    // baseline id
                    $baselineId = ($baselineId != null) ? $baselineId->id : 0;

                    // insert new record
                    DB::table('src_baseline_data')
                        ->insert([
                            'baseline_id' => $baselineId,
                            'year' => $v['year'],
                            'consumption' => $v['consumption'],
                            'production' => $v['production']
                        ]);

                }
            }
        }

        exit("Done.");
    }

    /**
     * Delete crops.
     *
     * @param Request $request
     */
    public function deleteCrop(Request $request)
    {
        $cropId = $request->input('key');

        // crop details
        $commodity = DB::table('crops')
            ->select('src_commodities.crop_type')
            ->leftJoin('src_commodities', 'crops.src_commodity_id', '=', 'src_commodities.id')
            ->where('crops.id', $cropId)
            ->first();

        // crop type
        $type = strtolower(str_ireplace("-", "_", $commodity->crop_type));

        // deleting
        DB::table('crops')->where('id', $cropId)->delete();
        DB::table($type . '_annualized_growth_rate')->where('crop_id', $cropId)->delete();
        DB::table($type . '_slope')->where('crop_id', $cropId)->delete();
        DB::table($type . '_data')->where('crop_id', $cropId)->delete();
        DB::table('population')->where('crop_id', $cropId)->delete();
        DB::table('population_growth_rate')->where('crop_id', $cropId)->delete();
        DB::table($type . '_forecast')->where('crop_id', $cropId)->delete();

        // assuming that all records are deleted
        return [
            'error' => 0,
            'msg' => "Record successfully deleted."
        ];
    }

    /**
     * @param $population
     * @param $year
     * @param $file
     * @return void
     */
    private function handlePopulationProjection($population, $cropId, $file): void
    {
        // load data from file into array
        $data = Excel::toArray(new PopulationDataImport, $file);

        // initialize a new array to map year, rate
        $growthRates = collect([]);
        foreach ($data[0] as $row) {
            if (strtolower($row[0]) != 'year') {
                $growthRates->push([
                    'year' => $row[0],
                    'rate' => $row[1]
                ]);
            }
        }

        // initialize population using base population and population projection variables
        $initialPopulation = $population;
        $populationProjection = [];

        // iterate over growth rates to project population
        // set initial population to current population
        foreach ($growthRates as $item) {
            $currentPopulation = intval(round($initialPopulation * ($item['rate']/100 + 1)));
            array_push($populationProjection, [
                'year'          => $item['year'],
                'rate'          => $item['rate'],
                'population'    => $currentPopulation
            ]);
            $initialPopulation = $currentPopulation;
        }

        $crop = Crop::find($cropId);

        foreach ($populationProjection as $item) {
            $crop->population_growth_rates()->create([
                'year' => $item['year'],
                'rate' => $item['rate']
            ]);

            $crop->populations()->create([
                'year' => $item['year'],
                'population' => $item['population']
            ]);
        }
    }
}