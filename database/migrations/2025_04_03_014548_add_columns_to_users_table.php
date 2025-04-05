<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Thêm cột full_name
            $table->string('full_name')->after('id');
            // Thêm cột phone
            $table->string('phone')->nullable()->after('password');
            // Thêm cột address
            $table->string('address')->nullable()->after('phone');
            // Thêm cột level
            $table->integer('level')->default(3)->after('address');
            // (Tùy chọn) Xóa cột name nếu không cần
            $table->dropColumn('name');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Khôi phục cột name nếu cần
            $table->string('name')->nullable();
            // Xóa các cột đã thêm
            $table->dropColumn(['full_name', 'phone', 'address', 'level']);
        });
    }
};
