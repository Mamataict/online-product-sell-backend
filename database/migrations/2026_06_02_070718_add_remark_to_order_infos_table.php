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
            $table->text('remark')->nullable()->after('status');
            $table->foreignId('remark_by')
                ->after('remark')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_infos', function (Blueprint $table) {
            $table->dropForeign(['remark_by']);
            $table->dropColumn('remark_by');
            $table->dropColumn('remark');
        });
    }
};
