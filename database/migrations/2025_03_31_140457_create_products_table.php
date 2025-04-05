<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('id_type');
            $table->text('description')->nullable();
            $table->decimal('unit_price', 10, 2);
            $table->decimal('promotion_price', 10, 2)->default(0);
            $table->string('image')->nullable();
            $table->string('unit')->nullable();
            $table->boolean('new')->default(0);
            $table->boolean('top')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
