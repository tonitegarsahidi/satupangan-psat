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
        Schema::create('message_threads', function (Blueprint $table) {
            // Use UUID for the primary key
            $table->uuid('id')->primary();

            // Thread details
            $table->string('title');
            $table->text('description')->nullable();

            // Foreign keys to users table using UUID, with cascade on delete
            $table->uuid('initiator_id');
            $table->foreign('initiator_id')->references('id')->on('users')->onDelete('cascade');

            $table->uuid('participant_id');
            $table->foreign('participant_id')->references('id')->on('users')->onDelete('cascade');

            // Read status tracking
            $table->boolean('is_read_by_initiator')->default(false)->index();
            $table->boolean('is_read_by_participant')->default(false)->index();

            // Last message timestamp
            $table->timestamp('last_message_at')->nullable();

            // Audit fields
            $table->string('created_by')->nullable()->default(null);
            $table->string('updated_by')->nullable()->default(null);

            // Timestamps and soft deletes
            $table->timestamps();
            $table->softDeletes();

            // Index for performance
            $table->index(['initiator_id', 'participant_id']);
            $table->index(['participant_id', 'initiator_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('message_threads');
    }
};
