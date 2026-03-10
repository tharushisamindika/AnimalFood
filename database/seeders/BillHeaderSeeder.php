<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BillHeader;

class BillHeaderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a default bill header
        BillHeader::create([
            'company_name' => 'Animal Food System',
            'company_address' => '123 Main Street, City, State 12345',
            'company_phone' => '+1 (555) 123-4567',
            'company_email' => 'info@animalfoodsystem.com',
            'company_website' => 'https://animalfoodsystem.com',
            'tax_number' => 'TAX123456789',
            'invoice_prefix' => 'INV',
            'footer_text' => 'Thank you for your business!',
            'is_active' => true,
        ]);
    }
}
