<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workflow_attachments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('linked_type');
            $table->uuid('linked_id');
            $table->string('attachment_type');
            $table->string('attachment_url');
            $table->string('file_name');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->string('created_by')->nullable()->default(null);
            $table->string('updated_by')->nullable()->default(null);
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workflow_attachments');
    }
};
