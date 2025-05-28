<?php

namespace App\Services;

use App\Models\Basket;
use App\Models\Company;
use App\Models\OptionPrice;

class OrderService
{
    public static function getDetailOrderData($orderId): array
    {
        $basket = Basket::where('order_id', $orderId)->firstOrFail();
        $company = Company::where('order_id', $orderId)->first();

        $typeImpression = OptionPrice::where('code', $basket->printType)->first();
        $typeReliure = OptionPrice::where('code', $basket->reliureType)->first();
        $plaidoirie = OptionPrice::where('code', $basket->plaideType)->first();
        $juridiction = OptionPrice::where('code', $basket->JuriType)->first();
        $zoneGeo = OptionPrice::where('code', $basket->cityCode)->first();

        $total =
            $basket->baseFeePrice +
            ($basket->numberOfPages * ($typeImpression->price ?? 0)) +
            ($typeReliure->price ?? 0) +
            ($plaidoirie->price ?? 0) +
            ($juridiction->price ?? 0) +
            ($zoneGeo->cityPrice ?? 0) +
            ($basket->isUrgent ? ($basket->urgentPrice ?? 0) : 0);

        return [
            'nbPages' => $basket->numberOfPages,
            'basket' => $basket,
            'typeImpression' => $typeImpression,
            'typeReliure' => $typeReliure,
            'plaidoirie' => $plaidoirie,
            'juridiction' => $juridiction,
            'zoneGeo' => $zoneGeo,
            'urgence' => $basket->urgentPrice,
            'total' => $total,
            'isAbo' => $basket->isAbo,
            'company' => $company,
        ];
    }
}
