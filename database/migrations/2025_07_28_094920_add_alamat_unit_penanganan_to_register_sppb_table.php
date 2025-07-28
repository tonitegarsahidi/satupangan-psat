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
        Schema::table('register_sppb', function (Blueprint $table) {
            $table->string('alamat_unit_penanganan', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('register_sppb', function (Blueprint $table) {
            $table->dropColumn('alamat_unit_penanganan');
        });
    }
};
