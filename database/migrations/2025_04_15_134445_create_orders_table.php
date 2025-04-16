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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name');
            $table->string('gender');
            $table->string('email');
            $table->string('address');
            $table->string('phone_number');
            $table->text('notes')->nullable();
            $table->string('payment_method');
            $table->integer('total_price');
            $table->enum('status', ['moi', 'dang_giao', 'da_giao', 'da_huy'])->default('moi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
