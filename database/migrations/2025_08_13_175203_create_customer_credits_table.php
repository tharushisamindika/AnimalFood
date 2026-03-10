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
        Schema::create('customer_credits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->decimal('credit_limit', 12, 2)->default(0); // Maximum credit allowed
            $table->decimal('current_balance', 12, 2)->default(0); // Current outstanding balance
            $table->decimal('available_credit', 12, 2)->default(0); // Available credit
            $table->decimal('total_purchases', 12, 2)->default(0); // Lifetime purchases
            $table->decimal('total_payments', 12, 2)->default(0); // Lifetime payments
            $table->date('last_payment_date')->nullable();
            $table->date('credit_approval_date')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('credit_status', ['active', 'suspended', 'blocked'])->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('customer_id');
            $table->index('credit_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_credits');
    }
};