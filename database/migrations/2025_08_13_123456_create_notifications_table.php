<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            // Use UUID for the primary key
            $table->uuid('id')->primary();

            // Foreign key to users table using UUID, with cascade on delete
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Notification details
            $table->string('type')->index(); // e.g., 'job_completed', 'registration_issue', 'system_alert'
            $table->string('title');
            $table->text('message');
            $table->json('data')->nullable(); // Additional data if needed

            // Read status
            $table->boolean('is_read')->default(false)->index();

            // Audit fields
            $table->string('created_by')->nullable()->default(null);
            $table->string('updated_by')->nullable()->default(null);

            // Timestamps and soft deletes
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};
