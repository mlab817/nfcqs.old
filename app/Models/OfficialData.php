<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficialData extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'src_commodity_id',
        'src_province_id',
        'production',
        'area_harvested',
        'yield',
    ];
}
