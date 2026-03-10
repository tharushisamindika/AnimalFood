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
        Schema::create('purchase_returns', function (Blueprint $table) {
            $table->id();
            $table->string('return_number')->unique(); // Return Reference Number
            $table->foreignId('purchase_id')->constrained()->onDelete('restrict');
            $table->foreignId('purchase_item_id')->nullable()->constrained()->onDelete('restrict');
            $table->foreignId('product_id')->constrained()->onDelete('restrict');
            $table->foreignId('supplier_id')->constrained()->onDelete('restrict');
            $table->foreignId('user_id')->constrained()->onDelete('restrict'); // Who initiated the return
            $table->date('return_date');
            $table->integer('quantity_returned');
            $table->decimal('unit_cost', 10, 2); // Original cost per unit
            $table->decimal('total_amount', 12, 2); // Total return amount
            $table->enum('reason', [
                'defective',
                'expired',
                'wrong_item',
                'overage',
                'damaged',
                'quality_issue',
                'other'
            ]);
            $table->text('reason_description');
            $table->enum('status', ['pending', 'approved', 'rejected', 'processed', 'completed'])->default('pending');
            $table->enum('refund_method', ['credit_note', 'bank_transfer', 'cash', 'replacement'])->nullable();
            $table->date('refund_date')->nullable();
            $table->decimal('refund_amount', 12, 2)->default(0);
            $table->text('notes')->nullable();
            $table->json('attachments')->nullable(); // Photos/documents
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();

            // Indexes
            $table->index(['purchase_id', 'status']);
            $table->index(['supplier_id', 'return_date']);
            $table->index('return_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_returns');
    }
};