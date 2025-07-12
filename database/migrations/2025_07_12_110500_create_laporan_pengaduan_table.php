<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_pengaduan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->string('nama_pelapor', 255);
            $table->string('nik_pelapor', 32)->nullable();
            $table->string('nomor_telepon_pelapor', 32)->nullable();
            $table->string('email_pelapor', 255)->nullable();
            $table->text('lokasi_kejadian')->nullable();
            $table->uuid('provinsi_id');
            $table->uuid('kota_id');
            $table->text('isi_laporan');
            $table->text('tindak_lanjut_pertama')->nullable();
            $table->uuid('workflow_id');
            $table->boolean('is_active')->default(true);
            $table->string('created_by')->nullable()->default(null);
            $table->string('updated_by')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('provinsi_id')->references('id')->on('master_provinsis');
            $table->foreign('kota_id')->references('id')->on('master_kotas');
            $table->foreign('workflow_id')->references('id')->on('workflows');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_pengaduan');
    }
};
