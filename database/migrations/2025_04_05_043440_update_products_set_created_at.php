<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UpdateProductsSetCreatedAt extends Migration
{
    public function up()
    {
        // Set created_at to the current timestamp for records where it's null
        DB::table('products')
            ->whereNull('created_at')
            ->update(['created_at' => now(), 'updated_at' => now()]);
    }

    public function down()
    {
        // Optionally, you can set created_at back to null if needed
        DB::table('products')
            ->whereNotNull('created_at')
            ->update(['created_at' => null, 'updated_at' => null]);
    }
};
