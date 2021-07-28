<?php

namespace App\Http\Controllers;

use App\Models\SrcProvince;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        // get province details
        $p = SrcProvince::where('province', $province)->first();
    }
}