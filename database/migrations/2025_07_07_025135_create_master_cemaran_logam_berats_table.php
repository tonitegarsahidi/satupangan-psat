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
        Schema::create('master_cemaran_logam_berats', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('kode_cemaran_logam_berat', 12)->nullable();
            $table->string('nama_cemaran_logam_berat', 255);
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
        Schema::dropIfExists('master_cemaran_logam_berats');
    }
};
