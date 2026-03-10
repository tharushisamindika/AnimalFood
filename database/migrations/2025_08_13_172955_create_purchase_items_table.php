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
        Schema::create('purchase_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('restrict');
            $table->decimal('unit_cost', 10, 2); // Cost per unit from supplier
            $table->integer('quantity_ordered'); // Quantity ordered
            $table->integer('quantity_received')->default(0); // Quantity actually received
            $table->integer('quantity_pending')->default(0); // Pending to receive
            $table->decimal('total_cost', 12, 2); // Total cost for this item
            $table->date('expiry_date')->nullable(); // Expiry date for this batch
            $table->string('batch_number')->nullable(); // Batch/Lot number
            $table->text('notes')->nullable();
            $table->enum('status', ['pending', 'partial', 'received', 'cancelled'])->default('pending');
            $table->timestamps();

            // Indexes
            $table->index(['purchase_id', 'product_id']);
            $table->index('product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_items');
    }
};