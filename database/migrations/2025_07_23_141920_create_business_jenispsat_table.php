<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('business_jenispsat', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('business_id')->constrained('business')->onDelete('cascade');
            $table->foreignUuid('jenispsat_id')->constrained('master_jenis_pangan_segars')->onDelete('cascade');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->string('created_by')->nullable()->default(null);
            $table->string('updated_by')->nullable()->default(null);
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('business_jenispsat');
    }
};
