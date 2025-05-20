<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function plaidoirie()
    {
        return $this->belongsTo(Plaidoirie::class, 'plaideType', 'code');
    }

    public function impression()
    {
        return $this->belongsTo(TypeImpression::class, 'printType', 'code');
    }

    public function reliure()
    {
        return $this->belongsTo(TypeReliure::class, 'reliureType', 'code');
    }

    public function zoneGeo()
    {
        return $this->belongsTo(ZoneGeo::class, 'cityCode', 'code');
    }
}
