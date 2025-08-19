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
        Schema::create('pengawasan_attachment', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('linked_id');
            $table->enum('linked_type', ['PENGAWASAN', 'REKAP', 'TINDAKAN', 'TINDAKAN_LANJUTAN']);
            $table->string('file_path', 255);
            $table->string('file_name', 255);
            $table->string('file_type', 100)->nullable();
            $table->bigInteger('file_size')->nullable();
            $table->boolean('is_active')->default(true);
            $table->uuid('created_by');
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengawasan_attachment');
    }
};
