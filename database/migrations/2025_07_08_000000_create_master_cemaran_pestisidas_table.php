<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('master_cemaran_pestisidas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('kode_cemaran_pestisida', 12)->nullable();
            $table->string('nama_cemaran_pestisida', 100);
            $table->tinyText('keterangan')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            $table->string('created_by')->nullable()->default(null);
            $table->string('updated_by')->nullable()->default(null);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_cemaran_pestisidas');
    }
};
