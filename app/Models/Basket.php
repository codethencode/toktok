<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function user()
    {
    return $this->belongsTo(User::class);
    }

    public function company()
    {
    return $this->hasOne(Company::class, 'order_id', 'order_id');
    }

    public function tribunal()
    {
    return $this->hasOne(Tribunal::class, 'order_id', 'order_id');
    }

    public function dossierCustomer()
    {
    return $this->hasOne(DossierCustomer::class, 'order_id', 'order_id');
    }
    
    public function plaidoirie()
    {
        return $this->belongsTo(OptionPrice::class, 'plaideType', 'code');
    }

    public function impression()
    {
        return $this->belongsTo(OptionPrice::class, 'printType', 'code');
    }

    public function reliure()
    {
        return $this->belongsTo(OptionPrice::class, 'reliureType', 'code');
    }

    public function zoneGeo()
    {
        return $this->belongsTo(OptionPrice::class, 'cityCode', 'code');
    }

    public function juriTypeInfo()
{
    return $this->hasOne(OptionPrice::class, 'code', 'JuriType'); // Adapter si le champ est 'type'
}
}
