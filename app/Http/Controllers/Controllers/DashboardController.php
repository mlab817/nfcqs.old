<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;
use DB;

class DashboardController extends Controller
{
    /**
	 * Dashboard for management
	 * graphs and reports.
	 *
	 * @param  Request
	 * @return [type]
	 */
	public function dashboard(Request $request)
	{
        return view('dashboard.main');
	}

	/**
	 * Forecasted values
	 * per commodity & province.
	 *
	 * @param  Request
	 * @return [type]
	 */
	public function result(Request $request)
	{
		$cropId = $request->input('key');
		$displayTable = $request->input('table');

		$timeline = [];
		$baselineConsumption = [];
		$baselineProduction = [];
		$arConsumption = [];
		$arProduction = [];
		$agrConsumption = [];
		$agrProduction = [];
		$logConsumption = [];
		$logProduction = [];

		// crop details
		$crop = DB::table('crop')
			->select(
				'src_provinces.id as province_id', 
				'src_provinces.province', 
				'src_commodities.id as commodity_id', 
				'src_commodities.commodity', 
				'src_commodities.crop_type',
				'crop.conversion_rate'
			)
			->leftJoin('src_provinces', 'crop.src_province_id', '=', 'src_provinces.id')
			->leftJoin('src_commodities', 'crop.src_commodity_id', '=', 'src_commodities.id')
			->where('crop.id', $cropId)
			->first();

		// get first and last year that is common to all models
		list($startYear, $endYear) = $this->getCommonYear($cropId, $crop);

		// get timeline
		$years = DB::table('population')
			->where('year', '>=', $startYear)
			->where('year', '<=', $endYear)
			->where('crop_id', $cropId)
			->orderBy('year', 'ASC')
			->get();

		// fetch timeline
		if (sizeof($years) != 0) {
			foreach ($years as $key) {
				$timeline[] = $key->year;
			}
		}

		// get baseline result
		$data = DB::table('src_baseline_data')
			->leftJoin('src_baseline', 'src_baseline_data.baseline_id', '=', 'src_baseline.id')
			->where('src_baseline.src_province_id', $crop->province_id)
			->where('src_baseline.src_commodity_id', $crop->commodity_id)
			->where('src_baseline_data.year', '>=', $startYear)
			->where('src_baseline_data.year', '<=', $endYear)
			->orderBy('src_baseline_data.year', 'ASC')
			->get();

		// fetch baseline data
		if (sizeof($data) != 0) {
			foreach ($data as $key) {
				if (in_array($key->year, $timeline)) {
					$baselineConsumption[] = $key->consumption;
					$baselineProduction[] = $key->production;
				}
			}
		}

		// get auto arima result
		$data = DB::table(strtolower(str_replace('-', '_', $crop->crop_type)) . '_forecast')
			->where('year', '>=', $startYear)
			->where('year', '<=', $endYear)
			->where('model', 3)
			->where('crop_id', $cropId)
			->orderBy('year', 'ASC')
			->get();

		// fetch baseline data
		if (sizeof($data) != 0) {
			foreach ($data as $key) {
				if (in_array($key->year, $timeline)) {
					$arConsumption[] = $key->consumption;
					$arProduction[] = $key->production;
				}
			}
		}

		// get log result
		$data = DB::table(strtolower(str_replace('-', '_', $crop->crop_type)) . '_forecast')
			->where('year', '>=', $startYear)
			->where('year', '<=', $endYear)
			->where('model', 1)
			->where('crop_id', $cropId)
			->orderBy('year', 'ASC')
			->get();

		// fetch baseline data
		if (sizeof($data) != 0) {
			foreach ($data as $key) {
				if (in_array($key->year, $timeline)) {
					$logConsumption[] = $key->consumption;
					$logProduction[] = $key->production;
				}
			}
		}

		// get agr result
		$data = DB::table(strtolower(str_replace('-', '_', $crop->crop_type)) . '_forecast')
			->where('year', '>=', $startYear)
			->where('year', '<=', $endYear)
			->where('model', 2)
			->where('crop_id', $cropId)
			->orderBy('year', 'ASC')
			->get();

		// fetch baseline data
		if (sizeof($data) != 0) {
			foreach ($data as $key) {
				if (in_array($key->year, $timeline)) {
					$agrConsumption[] = $key->consumption;
					$agrProduction[] = $key->production;
				}
			}
		}

		$chart = [];

		if (sizeof($baselineConsumption) != 0) {
		
			// production
			$chart[0] = [['Year', 'Baseline', 'ARIMA', 'Annualized Growth Rate ', 'Logarithmic Time Trend']];

			// consumption
			$chart[1] = [['Year', 'Baseline', 'Annualized Growth Rate ', 'Logarithmic Time Trend']];

			for ($i = 0; $i < sizeof($timeline); $i++) {
			
				// production
				$chart[0][] = [
					" " . $timeline[$i] . " ",
					$baselineProduction[$i],
					$arProduction[$i],
					$agrProduction[$i],
					$logProduction[$i]

				];

				// consumption
				$chart[1][] = [
					" " . $timeline[$i] . " ",
					$baselineConsumption[$i],
					$agrConsumption[$i],
					$logConsumption[$i]
				];

			}

		} else {

			// production
			$chart[0] = [['Year', 'ARIMA', 'Annualized Growth Rate', 'Logarithmic Time Trend']];

			// consumption
			$chart[1] = [['Year', 'Annualized Growth Rate', 'Logarithmic Time Trend']];

			for ($i = 0; $i < sizeof($timeline); $i++) {
			
				// production
				$chart[0][] = [
					" " . $timeline[$i] . " ",
					$arProduction[$i],
					$agrProduction[$i],
					$logProduction[$i]
				];

				// consumption
				$chart[1][] = [
					" " . $timeline[$i] . " ",
					$agrConsumption[$i],
					$logConsumption[$i]
				];

			}
		}

		// log
		$chart[3] = [['Year', 'Production', 'Consumption']];
		
		// annualize
		$chart[4] = [['Year', 'Production', 'Consumption']];

		// fetch timelines
		for ($i = 0; $i < sizeof($timeline); $i++) {

			// log
			$chart[3][] = [
				" " . $timeline[$i] . " ",
				$logProduction[$i] * $crop->conversion_rate,
				$logConsumption[$i],
			];

			// annualize
			$chart[4][] = [
				" " . $timeline[$i] . " ",
				$agrProduction[$i] * $crop->conversion_rate,
				$agrConsumption[$i],
			];

		}

        return view('dashboard.commodity')->with([
			'crop' => $crop,
			'chart' => $chart,
			'displayTable' => $displayTable,
			'withBaseline' => sizeof($baselineConsumption)
		]);
	}
	
