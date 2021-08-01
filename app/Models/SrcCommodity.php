<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SrcCommodity extends Model
{
    use HasFactory;

    public function official_data(): HasMany
    {
        return $this->hasMany(OfficialData::class);
    }
}
