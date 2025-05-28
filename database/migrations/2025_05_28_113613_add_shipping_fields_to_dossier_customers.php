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
        Schema::table('dossier_customers', function (Blueprint $table) {
            //
            $table->string('carrier')->nullable();
            $table->string('proof_path')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dossier_customers', function (Blueprint $table) {
            //
            $table->dropColumn('carrier');
            $table->dropColumn('proof_path');
        });
    }
};
