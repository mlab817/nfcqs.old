<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $fillable = [
        'crop_id',
        'year',
        'ltt_production',
        'cagr_production',
        'arima_production',
        'consumption',
    ];
}
