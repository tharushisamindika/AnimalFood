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
        Schema::create('inventory_batches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('batch_number')->unique();
            $table->string('lot_number')->nullable();
            $table->integer('quantity_received');
            $table->integer('quantity_remaining');
            $table->integer('quantity_allocated')->default(0); // Reserved for orders
            $table->decimal('unit_cost', 10, 2);
            $table->decimal('selling_price', 10, 2)->nullable();
            
            // Dates
            $table->date('received_date');
            $table->date('manufacture_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->date('best_before_date')->nullable();
            
            // Source tracking
            $table->foreignId('supplier_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('purchase_id')->nullable()->constrained()->onDelete('set null');
            $table->string('invoice_number')->nullable();
            
            // Quality and storage
            $table->enum('quality_status', ['good', 'damaged', 'expired', 'recalled'])->default('good');
            $table->string('storage_location')->nullable();
            $table->text('quality_notes')->nullable();
            
            // Tracking
            $table->foreignId('received_by')->nullable()->constrained('users')->onDelete('set null');
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_movement')->nullable();
            
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['product_id', 'is_active']);
            $table->index(['expiry_date', 'is_active']);
            $table->index(['received_date', 'product_id']);
            $table->index('batch_number');
            $table->index(['quantity_remaining', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_batches');
    }
};