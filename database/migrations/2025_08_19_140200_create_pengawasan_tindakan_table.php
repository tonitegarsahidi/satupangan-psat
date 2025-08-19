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
        Schema::create('pengawasan_tindakan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('pengawasan_rekap_id');
            $table->uuid('user_id_pimpinan');
            $table->text('tindak_lanjut');
            $table->string('status', 50);
            $table->json('pic_tindakan_ids')->nullable();
            $table->boolean('is_active')->default(true);
            $table->uuid('created_by');
            $table->uuid('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('pengawasan_rekap_id')->references('id')->on('pengawasan_rekap');
            $table->foreign('user_id_pimpinan')->references('id')->on('users');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengawasan_tindakan');
    }
};
