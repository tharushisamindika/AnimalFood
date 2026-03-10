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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->string('action'); // created, updated, deleted
            $table->string('model_type'); // The model class name
            $table->unsignedBigInteger('model_id'); // The model ID
            $table->json('old_values')->nullable(); // Original values before change
            $table->json('new_values')->nullable(); // New values after change
            $table->json('changed_fields')->nullable(); // Only the fields that changed
            $table->unsignedBigInteger('user_id')->nullable(); // Who made the change
            $table->string('user_name')->nullable(); // User name at time of change
            $table->string('ip_address')->nullable(); // IP address
            $table->string('user_agent')->nullable(); // Browser/user agent
            $table->string('url')->nullable(); // The URL where the change occurred
            $table->text('description')->nullable(); // Human-readable description
            $table->timestamps();

            // Indexes for better performance
            $table->index(['model_type', 'model_id']);
            $table->index('user_id');
            $table->index('action');
            $table->index('created_at');
            
            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
