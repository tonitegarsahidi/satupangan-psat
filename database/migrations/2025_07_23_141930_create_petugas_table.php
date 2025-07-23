<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('petugas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');
            $table->string('unit_kerja');
            $table->string('jabatan');
            $table->boolean('is_kantor_pusat')->default(true);
            $table->foreignUuid('penempatan')->nullable()->constrained('master_provinsis')->onDelete('set null');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->string('created_by')->nullable()->default(null);
            $table->string('updated_by')->nullable()->default(null);
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('petugas');
    }
};
