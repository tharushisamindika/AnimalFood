<?php

namespace Database\Seeders;

use App\Models\Sales;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create a user
        $user = User::firstOrCreate([
            'email' => 'test@example.com'
        ], [
            'name' => 'Test User',
            'password' => bcrypt('password'),
        ]);

        // Get or create some products
        $products = [
            Product::firstOrCreate(['name' => 'Premium Dog Food'], [
                'name' => 'Premium Dog Food',
                'description' => 'High-quality dog food for all breeds',
                'price' => 89.99,
                'stock_quantity' => 100,
                'unit' => '25kg bag',
                'category' => 'Dog Food',
                'sku' => 'DOG-001',
                'brand' => 'Premium Pets',
                'supplier_id' => 1,
                'status' => 'active',
            ]),
            Product::firstOrCreate(['name' => 'Cat Food Mix'], [
                'name' => 'Cat Food Mix',
                'description' => 'Nutritious cat food blend',
                'price' => 67.50,
                'stock_quantity' => 75,
                'unit' => '15kg bag',
                'category' => 'Cat Food',
                'sku' => 'CAT-001',
                'brand' => 'Premium Pets',
                'supplier_id' => 1,
                'status' => 'active',
            ]),
            Product::firstOrCreate(['name' => 'Bird Seed Mix'], [
                'name' => 'Bird Seed Mix',
                'description' => 'Premium bird seed blend',
                'price' => 34.99,
                'stock_quantity' => 50,
                'unit' => '5kg bag',
                'category' => 'Bird Food',
                'sku' => 'BIRD-001',
                'brand' => 'Premium Pets',
                'supplier_id' => 1,
                'status' => 'active',
            ]),
            Product::firstOrCreate(['name' => 'Fish Food'], [
                'name' => 'Fish Food',
                'description' => 'Complete fish food formula',
                'price' => 24.99,
                'stock_quantity' => 200,
                'unit' => '500g container',
                'category' => 'Fish Food',
                'sku' => 'FISH-001',
                'brand' => 'Premium Pets',
                'supplier_id' => 1,
                'status' => 'active',
            ]),
        ];

        // Generate sales data for the last 30 days
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            
            // Generate 1-5 sales per day
            $dailySales = rand(1, 5);
            
            for ($j = 0; $j < $dailySales; $j++) {
                $product = $products[array_rand($products)];
                $quantity = rand(1, 3);
                $unitPrice = $product->price;
                $totalAmount = $quantity * $unitPrice;
                
                // Create sale
                Sales::create([
                    'product_id' => $product->id,
                    'user_id' => $user->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                    'total_amount' => $totalAmount,
                    'type' => 'sale',
                    'status' => 'completed',
                    'notes' => 'Sample sale data',
                    'created_at' => $date->copy()->addHours(rand(9, 17))->addMinutes(rand(0, 59)),
                ]);
                
                // Occasionally create a refund (10% chance)
                if (rand(1, 10) === 1) {
                    $refundQuantity = rand(1, $quantity);
                    $refundAmount = $refundQuantity * $unitPrice;
                    
                    Sales::create([
                        'product_id' => $product->id,
                        'user_id' => $user->id,
                        'quantity' => $refundQuantity,
                        'unit_price' => $unitPrice,
                        'total_amount' => $refundAmount,
                        'type' => 'refund',
                        'status' => 'completed',
                        'notes' => 'Sample refund data',
                        'created_at' => $date->copy()->addDays(rand(1, 3))->addHours(rand(9, 17))->addMinutes(rand(0, 59)),
                    ]);
                }
            }
        }
    }
}
