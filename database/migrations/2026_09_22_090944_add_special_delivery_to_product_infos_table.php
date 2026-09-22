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
        Schema::table('product_infos', function (Blueprint $table) {
            $table->boolean('special_delivery')->default(0)->after('view_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_infos', function (Blueprint $table) {
            $table->dropColumn('special_delivery');
        });
    }
};
