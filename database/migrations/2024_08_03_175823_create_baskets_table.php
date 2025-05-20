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
        Schema::create('baskets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('order_id');
            $table->string('order_type')->default('basket');
            $table->string('order_name');
            $table->string('stripe_customer_id');
            $table->decimal('total_price',6,2);
            $table->string('cityCode');
            $table->decimal('cityCodePrice', 6, 2);
            $table->decimal('baseFeePrice', 6, 2);
            $table->integer('numberOfPages');
            $table->string('printType');
            $table->decimal('printTypePrice', 6, 2);
            $table->string('reliureType');
            $table->decimal('reliureTypePrice', 6, 2);
            $table->string('isAbo');
            $table->decimal('aboPrice', 6, 2);
            $table->string('plaideType');
            $table->decimal('plaideTypePrice', 6, 2);
            $table->string('JuriType');
            $table->decimal('JuriTypePrice', 6, 2);
            $table->string('isUrgent');
            $table->decimal('urgentPrice', 6, 2);
            $table->string('hasDiscount');
            $table->decimal('discountRebate', 6, 2);
            $table->date('dateEndAbo');
            $table->string('isPaid')->default('ko');
            $table->string('sendMail')->default('ko');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('baskets');
    }
};
