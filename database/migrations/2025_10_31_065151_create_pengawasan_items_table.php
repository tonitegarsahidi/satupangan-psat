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
        Schema::create('pengawasan_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('pengawasan_id');
            $table->string('type', 50)->nullable();
            $table->string('test_name')->nullable();
            $table->string('test_parameter')->nullable();
            $table->uuid('komoditas_id')->nullable();
            $table->decimal('value_numeric', 15, 4)->nullable();
            $table->string('value_string')->nullable();
            $table->string('value_unit', 50)->nullable();
            $table->boolean('is_positif')->default(true);
            $table->boolean('is_memenuhisyarat')->default(true);
            $table->string('keterangan')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('pengawasan_id')->references('id')->on('pengawasan')->onDelete('cascade');
            $table->foreign('komoditas_id')->references('id')->on('master_bahan_pangan_segars');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengawasan_items');
    }
};
