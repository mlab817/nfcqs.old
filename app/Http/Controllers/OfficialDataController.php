<?php

namespace App\Http\Controllers;

use App\Models\OfficialData;
use App\Models\SrcCommodity;
use Illuminate\Http\Request;

class OfficialDataController extends Controller
{
    public function index(Request $request)
    {
        $commodityId = $request->get('commodity_id') ?? 1;
        $commodity = SrcCommodity::find($commodityId);

        $data = $commodity->load('official_data.province');

        return view('official-data', compact('data'))
            ->with('commodities', SrcCommodity::all()->mapWithKeys(function ($commodity) {
                return [$commodity->id => $commodity->commodity];
            }))
            ->with('commodity_id', $commodityId);
    }

    public function destroy(Request $request)
    {
        $officialData = OfficialData::findOrFail($request->get('id'));
        $officialData->delete();

        return back()->with('message', 'Successfully deleted data');
    }
}
