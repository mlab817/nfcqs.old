<?php

namespace App\Imports;

use App\Models\OfficialData;
use App\Models\SrcCommodity;
use App\Models\SrcProvince;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;

class OfficialCommodityData implements ToModel
{
    use Importable;

    public $commodityId;

    public $cropType;

    public function __construct(int $commodityId)
    {
        $this->commodityId = $commodityId;
        $this->cropType = SrcCommodity::find($commodityId)->crop_type;
    }

    /**
     * @param array $row
     * @return OfficialData
     */
    public function model(array $row): OfficialData
    {
        $province = SrcProvince::where('province','like','%'.trim(str_replace('.','',$row[1])).'%')->first();
        $production = floatval(str_replace(',','',  $row[2]));
        $area = $this->cropType == 'Non-Crop' ? null : floatval(str_replace(',','',  $row[3]));

        // data with no province will not be added
        if ($province) {
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
}
