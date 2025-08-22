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
        Schema::create('early_warnings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('creator_id')->constrained('users')->onDelete('cascade');
            $table->string('status', 50)->default('Draft'); // Draft, Approved, Published
            $table->string('title', 200)->nullable(false);
            $table->text('content')->nullable(false);
            $table->text('related_product')->nullable();
            $table->text('preventive_steps')->nullable();
            $table->string('attachment_path')->nullable(); // For file uploads (image/document)
            $table->string('url', 200)->nullable();
            $table->string('urgency_level', 50)->default('Info'); // Danger, Warning, Info
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('early_warnings');
    }
};