	/**
	 * Get common years between models and baseline.
	 *
	 * @param [type] $cropId
	 * @param [type] $crop
	 */
	private function getCommonYear($cropId, $crop)
	{
		$baselineYears = [];
		$logYears = [];
		$agrYears = [];
		$arYears = [];

		// get baseline years
		$baseline = DB::table('src_baseline_data')
			->select('src_baseline_data.year')
			->leftJoin('src_baseline', 'src_baseline_data.baseline_id', '=', 'src_baseline.id')
			->where('src_commodity_id', $crop->commodity_id)
			->where('src_province_id', $crop->province_id)
			->orderBy('year', 'ASC')
			->get();

		// fetch baseline years
		if (sizeof($baseline) != 0) {
			foreach ($baseline as $key) {
				$baselineYears[] = $key->year;
			}
		}

		// get log years
		$log = DB::table(strtolower(str_replace('-', '_', $crop->crop_type)) . '_forecast')
			->select('year')
			->where([
				'crop_id' => $cropId,
				'model' => 1
			])
			->orderBy('year', 'ASC')
			->get();

		// fetch log years
		if (sizeof($log) != 0) {
			foreach ($log as $key) {
				$logYears[] = $key->year;
			}
		}

		// get annualize years
		$agr = DB::table(strtolower(str_replace('-', '_', $crop->crop_type)) . '_forecast')
			->select('year')
			->where([
				'crop_id' => $cropId,
				'model' => 2
			])
			->orderBy('year', 'ASC')
			->get();

		// fetch annualize years
		if (sizeof($agr) != 0) {
			foreach ($agr as $key) {
				$agrYears[] = $key->year;
			}
		}

		// get arima years
		$ar = DB::table(strtolower(str_replace('-', '_', $crop->crop_type)) . '_forecast')
			->select('year')
			->where([
				'crop_id' => $cropId,
				'model' => 3
			])
			->orderBy('year', 'ASC')
			->get();

		// fetch arima years
		if (sizeof($ar) != 0) {
			foreach ($ar as $key) {
				$arYears[] = $key->year;
			}
		}

		// get common years
		$years = (sizeof($baselineYears) != 0) ? array_intersect($baselineYears, $logYears, $agrYears, $arYears) : array_intersect($logYears, $agrYears, $arYears);

		// get first key
		reset($years);
		$first = key($years);

		// get last key
		end($years); 
		$last = key($years);
		
		// return first and last year
		return [$years[$first], $years[$last]];

	}

