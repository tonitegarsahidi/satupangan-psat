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
        Schema::create('register_sppb', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('business_id')->constrained('business')->onDelete('cascade');
            $table->string('status', 50);
            $table->boolean('is_enabled')->default(true);
            $table->string('nomor_registrasi', 50)->nullable();
            $table->date('tanggal_terbit')->nullable();
            $table->date('tanggal_terakhir')->nullable();

            // Tambahan kolom unit usaha
            $table->boolean('is_unitusaha')->default(false);
            $table->string('nama_unitusaha', 100)->nullable();
            $table->string('alamat_unitusaha', 100)->nullable();
            $table->foreignUuid('provinsi_unitusaha')->nullable()->constrained('master_provinsis')->onDelete('set null');
            $table->foreignUuid('kota_unitusaha')->nullable()->constrained('master_kotas')->onDelete('set null');
            $table->string('nib_unitusaha', 100)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('register_sppb');
    }
};
