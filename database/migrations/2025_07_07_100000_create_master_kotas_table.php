<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('master_kotas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('provinsi_id');
            $table->string('kode_kota', 12)->nullable();
            $table->string('nama_kota', 100);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->string('created_by')->nullable()->default(null);
            $table->string('updated_by')->nullable()->default(null);
            $table->softDeletes();

            $table->foreign('provinsi_id')->references('id')->on('master_provinsis');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_kotas');
    }
};
