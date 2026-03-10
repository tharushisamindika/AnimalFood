<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get categories for reference
        $dogFoodCategory = Category::where('name', 'Dog Food')->first();
        $catFoodCategory = Category::where('name', 'Cat Food')->first();
        $birdFoodCategory = Category::where('name', 'Bird Food')->first();
        $fishFoodCategory = Category::where('name', 'Fish Food')->first();
        $smallAnimalCategory = Category::where('name', 'Small Animal Food')->first();
        $treatsCategory = Category::where('name', 'Treats')->first();
        $supplementsCategory = Category::where('name', 'Supplements')->first();
        $petCareCategory = Category::where('name', 'Pet Care')->first();

        // Get or create a default supplier
        $supplier = Supplier::firstOrCreate(
            ['email' => 'info@petfoodsupplier.com'],
            [
                'name' => 'Premium Pet Food Supplier',
                'supplier_id' => 'SUP001',
                'phone' => '+91-9876543210',
                'address' => '123 Pet Food Street, Mumbai, Maharashtra',
                'contact_person' => 'John Smith',
                'status' => 'active'
            ]
        );

        $products = [
            // Dog Food Products
            [
                'name' => 'Premium Adult Dog Food',
                'description' => 'High-quality dry food for adult dogs with balanced nutrition',
                'category' => 'Dog Food',
                'category_id' => $dogFoodCategory->id,
                'brand' => 'PetCare Plus',
                'price' => 899.00,
                'cost_price' => 650.00,
                'stock_quantity' => 150,
                'reorder_level' => 20,
                'max_stock_level' => 200,
                'minimum_stock_level' => 10,
                'stock_method' => 'FIFO',
                'average_cost' => 650.00,
                'track_batches' => true,
                'track_expiry' => true,
                'low_stock_alert' => true,
                'expiry_alert' => true,
                'expiry_alert_days' => 30,
                'reorder_alert' => true,
                'expiry_date' => now()->addMonths(12),
                'unit' => 'kg',
                'sku' => 'DOG-ADULT-001',
                'barcode' => '8901234567890',
                'supplier_id' => $supplier->id,
                'location' => 'Warehouse A',
                'storage_conditions' => 'Store in cool, dry place',
                'weight' => 5.0,
                'weight_unit' => 'kg',
                'status' => 'active'
            ],
            [
                'name' => 'Puppy Growth Formula',
                'description' => 'Specially formulated for puppies up to 12 months',
                'category' => 'Dog Food',
                'category_id' => $dogFoodCategory->id,
                'brand' => 'PetCare Plus',
                'price' => 799.00,
                'cost_price' => 580.00,
                'stock_quantity' => 80,
                'reorder_level' => 15,
                'max_stock_level' => 120,
                'minimum_stock_level' => 8,
                'stock_method' => 'FIFO',
                'average_cost' => 580.00,
                'track_batches' => true,
                'track_expiry' => true,
                'low_stock_alert' => true,
                'expiry_alert' => true,
                'expiry_alert_days' => 30,
                'reorder_alert' => true,
                'expiry_date' => now()->addMonths(10),
                'unit' => 'kg',
                'sku' => 'DOG-PUPPY-001',
                'barcode' => '8901234567891',
                'supplier_id' => $supplier->id,
                'location' => 'Warehouse A',
                'storage_conditions' => 'Store in cool, dry place',
                'weight' => 3.0,
                'weight_unit' => 'kg',
                'status' => 'active'
            ],
            [
                'name' => 'Senior Dog Formula',
                'description' => 'Low-calorie formula for senior dogs with joint support',
                'category' => 'Dog Food',
                'category_id' => $dogFoodCategory->id,
                'brand' => 'PetCare Plus',
                'price' => 849.00,
                'cost_price' => 620.00,
                'stock_quantity' => 45,
                'reorder_level' => 10,
                'max_stock_level' => 80,
                'minimum_stock_level' => 5,
                'stock_method' => 'FIFO',
                'average_cost' => 620.00,
                'track_batches' => true,
                'track_expiry' => true,
                'low_stock_alert' => true,
                'expiry_alert' => true,
                'expiry_alert_days' => 30,
                'reorder_alert' => true,
                'expiry_date' => now()->addMonths(11),
                'unit' => 'kg',
                'sku' => 'DOG-SENIOR-001',
                'barcode' => '8901234567892',
                'supplier_id' => $supplier->id,
                'location' => 'Warehouse A',
                'storage_conditions' => 'Store in cool, dry place',
                'weight' => 4.0,
                'weight_unit' => 'kg',
                'status' => 'active'
            ],

            // Cat Food Products
            [
                'name' => 'Premium Adult Cat Food',
                'description' => 'Complete nutrition for adult cats with real chicken',
                'category' => 'Cat Food',
                'category_id' => $catFoodCategory->id,
                'brand' => 'Feline Fresh',
                'price' => 649.00,
                'cost_price' => 480.00,
                'stock_quantity' => 120,
                'reorder_level' => 18,
                'max_stock_level' => 150,
                'minimum_stock_level' => 12,
                'stock_method' => 'FIFO',
                'average_cost' => 480.00,
                'track_batches' => true,
                'track_expiry' => true,
                'low_stock_alert' => true,
                'expiry_alert' => true,
                'expiry_alert_days' => 30,
                'reorder_alert' => true,
                'expiry_date' => now()->addMonths(9),
                'unit' => 'kg',
                'sku' => 'CAT-ADULT-001',
                'barcode' => '8901234567893',
                'supplier_id' => $supplier->id,
                'location' => 'Warehouse B',
                'storage_conditions' => 'Store in cool, dry place',
                'weight' => 2.5,
                'weight_unit' => 'kg',
                'status' => 'active'
            ],
            [
                'name' => 'Kitten Growth Formula',
                'description' => 'High-protein formula for kittens up to 12 months',
                'category' => 'Cat Food',
                'category_id' => $catFoodCategory->id,
                'brand' => 'Feline Fresh',
                'price' => 599.00,
                'cost_price' => 440.00,
                'stock_quantity' => 75,
                'reorder_level' => 12,
                'max_stock_level' => 100,
                'minimum_stock_level' => 8,
                'stock_method' => 'FIFO',
                'average_cost' => 440.00,
                'track_batches' => true,
                'track_expiry' => true,
                'low_stock_alert' => true,
                'expiry_alert' => true,
                'expiry_alert_days' => 30,
                'reorder_alert' => true,
                'expiry_date' => now()->addMonths(8),
                'unit' => 'kg',
                'sku' => 'CAT-KITTEN-001',
                'barcode' => '8901234567894',
                'supplier_id' => $supplier->id,
                'location' => 'Warehouse B',
                'storage_conditions' => 'Store in cool, dry place',
                'weight' => 1.5,
                'weight_unit' => 'kg',
                'status' => 'active'
            ],

            // Bird Food Products
            [
                'name' => 'Parrot Seed Mix',
                'description' => 'Premium seed mix for parrots and large birds',
                'category' => 'Bird Food',
                'category_id' => $birdFoodCategory->id,
                'brand' => 'Avian Delight',
                'price' => 299.00,
                'cost_price' => 220.00,
                'stock_quantity' => 60,
                'reorder_level' => 10,
                'max_stock_level' => 80,
                'minimum_stock_level' => 5,
                'stock_method' => 'FIFO',
                'average_cost' => 220.00,
                'track_batches' => true,
                'track_expiry' => true,
                'low_stock_alert' => true,
                'expiry_alert' => true,
                'expiry_alert_days' => 30,
                'reorder_alert' => true,
                'expiry_date' => now()->addMonths(6),
                'unit' => 'kg',
                'sku' => 'BIRD-PARROT-001',
                'barcode' => '8901234567895',
                'supplier_id' => $supplier->id,
                'location' => 'Warehouse C',
                'storage_conditions' => 'Store in cool, dry place',
                'weight' => 1.0,
                'weight_unit' => 'kg',
                'status' => 'active'
            ],

            // Fish Food Products
            [
                'name' => 'Tropical Fish Flakes',
                'description' => 'Complete diet flakes for tropical aquarium fish',
                'category' => 'Fish Food',
                'category_id' => $fishFoodCategory->id,
                'brand' => 'Aqua Life',
                'price' => 199.00,
                'cost_price' => 150.00,
                'stock_quantity' => 200,
                'reorder_level' => 25,
                'max_stock_level' => 250,
                'minimum_stock_level' => 15,
                'stock_method' => 'FIFO',
                'average_cost' => 150.00,
                'track_batches' => true,
                'track_expiry' => true,
                'low_stock_alert' => true,
                'expiry_alert' => true,
                'expiry_alert_days' => 30,
                'reorder_alert' => true,
                'expiry_date' => now()->addMonths(18),
                'unit' => 'g',
                'sku' => 'FISH-TROPICAL-001',
                'barcode' => '8901234567896',
                'supplier_id' => $supplier->id,
                'location' => 'Warehouse D',
                'storage_conditions' => 'Store in cool, dry place',
                'weight' => 0.05,
                'weight_unit' => 'kg',
                'status' => 'active'
            ],

            // Small Animal Food
            [
                'name' => 'Hamster Mix',
                'description' => 'Nutritious mix for hamsters and gerbils',
                'category' => 'Small Animal Food',
                'category_id' => $smallAnimalCategory->id,
                'brand' => 'Small Pet Care',
                'price' => 149.00,
                'cost_price' => 110.00,
                'stock_quantity' => 90,
                'reorder_level' => 15,
                'max_stock_level' => 120,
                'minimum_stock_level' => 10,
                'stock_method' => 'FIFO',
                'average_cost' => 110.00,
                'track_batches' => true,
                'track_expiry' => true,
                'low_stock_alert' => true,
                'expiry_alert' => true,
                'expiry_alert_days' => 30,
                'reorder_alert' => true,
                'expiry_date' => now()->addMonths(8),
                'unit' => 'kg',
                'sku' => 'SMALL-HAMSTER-001',
                'barcode' => '8901234567897',
                'supplier_id' => $supplier->id,
                'location' => 'Warehouse E',
                'storage_conditions' => 'Store in cool, dry place',
                'weight' => 0.5,
                'weight_unit' => 'kg',
                'status' => 'active'
            ],

            // Treats
            [
                'name' => 'Dog Training Treats',
                'description' => 'Small, soft treats perfect for training',
                'category' => 'Treats',
                'category_id' => $treatsCategory->id,
                'brand' => 'PetCare Plus',
                'price' => 199.00,
                'cost_price' => 140.00,
                'stock_quantity' => 180,
                'reorder_level' => 20,
                'max_stock_level' => 220,
                'minimum_stock_level' => 15,
                'stock_method' => 'FIFO',
                'average_cost' => 140.00,
                'track_batches' => true,
                'track_expiry' => true,
                'low_stock_alert' => true,
                'expiry_alert' => true,
                'expiry_alert_days' => 30,
                'reorder_alert' => true,
                'expiry_date' => now()->addMonths(6),
                'unit' => 'pack',
                'sku' => 'TREAT-DOG-001',
                'barcode' => '8901234567898',
                'supplier_id' => $supplier->id,
                'location' => 'Warehouse A',
                'storage_conditions' => 'Store in cool, dry place',
                'weight' => 0.1,
                'weight_unit' => 'kg',
                'status' => 'active'
            ],

            // Supplements
            [
                'name' => 'Dog Joint Supplement',
                'description' => 'Glucosamine and chondroitin for joint health',
                'category' => 'Supplements',
                'category_id' => $supplementsCategory->id,
                'brand' => 'PetCare Plus',
                'price' => 399.00,
                'cost_price' => 280.00,
                'stock_quantity' => 50,
                'reorder_level' => 8,
                'max_stock_level' => 70,
                'minimum_stock_level' => 5,
                'stock_method' => 'FIFO',
                'average_cost' => 280.00,
                'track_batches' => true,
                'track_expiry' => true,
                'low_stock_alert' => true,
                'expiry_alert' => true,
                'expiry_alert_days' => 30,
                'reorder_alert' => true,
                'expiry_date' => now()->addMonths(24),
                'unit' => 'bottle',
                'sku' => 'SUPP-DOG-JOINT-001',
                'barcode' => '8901234567899',
                'supplier_id' => $supplier->id,
                'location' => 'Warehouse A',
                'storage_conditions' => 'Store in cool, dry place',
                'weight' => 0.3,
                'weight_unit' => 'kg',
                'status' => 'active'
            ],

            // Pet Care Products
            [
                'name' => 'Dog Shampoo',
                'description' => 'Gentle shampoo for dogs with sensitive skin',
                'category' => 'Pet Care',
                'category_id' => $petCareCategory->id,
                'brand' => 'PetCare Plus',
                'price' => 299.00,
                'cost_price' => 200.00,
                'stock_quantity' => 85,
                'reorder_level' => 12,
                'max_stock_level' => 100,
                'minimum_stock_level' => 8,
                'stock_method' => 'FIFO',
                'average_cost' => 200.00,
                'track_batches' => true,
                'track_expiry' => true,
                'low_stock_alert' => true,
                'expiry_alert' => true,
                'expiry_alert_days' => 30,
                'reorder_alert' => true,
                'expiry_date' => now()->addMonths(36),
                'unit' => 'bottle',
                'sku' => 'CARE-DOG-SHAMPOO-001',
                'barcode' => '8901234567900',
                'supplier_id' => $supplier->id,
                'location' => 'Warehouse A',
                'storage_conditions' => 'Store in cool, dry place',
                'weight' => 0.5,
                'weight_unit' => 'kg',
                'status' => 'active'
            ]
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }
    }
}
