<?php

namespace App\Http\Controllers;

use App\Imports\OfficialCommodityData;
use App\Models\SrcCommodity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class UploadController extends Controller
{
    public function index()
    {
        return view('uploads.index', [
            'commodities' => SrcCommodity::all()->mapWithKeys(function ($commodity) {
                return [$commodity->id => $commodity->commodity];
            }),
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->only('commodity_id','commodity_data'),[
            'commodity_id' => 'required|exists:src_commodities,id',
            'commodity_data' => 'required|mimes:csv'
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }

        Excel::import(new OfficialCommodityData($request->commodity_id), $request->file('commodity_data'));

        return 'Successfully imported data';
    }
}
