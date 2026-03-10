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
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_number')->unique();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('user_id')->constrained()->onDelete('restrict'); // Who processed the payment
            $table->enum('type', ['payment', 'refund', 'credit_adjustment', 'late_fee'])->default('payment');
            $table->enum('payment_method', ['cash', 'card', 'bank_transfer', 'credit', 'cheque', 'mobile_payment'])->default('cash');
            $table->decimal('amount', 12, 2);
            $table->date('payment_date');
            $table->string('reference_number')->nullable(); // Bank ref, cheque number, etc.
            $table->text('description')->nullable();
            $table->json('payment_details')->nullable(); // Store additional payment info
            $table->enum('status', ['pending', 'completed', 'failed', 'cancelled'])->default('completed');
            $table->text('notes')->nullable();
            $table->timestamps();

            // Indexes
            $table->index(['customer_id', 'payment_date']);
            $table->index(['payment_method', 'status']);
            $table->index('transaction_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};