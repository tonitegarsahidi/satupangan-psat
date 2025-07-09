<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workflows', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id_initiator');
            $table->string('type');
            $table->string('status');
            $table->string('title');
            $table->uuid('current_assignee_id')->nullable();
            $table->uuid('parent_id')->nullable();
            $table->string('category')->nullable();
            $table->dateTime('due_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->string('created_by')->nullable()->default(null);
            $table->string('updated_by')->nullable()->default(null);
            $table->softDeletes();

            $table->foreign('user_id_initiator')->references('id')->on('users');
            $table->foreign('current_assignee_id')->references('id')->on('users');
            $table->foreign('parent_id')->references('id')->on('workflows');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workflows');
    }
};
