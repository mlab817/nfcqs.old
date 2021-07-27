<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Crop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HandleSaveModelResults extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        // handle save data
        Log::info(json_encode($data));

        $crop = Crop::find($data['crop_id']);

        $crop->results()->createMany($data['data']);

        return response()->json($data, 200);
    }
}