	/**
	 * Map control / settings form.
	 *
	 * @param Request $request
	 * @return void
	 */
	public function mapControl(Request $request)
	{
		$data = [];
		$__commodities = ['' => ''];

		$commodities = DB::table('crop')
			->select('src_commodities.id', 'src_commodities.commodity', 'src_commodities.crop_type')
			->leftJoin('src_commodities', 'crop.src_commodity_id', '=', 'src_commodities.id')
			->where('crop.user_id', Auth::user()->id)
			->whereNotNull('crop.remarks')
			->groupBy('src_commodities.id')
			->orderBy('src_commodities.commodity', 'ASC')
			->get();

		if (sizeof($commodities) != 0) {
			foreach ($commodities as $c) {

				$province = DB::table('crop')
					->select('src_provinces.id', 'src_provinces.province')
					->leftJoin('src_provinces', 'crop.src_province_id', '=', 'src_provinces.id')
					->where('crop.src_commodity_id', $c->id)
					->where('crop.user_id', Auth::user()->id)
					->groupBy('src_provinces.id')
					->orderBy('src_provinces.province', 'ASC')
					->get();

				$provinces = [];
				$years = [];

				if (sizeof($province) != 0) {
					foreach ($province as $p) {

						$forecast = DB::table('crop')
							->select('crop.id', 'crop.remarks')
							->where('crop.src_commodity_id', $c->id)
							->where('crop.src_province_id', $p->id)
							->where('crop.user_id', Auth::user()->id)
							->whereNotNull('crop.remarks')
							->orderBy('crop.remarks', 'ASC')
							->get();

						$forecasts = [];

						if (sizeof($forecast) != 0) {
							foreach ($forecast as $f) {
								$forecasts[] = [$f->id, $f->remarks];
							}
						}

						$provinces[] = [
							[$p->id, $p->province],
							$forecasts
						];
					}
				}

				// get forecast years
				$__years = DB::table(str_ireplace('-', '_', strtolower($c->crop_type)) . '_forecast')
					->select(str_ireplace('-', '_', strtolower($c->crop_type)) . '_forecast.year')
					->groupBy(str_ireplace('-', '_', strtolower($c->crop_type)) . '_forecast.year')
					->orderBy(str_ireplace('-', '_', strtolower($c->crop_type)) . '_forecast.year', 'ASC')
					->get();

				if (sizeof($__years) != 0) {
					foreach ($__years as $__y) {
						$years[] = $__y->year;
					}
				}

				$data [] = [
					[$c->id, $c->commodity],
					$provinces,
					$years
				];

				$__commodities[$c->id] = $c->commodity;
			}
		}

		// $data[0];				# -> first commodity
		// $data[0][0];				# -> first commodity details
		// $data[0][1];				# -> first commodity provinces
		// $data[0][1][0];			# -> first commodity & first province
		// $data[0][1][0][0];   	# -> first commodity & first province details
		// $data[0][1][0][1];		# -> first commodity & first province forecasts
		// $data[0][1][0][1][0];	# -> first commodity & first province & first forecast

		return view('reports.map-control')->with([
			'commodities' => $__commodities,
			'data' => $data,
		]);
	}

