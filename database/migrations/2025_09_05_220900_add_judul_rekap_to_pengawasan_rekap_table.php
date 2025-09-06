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
        Schema::table('pengawasan_rekap', function (Blueprint $table) {
            $table->string('judul_rekap', 200)->nullable()->after('produk_psat_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengawasan_rekap', function (Blueprint $table) {
            $table->dropColumn('judul_rekap');
        });
    }
};
