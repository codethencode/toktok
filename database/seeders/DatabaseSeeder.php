<?php

namespace Database\Seeders;

use App\Models\BaseFee;
use App\Models\ConditionVente;
use App\Models\Plaidoirie;
use App\Models\TypeImpression;
use App\Models\TypeReliure;
use App\Models\TypeExpedition;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\ZoneGeo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::truncate();
        TypeImpression::truncate();
        TypeReliure::truncate();
        TypeExpedition::truncate();
        ZoneGeo::truncate();
        Plaidoirie::truncate();
        BaseFee::truncate();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'dev@jaihk.fr',
            'password' => Hash::make('password'),
            'phone' => '0123456789',
            'role' => 'admin',
        ]);



        TypeImpression::factory()->create([
           'code' => 'printRSNB',
           'libelle' => 'Impression Recto Seul Noir et Blanc',
           'price' => 0.20,
        ]);

        TypeImpression::factory()->create([
            'code' => 'printRSC',
            'libelle' => 'Impression Recto Seul Couleur',
            'price' => 0.30,
        ]);

        TypeImpression::factory()->create([
            'code' => 'printRVNB',
            'libelle' => 'Impression Recto/Verso Noir et Blanc',
            'price' => 0.15,
        ]);

        TypeImpression::factory()->create([
            'code' => 'printRVC',
            'libelle' => 'Impression Recto/Verso Couleur',
            'price' => 0.20,
        ]);

        //RELIURE
        TypeReliure::factory()->create([
            'code' => 'reliureAVTDC',
            'libelle' => 'Reliure Face Avant transparent Dos carton rouge 400g',
            'price' => '15'
        ]);

        TypeReliure::factory()->create([
            'code' => 'reliureAVART',
            'libelle' => 'Reliure Face Avant/Arriere transparent',
            'price' => '10'
        ]);

        TypeReliure::factory()->create([
            'code' => 'reliureU',
            'libelle' => 'Reliure Uniquement',
            'price' => '7'
        ]);

        TypeReliure::factory()->create([
            'code' => 'reliureZ',
            'libelle' => 'Impression Seule',
            'price' => '3'
        ]);

        TypeExpedition::factory()->create([
            'code' => 'expeC',
            'libelle' => 'Expédition standard jusqu\'à j+7',
            'price' => 10,
        ]);

        TypeExpedition::factory()->create([
            'code' => 'expeR',
            'libelle' => 'Expédition Recommandé Accusé réception jusqu\'à j+4',
            'price' => 25,
        ]);

        TypeExpedition::factory()->create([
            'code' => 'expeF',
            'libelle' => 'Expédition express 48/72h',
            'price' => 50,
        ]);

        ZoneGeo::factory()->create([
            'code' => '75',
            'name' => 'Paris',
            'price' => 0,
        ]);

        ZoneGeo::factory()->create([
            'code' => '92',
            'name' => 'Hauts de Seine',
            'price' => 0,
        ]);

        ZoneGeo::factory()->create([
            'code' => '93',
            'name' => 'Seine Saint Denis',
            'price' => 0,
        ]);

        ZoneGeo::factory()->create([
            'code' => '94',
            'name' => 'Val de Marne',
            'price' => 0,
        ]);

        ZoneGeo::factory()->create([
            'code' => '77',
            'name' => 'Seine et Marne',
            'price' => 150,
        ]);

        ZoneGeo::factory()->create([
            'code' => '78',
            'name' => 'Yvelines',
            'price' => 150,
        ]);

        ZoneGeo::factory()->create([
            'code' => '91',
            'name' => 'Essonne',
            'price' => 150,
        ]);

        ZoneGeo::factory()->create([
            'code' => '95',
            'name' => 'Val D\'Oise',
            'price' => 150,
        ]);

        ZoneGeo::factory()->create([
            'code' => '02',
            'name' => 'Aisne',
            'price' => 300,
        ]);

        ZoneGeo::factory()->create([
            'code' => '60',
            'name' => 'Oise',
            'price' => 300,
        ]);

        ZoneGeo::factory()->create([
            'code' => '27',
            'name' => 'Eure',
            'price' => 300,
        ]);

        ZoneGeo::factory()->create([
            'code' => '13',
            'name' => 'Marseille',
            'price' => 0,
        ]);

        Plaidoirie::factory()->create([
            'code' => 'RepOnly',
            'libelle' => 'Représentation Seule',
            'description' => 'Repésentation à l\'audience (sans observation)',
            'price' => 199,
        ]);

        Plaidoirie::factory()->create([
            'code' => 'RepSimple',
            'libelle' => 'Représentation Simple',
            'description' => 'Représentation avec observation (dossier simple après validation de la difficulté du dossier par l\'avocat jusqu\'à 5 pages de conclusions)',
            'price' => 399,
        ]);

        Plaidoirie::factory()->create([
            'code' => 'RepComplexe',
            'libelle' => 'Représentation Complexe',
            'description' => 'Représentation avec observation (dossier complexe après validation de la difficulté du dossier par l\'avocat jusqu\'à 20 pages de conclusions)',
            'price' => 599,
        ]);

        Plaidoirie::factory()->create([
            'code' => 'RepTresComplexe',
            'libelle' => 'Représentation très Complexe',
            'description' => 'Représentation avec observation (dossier très complexe après validation de la difficulté du dossier par l\'avocat jusqu\'à 20 à 50 pages de conclusions)',
            'price' => 899,
        ]);

        Plaidoirie::factory()->create([
            'code' => 'RepDevis',
            'libelle' => 'Représentation sur Devis',
            'description' => 'Dossier supérieur à 50 pages de conclusions chiffrage de la plaidoirie sur devis',
            'price' => 0,
        ]);

        Plaidoirie::factory()->create([
            'code' => 'DontKnow',
            'libelle' => 'Ne sais pas',
            'description' => 'Je ne sais pas encore ou je ne suis pas intéressé',
            'price' => 0,
        ]);

        Plaidoirie::factory()->create([
            'code' => 'TribJud',
            'libelle' => 'Tribunal Judiciaire',
            'description' => 'Pas de surplus de tarification remise en mains propres le jour de l\'audience non nécessaire',
            'price' => 0,
        ]);

        Plaidoirie::factory()->create([
            'code' => 'TribJcp',
            'libelle' => 'JCP / Prud\'hommes',
            'description' => 'La remise du dossier au tribunal en mains propres le jour de l\'audience est nécessaire (non facturé si représentation simple sans observation déjà sélectionnée',
            'price' => 199,
        ]);

        Plaidoirie::factory()->create([
            'code' => 'TribCab',
            'libelle' => 'Envoi du dossier au cabinet',
            'description' => 'Nous envoyons votre dossier directmeent à votre cabinet',
            'price' => 0,
        ]);

        BaseFee::factory()->create([
            'code' => 'Base',
            'libelle' => 'Frais Mise en Service',
            'description' => 'Frais de mise en service unique incluant l\'exoédition de votre dossier',
            'price' => 99,
        ]);

        BaseFee::factory()->create([
            'code' => 'Abo',
            'libelle' => 'Frais Abonnement mensuel',
            'description' => 'Frais prélévés chaque mois lors de l\'abonnement mensuel',
            'price' => 29,
        ]);

        BaseFee::factory()->create([
            'code' => 'Urgent',
            'libelle' => 'Traitement Urgent',
            'description' => 'Frais de traitement dans les 24 heures pour une prise en charge rapide de la constitution de votre dossier',
            'price' => 79,
        ]);

        ConditionVente::factory()->create([
           'cgv' => 'LETTRE DE MISSION ET CONVENTION D\'HONORAIRES

La mission donnée à l\'avocat consiste à rédiger et/ou relire, sécuriser, rédiger, modifier et/ou adapter les projets de statuts et le ou les documents (rédaction de la liste des souscripteurs si SAS ou SASU et de l\'état des actes accomplis) nécessaires à l\'immatriculation d\'une société et conseiller le client, s\'il le souhaite, sur ses choix. La prestation juridique dépendra de la formule choisie. Accessoirement, l\'avocat sera dépositaire du capital de la société. La prestation est globale et forfaitaire. Le prix de la prestation est fixée selon les offres suivantes :

- Offre BASIC à 129 € HT soit 155 € TTC (2 ass. au-delà 49 € TTC par associé supplémentaire) comprenant un accompagnement* juridique + dépôt de capital à partir de 1 € et jusqu\'à 5 000 € pour 2 associés (supérieur à 5 000 € sur devis)

- Offre BUSINESS à 299 € HT soit 359 € TTC (2 ass. au-delà 49 € TTC par associé supplémentaire) comprenant un accompagnement* juridique + DEPOT ou AUGMENTATION de capital ; formule dédiée aux cas particuliers : Associé(s) étranger(s) UE non-résidents français, Hors UE et non-résidents français, augmentation de Capital jusqu\'à 10 000 euros (somme supérieure sur devis) ou pour déposer votre capital à partir de 1 € et jusqu\'à 5 000 € pour 2 associés  (supérieur à 5 000 € sur devis)

- Offre INTEGRALE à 519 € HT soit 623 € TTC (2 ass. au-delà 49 € TTC par associé supplémentaire) comprenant un accompagnement juridique (KBIS en mains : rédaction des actes nécessaires à immatriculation, formalités Greffe et publication et rédaction annonce JAL) + DEPOT de capital à partir de 1 € et jusqu\'à 5 000 € pour 2 associés (supérieur à 5 000 € sur devis), au-delà sur devis

    - Offre SOCIETE PLUS à 229 € HT soit 275 € TTC (2 ass. au-delà 49 € TTC par associé supplémentaire) comprenant un accompagnement juridique (KBIS en mains : rédaction des actes nécessaires à immatriculation, formalités Greffe et publication et rédaction annonce JAL)

- Offre SOCIETE INTEGRALE à 379 € HT soit 455 € TTC (2 ass. au-delà 49 € TTC par associé supplémentaire) comprenant un accompagnement juridique (KBIS en mains : rédaction des actes nécessaires à immatriculation, formalités Greffe et publication et rédaction annonce JAL) + DEPOT de capital à partir de 1 € et jusqu\'à 5 000 €, au-delà sur devis, offre comprenant un dépôt de marque France (1 classe hors frais INPI) ou réservée aux Ressortissants étrangers ou non résidents Français

* Accompagnement juridique par avocat comprenant : validation / mise en conformité des statuts – rédaction de la liste des souscripteurs si manquante pour une SAS ou SASU – rédaction de l’état des actes accomplis pour la société en formation

Pour toutes les formules mentionnées ci-dessous, un honoraire complémentaire de 49 € TTC sera appliqué par associé supplémentaire au-delà du 2ième et à partir du 3ième associé.

Dans le cas où l\'avocat sera mandaté expressément pour faire la publication au JAL et/ou déposer le dossier au Greffe, les frais seront payés par le client par la remise d\'un chèque pour chaque organisme concerné. L\'honoraire sera versé intégralement à l\'ouverture du dossier.

D’autres honoraires fixes pourront être perçus dans le cadre de l’accomplissement de diligences complémentaires qui n’auraient pas été prévues dans le cadre de la présente mission sous réserve de l\'aval du client.

    A titre indicatif, habituellement, pour ce type de dossiers, le taux horaire de Maître David ATTALI est de 250 € H.T soit 300 € TTC.

    Ces honoraires comprennent les prestations de secrétariat, mais ne comprennent pas les frais ou débours qui pourront être exposés pour le compte du client.

    En cas d’interruption de la mission, les honoraires seront dus au prorata des diligences effectuées jusqu’au moment de l’interruption.

    Les dossiers sont conservés cinq ans après la clôture du dossier et l’archivage. A l’issue du dossier, le client pourra demander la restitution des documents, pièces de procédure et autres éléments relatifs à son dossier.

    Le client-consommateur peut saisir le médiateur de la consommation. Pour ce faire, il adresse une demande écrite, détaillée et argumentée, précisant la difficulté rencontrée, la réclamation préalablement effectuée et les suites qui y ont été données par l’avocat ainsi que ce qu’il souhaite obtenir, en joignant copie des documents permettant l\'examen détaillé de son dossier par le médiateur. Vous pouvez adresser une demande au Médiateur de la consommation de la profession d’avocat :
Par voie postale à l\'adresse : Médiateur de la consommation de la profession d\'avocat, 180 boulevard Haussmann, 75008 Paris
Par courriel à l\'adresse : mediateur-conso@mediateur-consommation-avocat.fr
Directement par le site internet en vous rendant sur l\'url : https://mediateur-consommation-avocat.fr/contacter-le-mediateur/
Toute difficulté d’interprétation ou autre sera soumise à l’arbitrage de Monsieur le Bâtonnier du Barreau de Marseille auquel appartient Me David ATTALI dont le cabinet est sis 14 rue Pythéas 13001 Marseille exerçant à titre individuel sous le numéro de SIRET : 507 414 860 00027 et de de TVA INTRACOMMUNAUTAIRE FR 21 507 414 860 – tél . : 06 52 58 84 56.

 '
        ]);
    }
}
