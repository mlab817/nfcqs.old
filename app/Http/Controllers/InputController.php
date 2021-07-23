<?php

namespace App\Http\Controllers;

use App\Models\Crop;
use App\Models\SrcCommodity;
use App\Models\SrcProvince;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
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
        $commodityDest = Storage::putFileAs('/uploads/commodity-data', $commodityData, Str::snake($province->province) . '_' . Str::snake($commodity->commodity) . '-' . Str::random(6) . '.csv');
        $popGrowthDest = Storage::putFileAs('/uploads/pop-growth-rate', $commodityData, Str::snake($province->province) . '_' . Str::snake($commodity->commodity) . '-' . Str::random(6) . '.csv');

        // identify type of crop
        $typeCrop = SrcCommodity::find($commodityId);

        // check for errors in commodity data
        $error1 = $this->checkCommodityData($commodityDest, $typeCrop->crop_type);

        // check for errors in pop growth rate
        $error2 = $this->checkPopGrowthRate($popGrowthDest, $year);

        // return errors if any
        if ($error1) {
            return $error1;
        } elseif ($error2) {
            return $error2;
        }

        // convert percent to decimal value
        $conversionRate = $conversionRate / 100;

        // save crop details
        $crop = Crop::create($request->except('crop_data_filename','pop_data_filename'));
        $crop->crop_data_filename = $commodityDest;
        $crop->pop_data_filename = $popGrowthDest;
        $crop->save();

        // save population
        DB::table('population')
            ->insert([
                'crop_id' => $crop->id,
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

        // import population growth rate
        $this->importPopGrowthRate($popGrowthDest, $crop->id, $population);

        // create file source for auto-arima model
        $this->createAutoArimaSrcData($crop->id, $typeCrop->crop_type);

        return "Successfully saved.";
    }

    /**
     * Check commodity data.
     *
     * @param [type] $path
     * @param [type] $cropType
     */
    private function checkCommodityData($path, $cropType)
    {
        // reading commodity data in csv format
        $reader = new Csv;
        $excel = $reader->load(public_path($path));

        // set active sheet
        $excel->setActiveSheetIndex(0);

        // sheet dimension
        $lastColumn = $excel->getActiveSheet()->getHighestColumn();
        $lastRow = $excel->getActiveSheet()->getHighestRow();

        // columns for "crop" type commodities
        // -> a. Year
        // -> b. Area Harvested
        // -> c. Production
        // -> d. Per Capita Consumption
        if ($cropType == 'crops' AND $lastColumn != 'D') {
            return ['commodity_data' => 'Column out of range.'];
        } elseif ($cropType == 'crops' AND $lastRow < 6) {
            return ['commodity_data' => 'Row out of range.'];
        }

        // columns for "non-crop" type commodities
        // -> a. Year
        // -> b. Production
        // -> c. Per Capita Consumption
        if ($cropType == 'Non-crops' AND $lastColumn != 'C') {
            return ['commodity_data' => 'Column out of range.'];
        } elseif ($cropType == 'Non-crops' AND $lastRow < 6) {
            return ['commodity_data' => 'Row out of range.'];
        }

        return false;
    }

    /**
     * Check population growth rate.
     *
     * @param [type] $path
     * @param [type] $year
     */
    private function checkPopGrowthRate($path, $year)
    {
        // reading commodity data in csv format
        $reader = new Csv;
        $excel = $reader->load($path);

        // set active sheet
        $excel->setActiveSheetIndex(0);

        // sheet dimension
        $lastColumn = $excel->getActiveSheet()->getHighestColumn();
        $lastRow = $excel->getActiveSheet()->getHighestRow();

        // start year with growth rate value must be
        // year specified in the population plus 1
        // -> if year is 2015
        // -> then year 2016 must have growth rate value
        $y1 = $year + 1;
        $y2 = $excel->getActiveSheet()->getCell('A2')->getValue();
        $b2 = $excel->getActiveSheet()->getCell('B2')->getValue();

        // columns and start row for population growth rate
        if ($lastColumn != 'B') {
            return ['pop_growth_rate' => 'Column out of range.'];
        } elseif ($y1 != $y2) {
            return ['pop_growth_rate' => 'Growth rate must start in year ' . $y1 . '.'];
        } elseif ($b2 == '' OR $b2 == 0) {
            return ['pop_growth_rate' => 'Growth rate in first year must be specified.'];
        }

        return false;
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
        // reading commodity data in csv format
        $reader = new Csv;
        $excel = $reader->load($path);

        // set active sheet
        $excel->setActiveSheetIndex(0);

        // last row of data
        $lastRow = $excel->getActiveSheet()->getHighestRow();

        // loop through all rows starting from row 2
        for ($row = 2; $row <= $lastRow; $row++) {

            $year = $excel->getActiveSheet()->getCell('A' . $row)->getValue();

            if ($cropType == 'crops') {

                $area = $excel->getActiveSheet()->getCell('B' . $row)->getValue();
                $production = $excel->getActiveSheet()->getCell('C' . $row)->getValue();
                $consumption = $excel->getActiveSheet()->getCell('D' . $row)->getValue();

                // remove commas
                $area = str_replace(',', '', $area);
                $production = str_replace(',', '', $production);
                $consumption = str_replace(',', '', $consumption);

                // if no values, zero is the default
                $area = ($area == '') ? 0 : $area;
                $production = ($production == '') ? 0 : $production;
                $consumption = ($consumption == '') ? 0 : $consumption;

                // compute yield
                $yield = ($area != 0 AND $production != 0) ? $production / $area : 0;

                // get value applied with conversion rate
                $areaConversionRate = ($area != 0) ? $area * $rate : 0;
                $productionConversionRate = ($production != 0) ? $production * $rate : 0;
                $yieldConversionRate = ($productionConversionRate != 0 AND $areaConversionRate != 0) ? $productionConversionRate / $areaConversionRate : 0;

                // get natural logarithm of a number
                $lnArea = ($area != 0) ? log($area) : 0;
                $lnYield = ($production != 0 AND $area != 0) ? log($production / $area) : 0;
                $lnConsumption = ($consumption != 0) ? log($consumption) : 0;

                // save the data
                DB::table('crop_data')
                    ->insert([
                        'crop_id' => $cropId,
                        'year' => $year,
                        'harvested_area_ha' => $area,
                        'production_mt' => $production,
                        'yield_mt_ha' => $yield,
                        'converted_area' => $areaConversionRate,
                        'converted_production' => $productionConversionRate,
                        'converted_yield' => $yieldConversionRate,
                        'per_capita_consumption_kg_yr' => $consumption,
                        'ln_area' => $lnArea,
                        'ln_yield' => $lnYield,
                        'ln_consumption' => $lnConsumption
                    ]);

            } elseif ($cropType == 'Non-crops') {

                $production = $excel->getActiveSheet()->getCell('B' . $row)->getValue();
                $consumption = $excel->getActiveSheet()->getCell('C' . $row)->getValue();

                // remove commas
                $production = str_replace(',', '', $production);
                $consumption = str_replace(',', '', $consumption);

                // if no values, zero is the default
                $production = ($production == '') ? 0 : $production;
                $consumption = ($consumption == '') ? 0 : $consumption;

                // get value applied with conversion rate
                $productionConversionRate = ($production != 0) ? $production * $rate : 0;

                // get natural logarithm of a number
                $lnProduction = ($production != 0) ? log($production) : 0;
                $lnConsumption = ($consumption != 0) ? log($consumption) : 0;

                // save the data
                DB::table('non_crop_data')
                    ->insert([
                        'crop_id' => $cropId,
                        'year' => $year,
                        'production_mt' => $production,
                        'converted_production' => $productionConversionRate,
                        'per_capita_consumption_kg_yr' => $consumption,
                        'ln_production' => $lnProduction,
                        'ln_consumption' => $lnConsumption
                    ]);

            }
        }
    }

    /**
     * Calculate slope value.
     *
     * @param [type] $cropId
     * @param [type] $table
     * @param [type] $column
     */
    private function calculateSlope($cropId, $table, $column)
    {
        $sql = "COUNT(*) AS N,
                SUM(year) AS Sum_X,
                SUM(year * year) AS Sum_X2,
                SUM(" . $column . ") AS Sum_Y,
                SUM(" . $column . " * " . $column . ") AS Sum_Y2,
                SUM(year * " . $column . ") AS Sum_XY";

        $data = DB::table($table)
            ->selectRaw($sql)
            ->where('crop_id', $cropId)
            ->where($column, '<>', 0)
            ->first();

        if ($data != '' AND $data != null) {
            return ($data->N * $data->Sum_XY - $data->Sum_X * $data->Sum_Y) / ($data->N * $data->Sum_X2 - $data->Sum_X * $data->Sum_X);
        } else {
            return 0;
        }
    }

    /**
     * Calculate annualized growth rate.
     *
     * @param [type] $cropId
     * @param [type] $table
     * @param [type] $column
     */
    private function calculateAnnGrowthRate($cropId, $table, $column)
    {
        $count = DB::table($table)
            ->where('crop_id', $cropId)
            ->where($column, '<>', 0)
            ->count();

        $start = DB::table($table)
            ->where('crop_id', $cropId)
            ->where($column, '<>', 0)
            ->orderBy('year', 'ASC')
            ->first();

        $end = DB::table($table)
            ->where('crop_id', $cropId)
            ->where($column, '<>', 0)
            ->orderBy('year', 'DEC')
            ->first();

        return (pow(($end->{$column} / $start->{$column}), (1 / $count)) - 1);
    }

    /**
     * Import population grwoth rate
     * and compute population.
     *
     * @param [type] $path
     * @param [type] $cropId
     * @param [type] $population
     */
    private function importPopGrowthRate($path, $cropId, $population)
    {
        // reading commodity data in csv format
        $reader = new Csv;
        $excel = $reader->load($path);

        // set active sheet
        $excel->setActiveSheetIndex(0);

        // last row of data
        $lastRow = $excel->getActiveSheet()->getHighestRow();

        // loop through all rows starting from row 2
        for ($row = 2; $row <= $lastRow; $row++) {

            $year = $excel->getActiveSheet()->getCell('A' . $row)->getValue();
            $rate = $excel->getActiveSheet()->getCell('B' . $row)->getValue();

            // compute population
            $population = $population * (($rate / 100) + 1);

            // insert population growth rate
            DB::table('population_growth_rate')
                ->insert([
                    'crop_id' => $cropId,
                    'year' => $year,
                    'rate' => $rate
                ]);

            // insert computed population
            DB::table('population')
                ->insert([
                    'crop_id' => $cropId,
                    'year' => $year,
                    'population' => $population
                ]);

        }
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
     * Upload project report form.
     *
     * @param Request $request
     */
    public function uploadReportForm(Request $request)
    {
        return view('reports.upload');
    }

    /**
     * Upload project report.
     *
     * @param Request $request
     */
    public function uploadReport(Request $request)
    {
        $remarks = trim($request->input('remarks'));
        $file = $request->file('file');
        
        // validation
        $validator = Validator::make(
            [
                'remarks' => $remarks,
                'file' => $file
            ], [
                'remarks' => 'required|max:100',
                'file' => 'required|mimes:doc,dox,xls,xlsx,pdf,ppt,pptx',
            ]);

        if (!$validator->fails()) {

            // get file extension
            $path = $_FILES['file']['name'];
            $ext = pathinfo($path, PATHINFO_EXTENSION);

            // file repo destination
            $dest = 'uploads/project-reports/' . strtolower(rand() . '.' . $ext);
            
            // copy the files
            copy($file, $dest);

            // insert the file
            DB::table('project_reports')
                ->insert([
                    'filename' => $dest,
                    'remarks' => $remarks
                ]);

            return "File successfully uploaded.";
        } else {
            return $validator->errors();
        }
    }

    /**
     * List of project reports.
     *
     * @param Request $request
     */
    public function reportList(Request $request)
    {
        $data = DB::table('project_reports')
            ->orderBy('id', 'DESC')
            ->get();

        return view('reports.list')->with([
            'data' => $data
        ]); 
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
}