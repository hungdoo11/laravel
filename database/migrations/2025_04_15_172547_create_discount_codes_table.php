<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscountCodesTable extends Migration
{
    public function up()
    {
        Schema::create('discount_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->decimal('discount_amount', 10, 2); // Số tiền giảm (VD: 50000)
            $table->decimal('min_order_amount', 10, 2)->nullable(); // Giá trị đơn hàng tối thiểu để áp dụng
            $table->dateTime('expires_at')->nullable(); // Thời gian hết hạn
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('discount_codes');
    }
}
