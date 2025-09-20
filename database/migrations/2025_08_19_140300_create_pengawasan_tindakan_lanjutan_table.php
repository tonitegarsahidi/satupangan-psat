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
        Schema::create('pengawasan_tindakan_lanjutan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('pengawasan_tindakan_id');
            $table->uuid('user_id_pic');
            $table->text('arahan_tindak_lanjut');
            $table->string('status', 50);
            $table->boolean('is_active')->default(true);
            $table->uuid('created_by');
            $table->uuid('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('pengawasan_tindakan_id')->references('id')->on('pengawasan_tindakan');
            $table->foreign('user_id_pic')->references('id')->on('users');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengawasan_tindakan_lanjutan');
    }
};
