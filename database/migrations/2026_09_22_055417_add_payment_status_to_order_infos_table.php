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
        Schema::table('order_infos', function (Blueprint $table) {
            $table->tinyInteger('payment_status')->nullable()->after('remark_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_infos', function (Blueprint $table) {
            $table->dropColumn('payment_status');
        });
    }
};
