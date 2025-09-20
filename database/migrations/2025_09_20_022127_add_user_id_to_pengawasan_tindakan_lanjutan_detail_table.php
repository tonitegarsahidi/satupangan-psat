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
        Schema::table('pengawasan_tindakan_lanjutan_detail', function (Blueprint $table) {
            $table->uuid('user_id')->after('pengawasan_tindakan_lanjutan_id')->nullable();
            $table->foreign('user_id', 'ptld_user_id_fk')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengawasan_tindakan_lanjutan_detail', function (Blueprint $table) {
            $table->dropForeign('ptld_user_id_fk');
            $table->dropColumn('user_id');
        });
    }
};
