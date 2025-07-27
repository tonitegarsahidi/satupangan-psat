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
            $table->foreignUuid('jenis_psat')->nullable()->constrained('master_jenis_pangan_segars')->onDelete('set null');
            $table->string('nama_komoditas', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('register_sppb', function (Blueprint $table) {
            //
        });
    }
};
