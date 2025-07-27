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
        Schema::create('register_sppb_jenispsat', function (Blueprint $table) {
            $table->uuid('register_sppb_id');
            $table->foreignUuid('jenispsat_id');
            $table->primary(['register_sppb_id', 'jenispsat_id']);
            $table->timestamps();

            $table->foreign('register_sppb_id')->references('id')->on('register_sppb')->onDelete('cascade');
            $table->foreign('jenispsat_id')->references('id')->on('master_jenis_pangan_segars')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('register_sppb_jenispsat');
    }
};
