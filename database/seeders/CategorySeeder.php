<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Dog Food',
                'description' => 'High-quality food products for dogs of all ages and sizes',
                'is_active' => true
            ],
            [
                'name' => 'Cat Food',
                'description' => 'Nutritious food products for cats including wet and dry food',
                'is_active' => true
            ],
            [
                'name' => 'Bird Food',
                'description' => 'Specialized food for various bird species including seeds and pellets',
                'is_active' => true
            ],
            [
                'name' => 'Fish Food',
                'description' => 'Food products for aquarium fish and pond fish',
                'is_active' => true
            ],
            [
                'name' => 'Small Animal Food',
                'description' => 'Food for hamsters, guinea pigs, rabbits, and other small pets',
                'is_active' => true
            ],
            [
                'name' => 'Treats',
                'description' => 'Delicious treats and snacks for pets',
                'is_active' => true
            ],
            [
                'name' => 'Supplements',
                'description' => 'Vitamins, minerals, and health supplements for pets',
                'is_active' => true
            ],
            [
                'name' => 'Pet Care',
                'description' => 'Grooming, hygiene, and care products for pets',
                'is_active' => true
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
