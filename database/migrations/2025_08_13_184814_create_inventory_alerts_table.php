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
        Schema::create('inventory_alerts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('batch_id')->nullable()->constrained('inventory_batches')->onDelete('cascade');
            
            // Alert details
            $table->enum('type', [
                'low_stock', 'reorder_point', 'expiry_warning', 'expiry_critical',
                'expired', 'overstock', 'zero_stock', 'negative_stock',
                'batch_expiry', 'quality_issue', 'location_change'
            ]);
            $table->enum('priority', ['low', 'medium', 'high', 'critical'])->default('medium');
            $table->string('title');
            $table->text('message');
            $table->json('data')->nullable(); // Additional alert data
            
            // Status and actions
            $table->enum('status', ['active', 'acknowledged', 'resolved', 'dismissed'])->default('active');
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('acknowledged_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('acknowledged_at')->nullable();
            $table->foreignId('resolved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('resolved_at')->nullable();
            $table->text('resolution_notes')->nullable();
            
            // Scheduling and repetition
            $table->timestamp('trigger_date')->nullable();
            $table->timestamp('next_check_date')->nullable();
            $table->boolean('is_recurring')->default(false);
            $table->string('recurrence_rule')->nullable(); // daily, weekly, monthly
            
            // Notification settings
            $table->boolean('email_sent')->default(false);
            $table->boolean('sms_sent')->default(false);
            $table->json('notification_channels')->nullable(); // email, sms, push
            $table->timestamp('last_notification_sent')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index(['product_id', 'status', 'type']);
            $table->index(['batch_id', 'status']);
            $table->index(['type', 'priority', 'status']);
            $table->index(['trigger_date', 'status']);
            $table->index(['assigned_to', 'status']);
            $table->index(['created_at', 'priority']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_alerts');
    }
};