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
        Schema::table('register_sppb', function (Blueprint $table) {
            $table->dropForeign(['penanganan_id']);
            $table->dropColumn(['penanganan_id', 'penanganan_keterangan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('register_sppb', function (Blueprint $table) {
            $table->uuid('penanganan_id')->nullable();
            $table->foreign('penanganan_id')->references('id')->on('master_penanganan')->onDelete('set null');
            $table->string('penanganan_keterangan', 50)->nullable();
        });
    }
};
