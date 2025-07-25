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
        Schema::create('master_kelompok_pangans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('kode_kelompok_pangan', 12)->nullable();
            $table->string('nama_kelompok_pangan', 255);
            $table->tinyText('keterangan')->nullable();
            $table->boolean('is_active')->default(TRUE);
            $table->timestamps();
            $table->string('created_by')->nullable()->default(null);
            $table->string('updated_by')->nullable()->default(null);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_kelompok_pangans');
    }
};
