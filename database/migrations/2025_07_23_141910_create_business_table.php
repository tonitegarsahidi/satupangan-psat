<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('business', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');
            $table->string('nama_perusahaan');
            $table->string('alamat_perusahaan')->nullable();
            $table->string('jabatan_perusahaan')->nullable();
            $table->string('nib')->nullable();
            $table->string('provinsi_id', 36)->nullable();
            $table->string('kota_id', 36)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->string('created_by')->nullable()->default(null);
            $table->string('updated_by')->nullable()->default(null);
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('business');
    }
};
