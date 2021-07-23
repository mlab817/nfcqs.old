<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SrcProvince extends Model
{
    use HasFactory;

    public function crops()
    {
        return $this->hasMany(Crop::class);
    }
}
