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
        Schema::table('register_sppb', function (Blueprint $table) {
            $table->tinyInteger('qr_category')->nullable()->default(1)->after('tanggal_terakhir');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('register_sppb', function (Blueprint $table) {
            $table->dropColumn('qr_category');
        });
    }
};
