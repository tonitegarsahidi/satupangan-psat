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
        Schema::create('sppb_penanganan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('penanganan_id')->constrained('master_penanganan')->onDelete('cascade');
            $table->foreignUuid('sppb_id')->constrained('register_sppb')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sppb_penanganan');
    }
};
