<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function commodity(): BelongsTo
    {
        return $this->belongsTo(SrcCommodity::class,'src_commodity_id');
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(SrcProvince::class,'src_province_id');
    }
}
