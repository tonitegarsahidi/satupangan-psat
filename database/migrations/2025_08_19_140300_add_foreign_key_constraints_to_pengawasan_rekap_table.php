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
        // Add foreign key constraint for tindakan_id after both tables exist
        Schema::table('pengawasan_rekap', function (Blueprint $table) {
            $table->foreign('tindakan_id')->references('id')->on('pengawasan_tindakan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengawasan_rekap', function (Blueprint $table) {
            $table->dropForeign(['tindakan_id']);
        });
    }
};
