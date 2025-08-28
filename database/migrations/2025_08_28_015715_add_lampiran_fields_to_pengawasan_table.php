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
        Schema::table('pengawasan', function (Blueprint $table) {
            $table->string('lampiran1', 200)->nullable()->after('hasil_pengawasan');
            $table->string('lampiran2', 200)->nullable()->after('lampiran1');
            $table->string('lampiran3', 200)->nullable()->after('lampiran2');
            $table->string('lampiran4', 200)->nullable()->after('lampiran3');
            $table->string('lampiran5', 200)->nullable()->after('lampiran4');
            $table->string('lampiran6', 200)->nullable()->after('lampiran5');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengawasan', function (Blueprint $table) {
            $table->dropColumn(['lampiran1', 'lampiran2', 'lampiran6']);
        });
    }
};
