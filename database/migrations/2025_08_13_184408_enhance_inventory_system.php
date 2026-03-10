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
        Schema::table('products', function (Blueprint $table) {
            // Inventory Management Fields
            $table->string('barcode')->nullable()->unique()->after('sku');
            $table->string('qr_code')->nullable()->after('barcode');
            $table->decimal('cost_price', 10, 2)->default(0)->after('price');
            $table->integer('reorder_level')->default(10)->after('stock_quantity');
            $table->integer('max_stock_level')->default(1000)->after('reorder_level');
            $table->integer('minimum_stock_level')->default(5)->after('max_stock_level');
            
            // Stock Management
            $table->enum('stock_method', ['FIFO', 'LIFO', 'Average'])->default('FIFO')->after('minimum_stock_level');
            $table->decimal('average_cost', 10, 2)->default(0)->after('stock_method');
            $table->boolean('track_batches')->default(true)->after('average_cost');
            $table->boolean('track_expiry')->default(true)->after('track_batches');
            
            // Alert Settings
            $table->boolean('low_stock_alert')->default(true)->after('track_expiry');
            $table->boolean('expiry_alert')->default(true)->after('low_stock_alert');
            $table->integer('expiry_alert_days')->default(30)->after('expiry_alert');
            $table->boolean('reorder_alert')->default(true)->after('expiry_alert_days');
            
            // Additional Fields
            $table->string('location')->nullable()->after('reorder_alert');
            $table->string('storage_conditions')->nullable()->after('location');
            $table->decimal('weight', 8, 3)->nullable()->after('storage_conditions');
            $table->string('weight_unit')->default('kg')->after('weight');
            
            // Timestamps for tracking
            $table->timestamp('last_stock_update')->nullable()->after('weight_unit');
            $table->timestamp('last_ordered')->nullable()->after('last_stock_update');
            
            // Indexes for performance
            $table->index('barcode');
            $table->index('reorder_level');
            $table->index(['stock_quantity', 'reorder_level']);
            $table->index(['expiry_date', 'expiry_alert_days']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['barcode']);
            $table->dropIndex(['reorder_level']);
            $table->dropIndex(['stock_quantity', 'reorder_level']);
            $table->dropIndex(['expiry_date', 'expiry_alert_days']);
            
            $table->dropColumn([
                'barcode',
                'qr_code',
                'cost_price',
                'reorder_level',
                'max_stock_level',
                'minimum_stock_level',
                'stock_method',
                'average_cost',
                'track_batches',
                'track_expiry',
                'low_stock_alert',
                'expiry_alert',
                'expiry_alert_days',
                'reorder_alert',
                'location',
                'storage_conditions',
                'weight',
                'weight_unit',
                'last_stock_update',
                'last_ordered',
            ]);
        });
    }
};