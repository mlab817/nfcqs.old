<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
        $data = $request->all();

        if (!empty($data)) {
            $jsonData = $data[0];
            $arrayData = json_decode($jsonData, true);
            Log::info(json_encode($arrayData));
        }

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = Storage::put('/uploads/', $file);
            Log::debug('file path: ' . $filePath);
        }

        return response()->json('All ok', 200);
    }
}
