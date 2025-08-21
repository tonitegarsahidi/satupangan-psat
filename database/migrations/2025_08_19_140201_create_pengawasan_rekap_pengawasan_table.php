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
        Schema::create('pengawasan_rekap_pengawasan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('pengawasan_rekap_id');
            $table->uuid('pengawasan_id');
            $table->timestamps();

            $table->foreign('pengawasan_rekap_id')->references('id')->on('pengawasan_rekap')->onDelete('cascade');
            $table->foreign('pengawasan_id')->references('id')->on('pengawasan')->onDelete('cascade');

            // Add unique constraint to prevent duplicate entries
            $table->unique(['pengawasan_rekap_id', 'pengawasan_id'], 'prp_rekap_id_pengawasan_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengawasan_rekap_pengawasan');
    }
};
