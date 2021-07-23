<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Crop extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'src_province_id',
        'src_commodity_id',
        'conversion_rate',
        'crop_data_filename',
        'pop_data_filename',
        'per_capita_consumption_kg_year',
        'per_capita_year',
        'remarks',
    ];

    public function commodity(): BelongsTo
    {
        return $this->belongsTo(SrcCommodity::class,'src_commodity_id');
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(SrcProvince::class,'src_province_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
