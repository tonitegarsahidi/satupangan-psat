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
        Schema::create('register_izinedar_psatpd', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('business_id')->constrained('business')->onDelete('cascade');
            $table->string('status', 50);
            $table->boolean('is_enabled')->default(true);

            $table->string('nomor_sppb', 50)->nullable();
            $table->string('nomor_izinedar_pd', 50)->nullable();

            // Tambahan kolom unit usaha
            $table->boolean('is_unitusaha')->default(false);
            $table->string('nama_unitusaha', 200)->nullable();
            $table->string('alamat_unitusaha', 200)->nullable();
            $table->string('alamat_unitpenanganan', 200)->nullable();
            $table->foreignUuid('provinsi_unitusaha')->nullable()->constrained('master_provinsis')->onDelete('set null');
            $table->foreignUuid('kota_unitusaha')->nullable()->constrained('master_kotas')->onDelete('set null');
            $table->string('nib_unitusaha', 200)->nullable();

            $table->foreignUuid('jenis_psat')->nullable()->constrained('master_jenis_pangan_segars')->onDelete('set null');

            $table->string('nama_komoditas', 200)->nullable();
            $table->string('nama_latin', 200)->nullable();
            $table->string('negara_asal', 200)->nullable();
            $table->string('merk_dagang', 200)->nullable();
            $table->string('jenis_kemasan', 200)->nullable();
            $table->string('ukuran_berat', 200)->nullable();
            $table->string('klaim', 200)->nullable();
            $table->string('foto_1', 200)->nullable();
            $table->string('foto_2', 200)->nullable();
            $table->string('foto_3', 200)->nullable();
            $table->string('foto_4', 200)->nullable();
            $table->string('foto_5', 200)->nullable();
            $table->string('foto_6', 200)->nullable();

            // File columns
            $table->string('file_nib', 200)->nullable();
            $table->string('file_sppb', 200)->nullable();
            $table->string('file_izinedar_psatpd', 200)->nullable();

            $table->foreignUuid('okkp_penangungjawab')->nullable()->constrained('users')->onDelete('set null');

            $table->date('tanggal_terbit')->nullable();
            $table->date('tanggal_terakhir')->nullable();

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
        Schema::dropIfExists('register_izinedar_psatpd');
    }
};
