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
        Schema::table('orders', function (Blueprint $table) {
            // Enhanced payment methods
            $table->dropColumn('payment_method');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->enum('payment_method', ['cash', 'card', 'bank_transfer', 'credit', 'cheque', 'mobile_payment', 'mixed'])->default('cash')->after('payment_status');
            
            // Discount enhancements
            $table->foreignId('discount_type_id')->nullable()->constrained()->onDelete('set null')->after('discount_amount');
            $table->string('discount_code')->nullable()->after('discount_type_id');
            $table->enum('discount_type', ['percentage', 'fixed_amount'])->default('fixed_amount')->after('discount_code');
            $table->decimal('discount_percentage', 5, 2)->nullable()->after('discount_type');
            
            // Payment tracking
            $table->decimal('paid_amount', 10, 2)->default(0)->after('final_amount');
            $table->decimal('due_amount', 10, 2)->default(0)->after('paid_amount');
            $table->date('due_date')->nullable()->after('due_amount');
            
            // Credit and billing
            $table->boolean('is_credit_sale')->default(false)->after('due_date');
            $table->decimal('credit_used', 10, 2)->default(0)->after('is_credit_sale');
            
            // Additional fields
            $table->string('invoice_number')->nullable()->unique()->after('order_number');
            $table->json('payment_breakdown')->nullable()->after('credit_used'); // For mixed payments
            $table->timestamp('invoice_date')->nullable()->after('payment_breakdown');
            $table->decimal('rounding_adjustment', 5, 2)->default(0)->after('invoice_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['discount_type_id']);
            $table->dropColumn([
                'discount_type_id',
                'discount_code',
                'discount_type',
                'discount_percentage',
                'paid_amount',
                'due_amount',
                'due_date',
                'is_credit_sale',
                'credit_used',
                'invoice_number',
                'payment_breakdown',
                'invoice_date',
                'rounding_adjustment'
            ]);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('payment_method');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->enum('payment_method', ['cash', 'card', 'bank_transfer'])->default('cash')->after('payment_status');
        });
    }
};