	/**
	 * Display map.
	 *
	 * @param Request $request
	 * @return void
	 */
	public function displayMap(Request $request)
	{
		$commodityId = $request->input('map_commodity');	
		$provinceCount = $request->input('province_count');
		$year = $request->input('map_year');
		$model = $request->input('map_model');
		
		$data = [];
		$selectedForecast = false;
		$coordinates = [];

		// validation rules
		$validator = Validator::make(
            [
                'map_commodity' => $commodityId,
                'map_year' => $year,
                'map_model' => $model
            ], [
                'map_commodity' => 'required|numeric',
                'map_year' => 'required|numeric',
                'map_model' => 'required|numeric'
            ]);

		// do some validations
        if ($validator->fails()) {
			return [
				'error' => true,
				'msg' => $validator->errors()
			];
		}

		// get commodity details
		$c = DB::table('src_commodities')
			->where('id', $commodityId)
			->first();

		for ($i = 0; $i < $provinceCount; $i++) {

			// selected province
			$provinceId = $request->input('province_input_' . $i);

			// if province is selected
			if ($provinceId != '' AND $provinceId != null) {

				// selected forecast (to cover multiple result in single commodity)
				// to allow users rerun the model with shifters
				$forecastId = $request->input('forecast_input_' . $i);

				// if forecast option is selected
				if ($forecastId != '' AND $forecastId != null) {

					// get conversion rate
					$conversionRate = DB::table('crop')
						->select('conversion_rate')
						->where('id', $forecastId)
						->first();

					// get forecast result
					$forecast = DB::table(str_ireplace('-', '_', strtolower($c->crop_type)) . '_forecast')
						->select(
							str_ireplace('-', '_', strtolower($c->crop_type)) . '_forecast.*',
							str_ireplace('-', '_', strtolower($c->crop_type)) . '_forecast.per_capita_consumption_kg_yr as per_capita_consumption',
							DB::RAW('((' . str_ireplace('-', '_', strtolower($c->crop_type)) . '_forecast.production * ' . $conversionRate->conversion_rate . ') - ' . str_ireplace('-', '_', strtolower($c->crop_type)) . '_forecast.consumption) as p_c')
						)
						->where([
							'year' => $year,
							'crop_id' => $forecastId,
							'model' => $model
						])
						->first();

					// get province details
					$p = DB::table('src_provinces')
						->where('id', $provinceId)
						->first();

					$data[] = array_merge(
						['province' => $p->province], 
						(array) $forecast
					);

					$selectedForecast = true;
					$coordinates[$p->province] = $p->boundary;
				}
			}
		}

		if (!$selectedForecast) {
			return [
				'error' => true,
				'msg' => [
					'province_error' => 'Please select inputs under province.'
				]
			];
		} else {
			if (strtolower($c->crop_type) == 'crop') {
				$sortByArea = $data;
				$sortByYield = $data;

				// sort array
				usort($sortByArea, function($a, $b) { return $a['area'] <=> $b['area']; });
				usort($sortByYield, function($a, $b) { return $a['yield'] <=> $b['yield']; });

				// desc order
				$sortByArea = array_reverse($sortByArea);
				$sortByYield = array_reverse($sortByYield);
			}

			$sortByPerCapita = $data;
			$sortByProduction = $data;
			$sortByConsumption = $data;
			$sortByProdMinCon = $data;

			// sort array
			usort($sortByPerCapita, function($a, $b) { return $a['per_capita_consumption'] <=> $b['per_capita_consumption']; });
			usort($sortByProduction, function($a, $b) { return $a['production'] <=> $b['production']; });
			usort($sortByConsumption, function($a, $b) { return $a['consumption'] <=> $b['consumption']; });
			usort($sortByProdMinCon, function($a, $b) { return $a['p_c'] <=> $b['p_c']; });

			// desc order
			$sortByPerCapita = array_reverse($sortByPerCapita);
			$sortByProduction = array_reverse($sortByProduction);
			$sortByConsumption = array_reverse($sortByConsumption);
			$sortByProdMinCon = array_reverse($sortByProdMinCon);

			if (strtolower($c->crop_type) == 'crop') {
				return [
					'area' => $sortByArea,
					'yield' => $sortByYield,
					'per_capita_consumption' => $sortByPerCapita,
					'production' => $sortByProduction,
					'consumption' => $sortByConsumption,
					'p_c' => $sortByProdMinCon,
					'type' => strtolower($c->crop_type),
					'coordinates' => $coordinates,
					'commodity' => $c->commodity, 
					'year' => $year,
				];
			} else {
				return [
					'per_capita_consumption' => $sortByPerCapita,
					'production' => $sortByProduction,
					'consumption' => $sortByConsumption,
					'p_c' => $sortByProdMinCon,
					'type' => strtolower($c->crop_type),
					'coordinates' => $coordinates,
					'commodity' => $c->commodity, 
					'year' => $year,
				];
			}
		}
	}
}