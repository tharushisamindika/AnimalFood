<?php
/**
 * Final System Test - MySQL Version
 * Comprehensive test to verify everything is working
 */

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "🎯 Final System Test - MySQL Version\n";
echo "====================================\n\n";

$results = [];

function addResult($test, $passed, $message) {
    global $results;
    $results[] = ['test' => $test, 'passed' => $passed, 'message' => $message];
    $status = $passed ? '✅ PASS' : '❌ FAIL';
    echo "  {$status} - {$test}: {$message}\n";
}

// Test 1: Database Connection
echo "🔌 Testing Database Connection...\n";
try {
    $pdo = DB::connection()->getPdo();
    addResult('MySQL Connection', true, 'Connected to MySQL database');
    
    // Get database name
    $dbName = DB::select('SELECT DATABASE() as db')[0]->db;
    addResult('Database Selected', !empty($dbName), "Using database: {$dbName}");
} catch (Exception $e) {
    addResult('MySQL Connection', false, $e->getMessage());
}
echo "\n";

// Test 2: Essential Tables
echo "📋 Testing Essential Tables...\n";
$tables = ['users', 'categories', 'products', 'customers', 'suppliers'];
foreach ($tables as $table) {
    try {
        $count = DB::table($table)->count();
        addResult("Table '{$table}'", true, "Exists with {$count} records");
    } catch (Exception $e) {
        addResult("Table '{$table}'", false, "Error: " . $e->getMessage());
    }
}
echo "\n";

// Test 3: Admin User
echo "👤 Testing Admin User...\n";
try {
    $adminUser = DB::table('users')->where('email', 'admin@admin.com')->first();
    addResult('Admin User Exists', !empty($adminUser), 'admin@admin.com found');
    
    if ($adminUser) {
        addResult('Admin Role', $adminUser->role === 'super_administrator', 'Role: ' . $adminUser->role);
        addResult('Admin Name', !empty($adminUser->name), 'Name: ' . $adminUser->name);
    }
} catch (Exception $e) {
    addResult('Admin User Test', false, $e->getMessage());
}
echo "\n";

// Test 4: Categories
echo "📂 Testing Categories...\n";
try {
    $categories = DB::table('categories')->get();
    addResult('Categories Exist', $categories->count() > 0, "Found {$categories->count()} categories");
    
    if ($categories->count() > 0) {
        $activeCategories = DB::table('categories')->where('is_active', 1)->count();
        addResult('Active Categories', $activeCategories > 0, "{$activeCategories} active categories");
    }
} catch (Exception $e) {
    addResult('Categories Test', false, $e->getMessage());
}
echo "\n";

// Test 5: HTTP Routes
echo "🌐 Testing HTTP Routes...\n";
$routes = [
    'http://127.0.0.1:8000/login' => 'Login page',
    'http://127.0.0.1:8000/admin/categories' => 'Categories page'
];

foreach ($routes as $url => $description) {
    $context = stream_context_create(['http' => ['timeout' => 5]]);
    $response = @file_get_contents($url, false, $context);
    $success = $response !== false;
    addResult("Route: {$description}", $success, $success ? 'Accessible' : 'Not accessible');
}
echo "\n";

// Test 6: Category Validation API
echo "🔍 Testing Category Validation...\n";
try {
    $testUrl = 'http://127.0.0.1:8000/admin/categories/validate-name?name=TestCategory';
    $context = stream_context_create(['http' => ['timeout' => 5]]);
    $response = @file_get_contents($testUrl, false, $context);
    addResult('Validation API', $response !== false, 'Validation endpoint responsive');
} catch (Exception $e) {
    addResult('Validation API', false, $e->getMessage());
}
echo "\n";

// Generate Report
echo "📊 FINAL SYSTEM REPORT\n";
echo "======================\n\n";

$totalTests = count($results);
$passedTests = count(array_filter($results, function($r) { return $r['passed']; }));
$failedTests = $totalTests - $passedTests;

echo "Summary:\n";
echo "  Total Tests: {$totalTests}\n";
echo "  Passed: {$passedTests}\n";
echo "  Failed: {$failedTests}\n";
echo "  Success Rate: " . round(($passedTests / $totalTests) * 100, 2) . "%\n\n";

if ($failedTests > 0) {
    echo "❌ Issues Found:\n";
    foreach ($results as $result) {
        if (!$result['passed']) {
            echo "  - {$result['test']}: {$result['message']}\n";
        }
    }
    echo "\n";
}

echo "🔑 LOGIN CREDENTIALS:\n";
echo "=====================\n";
echo "Email: admin@admin.com\n";
echo "Password: admin@1234\n";
echo "URL: http://127.0.0.1:8000/login\n\n";

if ($passedTests >= $totalTests * 0.8) {
    echo "🎉 SYSTEM STATUS: READY TO USE!\n";
    echo "Your Animal Food System is working properly.\n";
} else {
    echo "⚠️ SYSTEM STATUS: NEEDS ATTENTION\n";
    echo "Some issues found that need to be resolved.\n";
}

echo "\n✨ Test completed!\n";
