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
        Schema::create('pengawasan_rekap', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id_admin');
            $table->uuid('jenis_psat_id');
            $table->uuid('produk_psat_id');
            $table->uuid('provinsi_id')->nullable();
            $table->text('hasil_rekap');
            $table->string('lampiran1', 200)->nullable()->after('hasil_rekap');
            $table->string('lampiran2', 200)->nullable()->after('lampiran1');
            $table->string('lampiran3', 200)->nullable()->after('lampiran2');
            $table->string('lampiran4', 200)->nullable()->after('lampiran3');
            $table->string('lampiran5', 200)->nullable()->after('lampiran4');
            $table->string('lampiran6', 200)->nullable()->after('lampiran5');
            $table->string('status', 50);
            $table->uuid('pic_tindakan_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->uuid('created_by');
            $table->uuid('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id_admin')->references('id')->on('users');
            $table->foreign('jenis_psat_id')->references('id')->on('master_jenis_pangan_segars');
            $table->foreign('produk_psat_id')->references('id')->on('master_bahan_pangan_segars');
            $table->foreign('provinsi_id')->references('id')->on('master_provinsis');
            $table->foreign('pic_tindakan_id')->references('id')->on('users');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengawasan_rekap');
    }
};
