<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CropData extends Model
{
    use HasFactory;

    protected $fillable = [
        'crop_id',
        'year',
        'harvested_area_ha',
        'production_mt',
        'yield_mt_ha',
        'converted_area',
        'converted_production',
        'converted_yield',
        'per_capita_consumption_kg_yr',
        'ln_area',
        'ln_yield',
        'ln_consumption',
    ];
}
