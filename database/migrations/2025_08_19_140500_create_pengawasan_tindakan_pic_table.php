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
        Schema::create('pengawasan_tindakan_pic', function (Blueprint $table) {
            $table->uuid('tindakan_id');
            $table->uuid('pic_id');
            $table->timestamps();

            $table->foreign('tindakan_id')->references('id')->on('pengawasan_tindakan');
            $table->foreign('pic_id')->references('id')->on('users');

            $table->primary(['tindakan_id', 'pic_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengawasan_tindakan_pic');
    }
};
