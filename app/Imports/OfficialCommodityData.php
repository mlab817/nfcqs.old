<?php

namespace App\Imports;

use App\Models\OfficialData;
use App\Models\SrcProvince;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;

class OfficialCommodityData implements ToModel
{
    use Importable;

    public $commodityId;

    public function __construct(int $commodityId)
    {
        $this->commodityId = $commodityId;
    }

    /**
     * @param array $row
     * @return OfficialData
     */
    public function model(array $row): OfficialData
    {
        $province = SrcProvince::where('province','like','%'.trim(str_replace('.','',$row[1])).'%')->first();
        $production = floatval(str_replace(',','',  $row[2]));
        $area = floatval(str_replace(',','',  $row[3]));

        return new OfficialData([
            'year' => $row[0],
            'src_commodity_id' => $this->commodityId,
            'src_province_id' => $province->id,
            'production' => $production,
            'area_harvested' => $area,
            'yield' => !$area ? null: $production / $area,
        ]);
    }
}
