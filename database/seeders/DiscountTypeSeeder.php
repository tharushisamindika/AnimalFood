<?php

namespace Database\Seeders;

use App\Models\DiscountType;
use Illuminate\Database\Seeder;

class DiscountTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $discounts = [
            [
                'name' => 'Senior Citizen Discount',
                'code' => 'SENIOR',
                'description' => '10% discount for senior citizens (60+ years)',
                'type' => 'percentage',
                'value' => 10.00,
                'minimum_amount' => 0.00,
                'maximum_discount' => 50.00,
                'is_active' => true,
                'is_automatic' => false,
                'terms_conditions' => 'Valid for customers aged 60 and above. Valid ID required.',
            ],
            [
                'name' => 'Bulk Purchase Discount',
                'code' => 'BULK10',
                'description' => '15% discount for orders above Rs. 500',
                'type' => 'percentage',
                'value' => 15.00,
                'minimum_amount' => 500.00,
                'maximum_discount' => 100.00,
                'is_active' => true,
                'is_automatic' => true,
                'terms_conditions' => 'Automatically applied to orders above Rs. 500.',
            ],
            [
                'name' => 'New Customer Welcome',
                'code' => 'WELCOME20',
                'description' => 'Rs. 20 off for new customers',
                'type' => 'fixed_amount',
                'value' => 20.00,
                'minimum_amount' => 100.00,
                'maximum_discount' => 20.00,
                'is_active' => true,
                'is_automatic' => false,
                'terms_conditions' => 'Valid for first-time customers only. Minimum order Rs. 100.',
            ],
            [
                'name' => 'Loyalty Customer',
                'code' => 'LOYAL5',
                'description' => '5% discount for loyal customers',
                'type' => 'percentage',
                'value' => 5.00,
                'minimum_amount' => 0.00,
                'maximum_discount' => null,
                'is_active' => true,
                'is_automatic' => false,
                'terms_conditions' => 'For customers with 10+ orders in the last year.',
            ],
            [
                'name' => 'Holiday Special',
                'code' => 'HOLIDAY25',
                'description' => 'Rs. 25 off holiday special discount',
                'type' => 'fixed_amount',
                'value' => 25.00,
                'minimum_amount' => 200.00,
                'maximum_discount' => 25.00,
                'valid_from' => now()->subDays(30),
                'valid_until' => now()->addDays(30),
                'is_active' => true,
                'is_automatic' => false,
                'terms_conditions' => 'Valid during holiday season. Limited time offer.',
            ],
            [
                'name' => 'Premium Membership',
                'code' => 'PREMIUM',
                'description' => '12% discount for premium members',
                'type' => 'percentage',
                'value' => 12.00,
                'minimum_amount' => 0.00,
                'maximum_discount' => null,
                'is_active' => true,
                'is_automatic' => true,
                'terms_conditions' => 'Automatic discount for premium membership holders.',
            ],
        ];

        foreach ($discounts as $discount) {
            DiscountType::create($discount);
        }
    }
}