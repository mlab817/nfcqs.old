<?php

namespace App\Imports;

use App\Models\Crop;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class CommodityDataImport implements ToCollection, WithStartRow
{
    /**
     * @param Collection $collection
     * @return Crop
     */
    public function collection(Collection $collection)
    {
//        'crop_id' => $cropId,
//                        'year' => $year,
//                        'harvested_area_ha' => $area,
//                        'production_mt' => $production,
//                        'yield_mt_ha' => $yield,
//                        'converted_area' => $areaConversionRate,
//                        'converted_production' => $productionConversionRate,
//                        'converted_yield' => $yieldConversionRate,
//                        'per_capita_consumption_kg_yr' => $consumption,
//                        'ln_area' => $lnArea,
//                        'ln_yield' => $lnYield,
//                        'ln_consumption' => $lnConsumption
    }

    public function startRow(): int
    {
        return 2;
    }
}
