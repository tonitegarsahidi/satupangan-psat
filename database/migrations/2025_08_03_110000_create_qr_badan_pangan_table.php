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
        Schema::create('qr_badan_pangan', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('qr_code')->nullable();
            $table->string('file_qr_code', 200)->nullable();


            $table->foreignUuid('current_assignee')->nullable()->constrained('users')->onDelete('set null');

            $table->foreignUuid('requested_by')->nullable()->constrained('users')->onDelete('set null');
            $table->dateTime('requested_at')->nullable();

            $table->foreignUuid('reviewed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->dateTime('reviewed_at')->nullable();

            $table->foreignUuid('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->dateTime('approved_at')->nullable();

            $table->string('status', 50)->nullable();
            $table->boolean('is_published')->default(false);

            $table->foreignUuid('business_id')->constrained('business')->onDelete('cascade');

            $table->string('nama_komoditas', 200)->nullable(false);
            $table->string('nama_latin', 200)->nullable(false);
            $table->string('merk_dagang', 200)->nullable(false);

            $table->foreignUuid('jenis_psat')->nullable()->constrained('master_jenis_pangan_segars')->onDelete('set null');

            // Foreign key references
            $table->foreignUuid('referensi_sppb')->nullable()->constrained('register_sppb')->onDelete('set null');
            $table->foreignUuid('referensi_izinedar_psatpl')->nullable()->constrained('register_izinedar_psatpl')->onDelete('set null');
            $table->foreignUuid('referensi_izinedar_psatpd')->nullable()->constrained('register_izinedar_psatpd')->onDelete('set null');
            $table->foreignUuid('referensi_izinedar_psatpduk')->nullable()->constrained('register_izinedar_psatpduk')->onDelete('set null');
            $table->foreignUuid('referensi_izinrumah_pengemasan')->nullable()->constrained('register_izinrumah_pengemasan')->onDelete('set null');
            $table->foreignUuid('referensi_sertifikat_keamanan_pangan')->nullable()->constrained('register_sertifikat_keamanan_pangan')->onDelete('set null');

            // File attachments
            $table->string('file_lampiran1', 200)->nullable();
            $table->string('file_lampiran2', 200)->nullable();
            $table->string('file_lampiran3', 200)->nullable();
            $table->string('file_lampiran4', 200)->nullable();
            $table->string('file_lampiran5', 200)->nullable();

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
        Schema::dropIfExists('qr_badan_pangan');
    }
};
