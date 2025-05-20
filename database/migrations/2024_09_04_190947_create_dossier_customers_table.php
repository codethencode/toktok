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
        Schema::create('dossier_customers', function (Blueprint $table) {
            $table->id();
            // Utiliser string pour order_id au lieu de foreignId (entier)
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('order_id');
            $table->string('directory_id');
            $table->integer('numberOfFiles')->default(0);
            $table->string('validSend')->default('notSent');
            $table->dateTime('dateValidSend')->nullable(); // Facultatif, mais utile si cette colonne n'a pas toujours une valeur
            $table->string('step')->default('envoiFichier-01');
            $table->string('trackingShip')->nullable();
            $table->dateTime('shipDate')->nullable(); // Facultatif
            $table->text('infoDossier');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dossier_customers');
    }
};
