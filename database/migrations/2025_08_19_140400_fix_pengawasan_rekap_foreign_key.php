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
        // First, drop the problematic foreign key constraint if it exists
        Schema::table('pengawasan_rekap', function (Blueprint $table) {
            // Check if the foreign key exists before dropping it
            if (Schema::getConnection()->getSchemaBuilder()->hasColumn('pengawasan_rekap', 'tindakan_id')) {
                $table->dropForeign(['tindakan_id']);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This is a one-way migration, no reverse needed
    }
};
