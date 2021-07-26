<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NonCropData extends Model
{
    use HasFactory;

    protected $fillable = [
        'crop_id',
        'year',
        'production_mt',
        'converted_production',
        'per_capita_consumption_kg_yr',
        'ln_production',
        'ln_consumption',
    ];
}
