<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CropSlope;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class HandleLttController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $json = $request->getContent();

        $data = json_decode($json);

        Log::info($data->mape);
        Log::info(json_encode($data->regression_params));
        Log::info(json_encode($data->data));
        Log::info($data->model);
        Log::info($data->x_variable);
        Log::info($data->y_variable);

        return response()->json($json, 200);
    }
}
