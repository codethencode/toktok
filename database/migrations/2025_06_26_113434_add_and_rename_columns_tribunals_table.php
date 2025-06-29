<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::table('tribunals', function (Blueprint $table) {
         $table->dateTime('date_audience')->nullable()->after('ville');
         $table->string('parties_representees')->nullable()->after('date_audience');

         // Renommage d'une colonne existante
         $table->renameColumn('service', 'nom_juge');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('tribunals', function (Blueprint $table) {

            // Pour rollback : on supprime les nouvelles colonnes
            $table->dropColumn(['date_audience', 'parties_representees']);

            // Et on renomme à nouveau la colonne
            $table->renameColumn('nom_juge', 'service');
        });
    }
};
