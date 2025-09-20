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
        Schema::create('pengawasan_tindakan_lanjutan_detail', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('pengawasan_tindakan_lanjutan_id');
            $table->text('message');
            $table->string('lampiran1', 200)->nullable();
            $table->string('lampiran2', 200)->nullable();
            $table->string('lampiran3', 200)->nullable();
            $table->string('lampiran4', 200)->nullable();
            $table->string('lampiran5', 200)->nullable();
            $table->string('lampiran6', 200)->nullable();
            $table->boolean('is_active')->default(true);
            $table->uuid('created_by');
            $table->uuid('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('pengawasan_tindakan_lanjutan_id', 'ptld_lanjutan_id_fk')->references('id')->on('pengawasan_tindakan_lanjutan');
            $table->foreign('created_by', 'ptld_created_by_fk')->references('id')->on('users');
            $table->foreign('updated_by', 'ptld_updated_by_fk')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengawasan_tindakan_lanjutan_detail');
    }
};
