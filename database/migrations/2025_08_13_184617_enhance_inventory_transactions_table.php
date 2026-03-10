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
        Schema::table('inventory_transactions', function (Blueprint $table) {
            // Enhanced tracking fields
            $table->foreignId('batch_id')->nullable()->constrained('inventory_batches')->onDelete('set null')->after('product_id');
            $table->decimal('unit_cost', 10, 2)->nullable()->after('quantity');
            $table->decimal('total_cost', 10, 2)->nullable()->after('unit_cost');
            $table->string('location_from')->nullable()->after('total_cost');
            $table->string('location_to')->nullable()->after('location_from');
            
            // Extended transaction types
            $table->dropColumn('type');
        });
        
        Schema::table('inventory_transactions', function (Blueprint $table) {
            $table->enum('type', [
                'in', 'out', 'adjustment', 'transfer', 'sale', 'return', 
                'damage', 'expired', 'lost', 'found', 'cycle_count'
            ])->after('batch_id');
            
            // Additional tracking
            $table->string('document_type')->nullable()->after('reference_number'); // invoice, purchase_order, etc.
            $table->json('metadata')->nullable()->after('document_type'); // Additional data storage
            $table->timestamp('transaction_date')->nullable()->after('metadata');
            $table->boolean('is_automatic')->default(false)->after('transaction_date');
            
            // Approval workflow
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed'])->default('completed')->after('is_automatic');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null')->after('status');
            $table->timestamp('approved_at')->nullable()->after('approved_by');
            $table->text('notes')->nullable()->after('approved_at');
            
            // Indexes
            $table->index(['product_id', 'type', 'status']);
            $table->index(['batch_id', 'type']);
            $table->index(['transaction_date', 'type']);
            $table->index(['user_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventory_transactions', function (Blueprint $table) {
            $table->dropForeign(['batch_id']);
            $table->dropForeign(['approved_by']);
            $table->dropIndex(['product_id', 'type', 'status']);
            $table->dropIndex(['batch_id', 'type']);
            $table->dropIndex(['transaction_date', 'type']);
            $table->dropIndex(['user_id', 'created_at']);
            
            $table->dropColumn([
                'batch_id',
                'unit_cost',
                'total_cost',
                'location_from',
                'location_to',
                'document_type',
                'metadata',
                'transaction_date',
                'is_automatic',
                'status',
                'approved_by',
                'approved_at',
                'notes'
            ]);
        });
        
        Schema::table('inventory_transactions', function (Blueprint $table) {
            $table->enum('type', ['in', 'out', 'adjustment'])->after('user_id');
        });
    }
};