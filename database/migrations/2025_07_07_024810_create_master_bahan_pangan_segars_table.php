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
        Schema::create('master_bahan_pangan_segars', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('jenis_id');
            $table->string('kode_bahan_pangan_segar', 12)->nullable();
            $table->string('nama_bahan_pangan_segar', 255);
            $table->boolean('is_active')->default(TRUE);
            $table->timestamps();
            $table->string('created_by')->nullable()->default(null);
            $table->string('updated_by')->nullable()->default(null);
            $table->softDeletes();

            $table->foreign('jenis_id')->references('id')->on('master_jenis_pangan_segars')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_bahan_pangan_segars');
    }
};
