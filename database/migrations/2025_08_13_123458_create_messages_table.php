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
        Schema::create('messages', function (Blueprint $table) {
            // Use UUID for the primary key
            $table->uuid('id')->primary();

            // Foreign key to message_threads table using UUID, with cascade on delete
            $table->uuid('thread_id');
            $table->foreign('thread_id')->references('id')->on('message_threads')->onDelete('cascade');

            // Foreign key to users table using UUID, with cascade on delete
            $table->uuid('sender_id');
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');

            // Message content
            $table->text('message');
            $table->text('raw_message')->nullable(); // Original message before any processing

            // Read status
            $table->boolean('is_read')->default(false)->index();
            $table->timestamp('read_at')->nullable();

            // Message metadata
            $table->boolean('is_edited')->default(false);
            $table->timestamp('edited_at')->nullable();

            // Attachments (if needed in future)
            $table->json('attachments')->nullable();

            // Audit fields
            $table->string('created_by')->nullable()->default(null);
            $table->string('updated_by')->nullable()->default(null);

            // Timestamps and soft deletes
            $table->timestamps();
            $table->softDeletes();

            // Index for performance
            $table->index(['thread_id', 'created_at']);
            $table->index(['sender_id', 'thread_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
};
