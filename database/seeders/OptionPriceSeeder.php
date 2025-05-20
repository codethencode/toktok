<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\OptionPrice;

class OptionPriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OptionPrice::insert([
            [
                'code' => '',
                'categorie' => 'type_impression',
                'label' => 'Recto/Verso Noir & Blanc',
                'description' => 'Impression recto/verso en noir et blanc',
                'price' => 0.15
            ],
            [
                'code' => '',
                'categorie' => 'type_impression',
                'label' => 'Couleur',
                'description' => 'Impression en couleur',
                'price' => 0.50
            ],
            [
                'code' => '',
                'categorie' => 'papier',
                'label' => 'Papier Recyclé',
                'description' => 'Papier écologique recyclé 80g',
                'price' => 0.02
            ]
        ]);
    }
}

