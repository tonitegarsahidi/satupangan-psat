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
        Schema::create('batas_cemaran_pestisidas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('jenis_psat')->references('id')->on('master_jenis_pangan_segars');
            $table->foreignUuid('cemaran_pestisida')->references('id')->on('master_cemaran_pestisidas');
            $table->decimal('value_min', 10, 2)->nullable();
            $table->decimal('value_max', 10, 2)->nullable();
            $table->string('satuan', 50)->nullable();
            $table->string('metode', 100)->nullable();
            $table->string('keterangan', 200)->nullable();
            $table->boolean('is_active')->default(TRUE);
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
        Schema::dropIfExists('batas_cemaran_pestisidas');
    }
};
