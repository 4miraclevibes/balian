<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->enum('delivery_type', ['instant', 'process'])->default('instant')->after('description');
        });
    
        // Update semua data yang ada ke instant
        DB::table('products')->update(['delivery_type' => 'instant']);
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('delivery_type');
        });
    }
};
