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
                'code' => 'imp_RSNB',
                'categorie' => 'type_impression',
                'label' => 'Impression Recto Seul Noir et Blanc',
                'description' => 'Impression recto/verso en noir et blanc',
                'price' => 0.2
            ],
            [
                'code' => 'imp_RSC',
                'categorie' => 'type_impression',
                'label' => 'Impression Recto Seul Couleur',
                'description' => 'Impression Recto Seul Couleur',
                'price' => 0.3
            ],
            [
                'code' => 'imp_RVNB',
                'categorie' => 'type_impression',
                'label' => 'Impression Recto/Verso Noir et Blanc',
                'description' => 'Impression Recto/Verso Noir et Blanc',
                'price' => 0.15
            ],
            [
                'code' => 'imp_RVC',
                'categorie' => 'type_impression',
                'label' => 'Impression Recto/Verso Couleur',
                'description' => 'Impression Recto/Verso Couleur',
                'price' => 0.02
            ],
            
            //TYPE RELIURE
            [
                'code' => 'reli_01',
                'categorie' => 'type_reliure',
                'label' => 'Reliure Face Avant transparent Dos carton rouge 400g',
                'description' => 'Reliure Face Avant transparent Dos carton rouge 400g',
                'price' => 15
            ],
            [
                'code' => 'reli_02',
                'categorie' => 'type_reliure',
                'label' => 'Reliure Face Avant/Arriere transparent',
                'description' => 'Reliure Face Avant/Arriere transparent',
                'price' => 10
            ],
            [
                'code' => 'reli_03',
                'categorie' => 'type_reliure',
                'label' => 'Reliure Uniquement',
                'description' => 'Reliure Uniquement',
                'price' => 7
            ],
            [
                'code' => 'reli_04',
                'categorie' => 'type_reliure',
                'label' => 'Impression Seule',
                'description' => 'Impression Seule',
                'price' => 3
            ],
            //CHOIX PLAIDOIRIE
            [
                'code' => 'plaid_01',
                'categorie' => 'type_plaidoirie',
                'label' => 'Représentation Seule',
                'description' => 'Repésentation à l\'audience (sans observation)',
                'price' => 199
            ],
            [
                'code' => 'plaid_02',
                'categorie' => 'type_plaidoirie',
                'label' => 'Représentation Simple',
                'description' => 'Représentation avec observation (dossier simple après validation de la difficulté du dossier par l\'avocat jusqu\'à 5 pages de conclusions)',
                'price' => 399
            ],
            [
                'code' => 'plaid_03',
                'categorie' => 'type_plaidoirie',
                'label' => 'Représentation Complexe',
                'description' => 'Représentation avec observation (dossier complexe après validation de la difficulté du dossier par l\'avocat jusqu\'à 20 pages de conclusions)',
                'price' => 599
            ],
            [
                'code' => 'plaid_04',
                'categorie' => 'type_plaidoirie',
                'label' => 'Représentation très Complexe',
                'description' => 'Représentation avec observation (dossier très complexe après validation de la difficulté du dossier par l\'avocat jusqu\'à 20 à 50 pages de conclusions)',
                'price' => 899
            ],
            [
                'code' => 'plaid_05',
                'categorie' => 'type_plaidoirie',
                'label' => 'Représentation sur Devis',
                'description' => 'Dossier supérieur à 50 pages de conclusions chiffrage de la plaidoirie sur devis',
                'price' => 0.02
            ],
            [
                'code' => 'plaid_06',
                'categorie' => 'type_plaidoirie',
                'label' => 'Ne sais pas',
                'description' => 'Je ne sais pas encore ou je ne suis pas intéressé',
                'price' => 0.02
            ],
            //TYPE JURIDICTION
            [
                'code' => 'juri_01',
                'categorie' => 'type_juri',
                'label' => 'Tribunal Judiciaire',
                'description' => 'Pas de surplus de tarification remise en mains propres le jour de l\'audience non nécessaire',
                'price' => 0.00
            ],
            [
                'code' => 'juri_02',
                'categorie' => 'type_juri',
                'label' => 'JCP / Prud\'hommes',
                'description' => 'La remise du dossier au tribunal en mains propres le jour de l\'audience est nécessaire (non facturé si représentation simple sans observation déjà sélectionnée',
                'price' => 0.00
            ],
            [
                'code' => 'juri_03',
                'categorie' => 'type_juri',
                'label' => 'Envoi du dossier au cabinet',
                'description' => 'Nous envoyons votre dossier directmeent à votre cabinet',
                'price' => 0.00
            ],
            //ZONE GEO
            [
                'code' => 'zone_01',
                'categorie' => 'zone_geo',
                'label' => 'Paris',
                'description' => '',
                'price' => 0.00
            ],
            [
                'code' => 'zone_02',
                'categorie' => 'zone_geo',
                'label' => 'Hauts de Seine',
                'description' => '',
                'price' => 0.00
            ],
            [
                'code' => 'zone_03',
                'categorie' => 'zone_geo',
                'label' => 'Seine Saint Denis',
                'description' => '',
                'price' => 0.00
            ],
            [
                'code' => 'zone_04',
                'categorie' => 'zone_geo',
                'label' => 'Val de Marne',
                'description' => '',
                'price' => 0.02
            ],
            [
                'code' => 'zone_05',
                'categorie' => 'zone_geo',
                'label' => 'Seine et Marne',
                'description' => '',
                'price' => 150
            ],
            [
                'code' => 'zone_06',
                'categorie' => 'zone_geo',
                'label' => 'Yvelines',
                'description' => '',
                'price' => 150
            ],
            [
                'code' => 'zone_07',
                'categorie' => 'zone_geo',
                'label' => 'Essonne',
                'description' => '',
                'price' => 150
            ],
            [
                'code' => 'zone_08',
                'categorie' => 'zone_geo',
                'label' => 'Val d\'Oise',
                'description' => '',
                'price' => 150
            ],
            [
                'code' => 'zone_09',
                'categorie' => 'zone_geo',
                'label' => 'Aisne',
                'description' => '',
                'price' => 300
            ],
            [
                'code' => 'zone_10',
                'categorie' => 'zone_geo',
                'label' => 'Oise',
                'description' => '',
                'price' => 300
            ],
            [
                'code' => 'zone_11',
                'categorie' => 'zone_geo',
                'label' => 'Eure',
                'description' => '',
                'price' => 300
            ],
            [
                'code' => 'zone_12',
                'categorie' => 'zone_geo',
                'label' => 'Marseille',
                'description' => '',
                'price' => 0.00
            ],
            //FRAIS SPECIFIQUES
            [
                'code' => 'extra_01',
                'categorie' => 'type_extra',
                'label' => 'Frais de dossier',
                'description' => '',
                'price' => 29
            ],
            [
                'code' => 'extra_02',
                'categorie' => 'type_extra',
                'label' => 'Traitement express',
                'description' => '',
                'price' => 79
            ]

        ]);
    }
}

