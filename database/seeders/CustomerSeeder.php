<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            // Default Customer for billing when no regular customer is selected
            [
                'name' => 'Customer',
                'email' => 'customer@default.com',
                'phone' => '0000000000',
                'address' => 'Default Address',
                'city' => 'Default City',
                'state' => 'Default State',
                'postal_code' => '00000',
                'status' => 'active'
            ],
            [
                'name' => 'John Smith',
                'email' => 'john.smith@email.com',
                'phone' => '+1234567890',
                'address' => '123 Main Street',
                'city' => 'New York',
                'state' => 'NY',
                'postal_code' => '10001',
                'status' => 'active'
            ],
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah.johnson@email.com',
                'phone' => '+1234567891',
                'address' => '456 Oak Avenue',
                'city' => 'Los Angeles',
                'state' => 'CA',
                'postal_code' => '90210',
                'status' => 'active'
            ],
            [
                'name' => 'Mike Wilson',
                'email' => 'mike.wilson@email.com',
                'phone' => '+1234567892',
                'address' => '789 Pine Road',
                'city' => 'Chicago',
                'state' => 'IL',
                'postal_code' => '60601',
                'status' => 'active'
            ],
            [
                'name' => 'Emily Davis',
                'email' => 'emily.davis@email.com',
                'phone' => '+1234567893',
                'address' => '321 Elm Street',
                'city' => 'Houston',
                'state' => 'TX',
                'postal_code' => '77001',
                'status' => 'active'
            ],
            [
                'name' => 'David Brown',
                'email' => 'david.brown@email.com',
                'phone' => '+1234567894',
                'address' => '654 Maple Drive',
                'city' => 'Phoenix',
                'state' => 'AZ',
                'postal_code' => '85001',
                'status' => 'active'
            ]
        ];

        foreach ($customers as $customerData) {
            Customer::firstOrCreate(
                ['email' => $customerData['email']],
                $customerData
            );
        }
    }
}
