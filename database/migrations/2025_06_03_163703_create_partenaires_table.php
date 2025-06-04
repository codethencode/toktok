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
        Schema::create('partenaires', function (Blueprint $table) {
        $table->id();
        $table->string('nom');
        $table->string('statut');
        $table->string('cabinet');
        $table->string('telephone');
        $table->string('branche');
        $table->string('zone');
        $table->string('region');
        $table->string('villes');
        $table->string('site')->nullable();
        $table->text('message')->nullable();
        $table->integer('percent')->default(0);
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partenaires');
    }
};
