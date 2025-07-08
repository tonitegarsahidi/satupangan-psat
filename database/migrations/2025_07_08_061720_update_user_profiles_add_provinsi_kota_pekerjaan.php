<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUserProfilesAddProvinsiKotaPekerjaan extends Migration
{
    public function up()
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->string('provinsi_id', 36)->nullable()->after('address');
            $table->string('kota_id', 36)->nullable()->after('provinsi_id');
            $table->string('pekerjaan', 100)->nullable()->after('kota_id');

            $table->dropColumn('city');
            $table->dropColumn('country');

            $table->foreign('provinsi_id')->references('id')->on('master_provinsis')->onDelete('set null');
            $table->foreign('kota_id')->references('id')->on('master_kotas')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('user_profiles', function (Blueprint $table) {
            $table->dropForeign(['provinsi_id']);
            $table->dropForeign(['kota_id']);
            $table->dropColumn('provinsi_id');
            $table->dropColumn('kota_id');
            $table->dropColumn('pekerjaan');

            $table->string('city', 100)->nullable()->after('address');
            $table->string('country', 100)->nullable()->after('city');
        });
    }
}
