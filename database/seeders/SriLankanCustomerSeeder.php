<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use Carbon\Carbon;

class SriLankanCustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sri Lankan cities and provinces
        $cities = [
            'Colombo' => 'Western Province',
            'Gampaha' => 'Western Province', 
            'Kalutara' => 'Western Province',
            'Kandy' => 'Central Province',
            'Matale' => 'Central Province',
            'Nuwara Eliya' => 'Central Province',
            'Galle' => 'Southern Province',
            'Matara' => 'Southern Province',
            'Hambantota' => 'Southern Province',
            'Jaffna' => 'Northern Province',
            'Kilinochchi' => 'Northern Province',
            'Mullaitivu' => 'Northern Province',
            'Vavuniya' => 'Northern Province',
            'Batticaloa' => 'Eastern Province',
            'Ampara' => 'Eastern Province',
            'Trincomalee' => 'Eastern Province',
            'Kurunegala' => 'North Western Province',
            'Puttalam' => 'North Western Province',
            'Anuradhapura' => 'North Central Province',
            'Polonnaruwa' => 'North Central Province',
            'Badulla' => 'Uva Province',
            'Monaragala' => 'Uva Province',
            'Ratnapura' => 'Sabaragamuwa Province',
            'Kegalle' => 'Sabaragamuwa Province'
        ];

        // Sri Lankan names (first names and last names)
        $firstNames = [
            'Aravinda', 'Dilshan', 'Kumar', 'Nimal', 'Sunil', 'Ranjith', 'Priyantha', 'Chandana', 'Saman', 'Lakmal',
            'Tharanga', 'Dinesh', 'Nuwan', 'Chamara', 'Upul', 'Mahela', 'Sanath', 'Muttiah', 'Kumar', 'Ajantha',
            'Kumari', 'Nadeeka', 'Sandamali', 'Chandrika', 'Samanthi', 'Dilrukshi', 'Tharangi', 'Nayana', 'Priyanka', 'Kanchana',
            'Anjali', 'Dilini', 'Kumudu', 'Nirosha', 'Sanduni', 'Chathurika', 'Sachini', 'Dilhani', 'Tharushi', 'Nadeesha'
        ];

        $lastNames = [
            'Perera', 'Fernando', 'Silva', 'Rodrigo', 'Wijesinghe', 'Bandara', 'Jayawardena', 'Gunasekara', 'Weerasinghe', 'Rajapaksa',
            'Wickramasinghe', 'Dissanayake', 'Ratnayake', 'Abeysekara', 'Gunawardena', 'Jayasekara', 'Mendis', 'Peiris', 'Karunaratne', 'Wijeratne',
            'Senanayake', 'Premadasa', 'Kumaratunga', 'Rajapakse', 'Wickremesinghe', 'Sirisena', 'Gotabaya', 'Mahinda', 'Chandrika', 'Ranil'
        ];

        // Company names for business customers
        $companyNames = [
            'Lanka Pet Foods Ltd', 'Colombo Animal Care', 'Pet Paradise Sri Lanka', 'Royal Canin Lanka', 'Whiskas Pet Store',
            'Pawsome Pet Supplies', 'Pet World Colombo', 'Animal Kingdom Lanka', 'Pet Care Plus', 'Furry Friends Store',
            'Lanka Pet Nutrition', 'Colombo Pet Center', 'Pet Express Lanka', 'Animal Care Plus', 'Pet Supplies Lanka',
            'Royal Pet Store', 'Whiskas Lanka', 'Pet Paradise Plus', 'Animal Kingdom Plus', 'Pet Care Express'
        ];

        // Institute names
        $instituteNames = [
            'University of Colombo Veterinary Faculty', 'Sri Lanka Veterinary Association', 'Animal Welfare Society',
            'Colombo Zoo', 'Dehiwala Zoo', 'Pinnawala Elephant Orphanage', 'Udawalawe Elephant Transit Home',
            'Yala National Park', 'Wilpattu National Park', 'Sinharaja Forest Reserve', 'Minneriya National Park',
            'Kumana National Park', 'Bundala National Park', 'Gal Oya National Park', 'Horton Plains National Park'
        ];

        // Shop names
        $shopNames = [
            'Pet Mart Colombo', 'Animal Care Shop', 'Pet Supplies Plus', 'Furry Friends Store', 'Pet World Lanka',
            'Royal Pet Shop', 'Whiskas Pet Store', 'Pet Paradise Shop', 'Animal Kingdom Store', 'Pet Care Shop',
            'Lanka Pet Store', 'Colombo Pet Shop', 'Pet Express Store', 'Animal Care Plus', 'Pet Supplies Shop'
        ];

        // Generate phone numbers (Sri Lankan format: +94 11 2345678 or +94 71 2345678)
        function generatePhoneNumber() {
            $areaCodes = ['11', '21', '31', '41', '51', '61', '71', '81', '91'];
            $areaCode = $areaCodes[array_rand($areaCodes)];
            $number = rand(1000000, 9999999);
            return "+94 {$areaCode} {$number}";
        }

        // Generate postal codes (Sri Lankan format: 10000-99999)
        function generatePostalCode() {
            return rand(10000, 99999);
        }

        // Generate customer ID
        function generateCustomerId() {
            return 'CUST' . date('Y') . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        }

        // Create customers
        for ($i = 1; $i <= 50; $i++) {
            $firstName = $firstNames[array_rand($firstNames)];
            $lastName = $lastNames[array_rand($lastNames)];
            $fullName = $firstName . ' ' . $lastName;
            
            $city = array_rand($cities);
            $state = $cities[$city];
            
            $customerType = ['individual', 'shop', 'institute', 'company'][array_rand(['individual', 'shop', 'institute', 'company'])];
            
            $customerData = [
                'name' => $fullName,
                'email' => strtolower(str_replace(' ', '.', $fullName)) . '@' . ['gmail.com', 'yahoo.com', 'hotmail.com', 'outlook.com'][array_rand(['gmail.com', 'yahoo.com', 'hotmail.com', 'outlook.com'])] . rand(1, 999),
                'phone' => generatePhoneNumber(),
                'address' => rand(1, 999) . ', ' . ['Main Street', 'Lake Road', 'Temple Road', 'School Road', 'Hospital Road', 'Market Street', 'Beach Road', 'Hill Road', 'Garden Street', 'Park Road'][array_rand(['Main Street', 'Lake Road', 'Temple Road', 'School Road', 'Hospital Road', 'Market Street', 'Beach Road', 'Hill Road', 'Garden Street', 'Park Road'])],
                'city' => $city,
                'state' => $state,
                'postal_code' => generatePostalCode(),
                'customer_type' => $customerType,
                'status' => ['active', 'active', 'active', 'inactive'][array_rand(['active', 'active', 'active', 'inactive'])],
                'customer_id' => generateCustomerId(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
            
            // Add company-specific fields
            if ($customerType === 'company') {
                $customerData['company_name'] = $companyNames[array_rand($companyNames)];
                $customerData['contact_person'] = $fullName;
            } elseif ($customerType === 'shop') {
                $customerData['company_name'] = $shopNames[array_rand($shopNames)];
                $customerData['contact_person'] = $fullName;
            } elseif ($customerType === 'institute') {
                $customerData['company_name'] = $instituteNames[array_rand($instituteNames)];
                $customerData['contact_person'] = $fullName;
            }
            
            // Add some additional fields randomly
            if (rand(1, 3) === 1) {
                $customerData['tax_number'] = 'TAX' . rand(100000, 999999);
            }
            
            if (rand(1, 4) === 1) {
                $customerData['notes'] = ['Regular customer', 'Premium customer', 'Bulk order customer', 'Wholesale customer', 'VIP customer'][array_rand(['Regular customer', 'Premium customer', 'Bulk order customer', 'Wholesale customer', 'VIP customer'])];
            }
            
            // Check if customer with this email already exists
            $existingCustomer = Customer::where('email', $customerData['email'])->first();
            if (!$existingCustomer) {
                Customer::create($customerData);
            }
        }
    }
}
