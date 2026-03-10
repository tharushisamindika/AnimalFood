<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\InventoryAlert;
use App\Models\InventoryBatch;
use App\Models\InventoryTransaction;
use App\Models\User;
use Carbon\Carbon;

class InventoryAlertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing inventory data
        InventoryAlert::truncate();
        InventoryTransaction::truncate();
        InventoryBatch::truncate();
        
        // Get or create a test user
        $user = User::first();
        if (!$user) {
            $user = User::create([
                'name' => 'Admin User',
                'email' => 'admin@animalfood.com',
                'password' => bcrypt('password'),
                'role' => 'administrator'
            ]);
        }

        // Get all products for creating alerts
        $products = Product::all();
        
        if ($products->isEmpty()) {
            $this->command->warn('No products found. Running ProductSeeder first...');
            $this->call(ProductSeeder::class);
            $products = Product::all();
        }

        // Create inventory batches for products that track batches
        foreach ($products->where('track_batches', true)->take(8) as $product) {
            // Create some batches with different expiry dates
            $timestamp = now()->format('YmdHis');
            $batches = [
                [
                    'batch_number' => 'BATCH-' . $product->sku . '-001-' . $timestamp,
                    'quantity_received' => 50,
                    'quantity_remaining' => 15, // Low remaining quantity
                    'expiry_date' => now()->addDays(15), // Expiring soon
                    'received_date' => now()->subDays(30),
                    'unit_cost' => $product->cost_price,
                    'supplier_id' => $product->supplier_id,
                ],
                [
                    'batch_number' => 'BATCH-' . $product->sku . '-002-' . $timestamp,
                    'quantity_received' => 100,
                    'quantity_remaining' => 85,
                    'expiry_date' => now()->addDays(45),
                    'received_date' => now()->subDays(15),
                    'unit_cost' => $product->cost_price,
                    'supplier_id' => $product->supplier_id,
                ],
                [
                    'batch_number' => 'BATCH-' . $product->sku . '-003-' . $timestamp,
                    'quantity_received' => 75,
                    'quantity_remaining' => 0, // Expired batch
                    'expiry_date' => now()->subDays(5), // Already expired
                    'received_date' => now()->subDays(60),
                    'unit_cost' => $product->cost_price,
                    'supplier_id' => $product->supplier_id,
                ]
            ];

            foreach ($batches as $batchData) {
                $batch = InventoryBatch::create(array_merge($batchData, [
                    'product_id' => $product->id,
                    'lot_number' => 'LOT-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
                    'quality_status' => $batchData['expiry_date']->isPast() ? 'expired' : 'good',
                    'storage_location' => 'Warehouse-' . chr(65 + rand(0, 2)), // A, B, or C
                    'received_by' => $user->id,
                    'is_active' => !$batchData['expiry_date']->isPast(),
                    'last_movement' => now()->subDays(rand(1, 10))
                ]));

                // Create inventory transactions for these batches
                InventoryTransaction::create([
                    'product_id' => $product->id,
                    'batch_id' => $batch->id,
                    'user_id' => $user->id,
                    'type' => 'in',
                    'quantity' => $batchData['quantity_received'],
                    'unit_cost' => $batchData['unit_cost'],
                    'total_cost' => $batchData['quantity_received'] * $batchData['unit_cost'],
                    'reason' => 'Stock received from supplier',
                    'reference_number' => 'PO-' . date('Y') . '-' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT),
                    'document_type' => 'purchase_order',
                    'transaction_date' => $batchData['received_date'],
                    'status' => 'completed',
                    'is_automatic' => false
                ]);
            }
        }

        // Update some products to have low stock
        $lowStockProducts = $products->take(5);
        foreach ($lowStockProducts as $index => $product) {
            $product->update([
                'stock_quantity' => $index == 0 ? 0 : rand(1, $product->reorder_level - 1),
                'last_stock_update' => now()->subDays(rand(1, 7))
            ]);
        }

        // Create various types of inventory alerts
        $alertTypes = [
            [
                'type' => 'low_stock',
                'priority' => 'high',
                'title' => 'Low Stock Alert',
                'products' => $products->where('stock_quantity', '>', 0)->where('stock_quantity', '<=', 10)->take(3)
            ],
            [
                'type' => 'zero_stock',
                'priority' => 'critical',
                'title' => 'Out of Stock Alert',
                'products' => $products->where('stock_quantity', 0)->take(2)
            ],
            [
                'type' => 'expiry_warning',
                'priority' => 'medium',
                'title' => 'Expiry Warning',
                'products' => $products->where('expiry_date', '<=', now()->addDays(30))->take(4)
            ],
            [
                'type' => 'reorder_point',
                'priority' => 'medium',
                'title' => 'Reorder Point Reached',
                'products' => $products->where('stock_quantity', '>', 0)->take(3)
            ]
        ];

        foreach ($alertTypes as $alertType) {
            foreach ($alertType['products'] as $product) {
                $alertData = [
                    'product_id' => $product->id,
                    'type' => $alertType['type'],
                    'priority' => $alertType['priority'],
                    'title' => $alertType['title'] . ': ' . $product->name,
                    'status' => rand(0, 10) < 8 ? 'active' : 'acknowledged', // 80% active, 20% acknowledged
                    'trigger_date' => now()->subDays(rand(0, 7)),
                    'created_at' => now()->subDays(rand(0, 7)),
                    'updated_at' => now()->subDays(rand(0, 3))
                ];

                switch ($alertType['type']) {
                    case 'low_stock':
                        $alertData['message'] = "Product {$product->name} is running low. Current stock: {$product->stock_quantity}, Reorder level: {$product->reorder_level}";
                        $alertData['data'] = [
                            'current_stock' => $product->stock_quantity,
                            'reorder_level' => $product->reorder_level,
                            'suggested_order_quantity' => $product->max_stock_level - $product->stock_quantity
                        ];
                        break;
                        
                    case 'zero_stock':
                        $alertData['message'] = "Product {$product->name} (SKU: {$product->sku}) is completely out of stock. Immediate action required.";
                        $alertData['data'] = [
                            'current_stock' => 0,
                            'last_stock_update' => $product->last_stock_update?->toISOString(),
                            'last_sale_date' => now()->subDays(rand(1, 5))->toISOString()
                        ];
                        break;
                        
                    case 'expiry_warning':
                        $daysToExpiry = $product->expiry_date ? $product->expiry_date->diffInDays(now()) : 30;
                        $alertData['message'] = "Product {$product->name} will expire in {$daysToExpiry} days. Current stock: {$product->stock_quantity}";
                        $alertData['data'] = [
                            'expiry_date' => $product->expiry_date?->toISOString(),
                            'days_to_expiry' => $daysToExpiry,
                            'current_stock' => $product->stock_quantity
                        ];
                        break;
                        
                    case 'reorder_point':
                        $alertData['message'] = "Product {$product->name} has reached reorder point. Current stock: {$product->stock_quantity}, Reorder level: {$product->reorder_level}";
                        $alertData['data'] = [
                            'current_stock' => $product->stock_quantity,
                            'reorder_level' => $product->reorder_level,
                            'suggested_order_quantity' => $product->max_stock_level - $product->stock_quantity
                        ];
                        break;
                }

                InventoryAlert::create($alertData);
            }
        }

        // Create some batch-specific alerts
        $expiredBatches = InventoryBatch::with('product')->where('expiry_date', '<', now())->take(3)->get();
        foreach ($expiredBatches as $batch) {
            InventoryAlert::create([
                'product_id' => $batch->product_id,
                'batch_id' => $batch->id,
                'type' => 'expired',
                'priority' => 'critical',
                'title' => 'Expired Batch Alert: ' . $batch->product->name,
                'message' => "Batch {$batch->batch_number} of {$batch->product->name} has expired on {$batch->expiry_date->format('Y-m-d')}. Quantity: {$batch->quantity_remaining}",
                'data' => [
                    'batch_number' => $batch->batch_number,
                    'expiry_date' => $batch->expiry_date->toISOString(),
                    'quantity_remaining' => $batch->quantity_remaining,
                    'days_expired' => $batch->expiry_date->diffInDays(now())
                ],
                'status' => 'active',
                'trigger_date' => $batch->expiry_date,
                'created_at' => $batch->expiry_date->addDay(),
                'updated_at' => now()
            ]);
        }

        // Create some quality alerts
        $qualityIssueProducts = $products->take(2);
        foreach ($qualityIssueProducts as $product) {
            InventoryAlert::create([
                'product_id' => $product->id,
                'type' => 'quality_issue',
                'priority' => 'high',
                'title' => 'Quality Issue: ' . $product->name,
                'message' => "Quality issue reported for {$product->name}. Batch requires inspection before sale.",
                'data' => [
                    'issue_type' => 'customer_complaint',
                    'reported_by' => 'Customer Service',
                    'description' => 'Customer reported unusual smell in product'
                ],
                'status' => 'active',
                'trigger_date' => now()->subDays(rand(1, 3)),
                'created_at' => now()->subDays(rand(1, 3)),
                'updated_at' => now()->subDays(rand(0, 2))
            ]);
        }

        $this->command->info('Inventory alerts seeded successfully!');
    }
} 