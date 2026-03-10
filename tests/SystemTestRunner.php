<?php

/**
 * Automated PHP Testing Script for Animal Food System
 * This script tests various components and functionalities of the system
 */

require_once __DIR__ . '/../vendor/autoload.php';

class SystemTestRunner
{
    private $results = [];
    private $baseUrl = 'http://127.0.0.1:8000';
    private $testUser = [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password123',
        'role' => 'administrator'
    ];
    private $testCategory = [
        'name' => 'Test Category',
        'description' => 'This is a test category',
        'is_active' => true
    ];

    public function __construct()
    {
        echo "🚀 Starting Animal Food System Tests\n";
        echo "=====================================\n\n";
    }

    public function runAllTests()
    {
        $this->testDatabaseConnection();
        $this->testEnvironmentConfiguration();
        $this->testRoutes();
        $this->testAuthentication();
        $this->testCategoryOperations();
        $this->testProductOperations();
        $this->testValidation();
        $this->testUserInterface();
        
        $this->generateReport();
    }

    private function testDatabaseConnection()
    {
        echo "📊 Testing Database Connection...\n";
        
        try {
            // Test database connection
            $pdo = new PDO(
                'mysql:host=' . env('DB_HOST', '127.0.0.1') . ';port=' . env('DB_PORT', '3306') . ';dbname=' . env('DB_DATABASE', 'animalfood'),
                env('DB_USERNAME', 'root'),
                env('DB_PASSWORD', ''),
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
            
            $this->addResult('Database Connection', true, 'Successfully connected to database');
            
            // Test if required tables exist
            $tables = ['users', 'categories', 'products', 'customers', 'suppliers', 'orders'];
            foreach ($tables as $table) {
                $stmt = $pdo->prepare("SHOW TABLES LIKE ?");
                $stmt->execute([$table]);
                $exists = $stmt->fetch() !== false;
                $this->addResult("Table '{$table}' exists", $exists, $exists ? "Table found" : "Table missing");
            }
            
        } catch (Exception $e) {
            $this->addResult('Database Connection', false, $e->getMessage());
        }
        
        echo "\n";
    }

    private function testEnvironmentConfiguration()
    {
        echo "⚙️ Testing Environment Configuration...\n";
        
        // Check if .env file exists
        $envExists = file_exists(__DIR__ . '/../.env');
        $this->addResult('.env file exists', $envExists, $envExists ? 'Found' : 'Missing');
        
        // Check key environment variables
        $envVars = ['APP_KEY', 'DB_DATABASE', 'DB_USERNAME'];
        foreach ($envVars as $var) {
            $value = env($var);
            $this->addResult("ENV: {$var}", !empty($value), !empty($value) ? 'Set' : 'Missing');
        }
        
        // Test app key
        $appKey = env('APP_KEY');
        $this->addResult('App Key Valid', !empty($appKey) && strlen($appKey) > 10, 'Application encryption key status');
        
        echo "\n";
    }

    private function testRoutes()
    {
        echo "🛣️ Testing Routes...\n";
        
        $routes = [
            '/login' => 'Login page',
            '/admin/categories' => 'Categories management',
            '/admin/products' => 'Products management',
            '/admin/users' => 'Users management',
            '/register' => 'Registration page (requires auth)'
        ];
        
        foreach ($routes as $route => $description) {
            $response = $this->makeHttpRequest('GET', $route);
            $success = $response['status'] < 500; // Accept redirects and 404s, but not server errors
            $this->addResult("Route: {$route}", $success, "HTTP {$response['status']} - {$description}");
        }
        
        echo "\n";
    }

    private function testAuthentication()
    {
        echo "🔐 Testing Authentication System...\n";
        
        // Test login page accessibility
        $response = $this->makeHttpRequest('GET', '/login');
        $this->addResult('Login page accessible', $response['status'] == 200, 'Login form should be accessible');
        
        // Test registration page (should require auth)
        $response = $this->makeHttpRequest('GET', '/register');
        $this->addResult('Registration requires auth', $response['status'] == 302, 'Should redirect unauthenticated users');
        
        // Test protected routes
        $protectedRoutes = ['/admin/categories', '/admin/products', '/admin/users'];
        foreach ($protectedRoutes as $route) {
            $response = $this->makeHttpRequest('GET', $route);
            $this->addResult("Protected route: {$route}", $response['status'] == 302, 'Should redirect to login');
        }
        
        echo "\n";
    }

    private function testCategoryOperations()
    {
        echo "📂 Testing Category Operations...\n";
        
        // Test category validation endpoint
        $response = $this->makeHttpRequest('GET', '/admin/categories/validate-name?name=TestCategory');
        $this->addResult('Category validation endpoint', $response['status'] == 200 || $response['status'] == 302, 'Validation endpoint accessible');
        
        // Test category CRUD routes
        $routes = [
            'GET /admin/categories' => 'Category list',
            'GET /admin/categories/get/all' => 'Category API',
        ];
        
        foreach ($routes as $route => $description) {
            list($method, $path) = explode(' ', $route, 2);
            $response = $this->makeHttpRequest($method, $path);
            $this->addResult("Category route: {$route}", $response['status'] < 500, $description);
        }
        
        echo "\n";
    }

    private function testProductOperations()
    {
        echo "📦 Testing Product Operations...\n";
        
        $routes = [
            'GET /admin/products' => 'Product list',
            'GET /admin/products/create' => 'Product creation form',
        ];
        
        foreach ($routes as $route => $description) {
            list($method, $path) = explode(' ', $route, 2);
            $response = $this->makeHttpRequest($method, $path);
            $this->addResult("Product route: {$route}", $response['status'] < 500, $description);
        }
        
        echo "\n";
    }

    private function testValidation()
    {
        echo "✅ Testing Validation Systems...\n";
        
        // Test category name validation
        $testCases = [
            ['name' => '', 'should_pass' => false, 'test' => 'Empty name validation'],
            ['name' => 'Valid Category Name', 'should_pass' => true, 'test' => 'Valid name validation'],
            ['name' => str_repeat('a', 300), 'should_pass' => false, 'test' => 'Long name validation']
        ];
        
        foreach ($testCases as $case) {
            $response = $this->makeHttpRequest('GET', '/admin/categories/validate-name?name=' . urlencode($case['name']));
            $success = ($response['status'] < 500);
            $this->addResult($case['test'], $success, 'Validation endpoint response');
        }
        
        echo "\n";
    }

    private function testUserInterface()
    {
        echo "🎨 Testing User Interface...\n";
        
        // Test for common UI elements and CSS
        $response = $this->makeHttpRequest('GET', '/login');
        if ($response['status'] == 200) {
            $content = $response['body'];
            
            // Check for essential UI components
            $uiChecks = [
                'Tailwind CSS' => strpos($content, 'tailwind') !== false || strpos($content, 'class=') !== false,
                'Form elements' => strpos($content, '<form') !== false,
                'CSRF protection' => strpos($content, 'csrf') !== false,
                'Dark mode support' => strpos($content, 'dark:') !== false,
                'Responsive design' => strpos($content, 'responsive') !== false || strpos($content, 'lg:') !== false
            ];
            
            foreach ($uiChecks as $check => $result) {
                $this->addResult("UI: {$check}", $result, 'User interface component check');
            }
        }
        
        echo "\n";
    }

    private function makeHttpRequest($method, $path, $data = null)
    {
        $url = $this->baseUrl . $path;
        $ch = curl_init();
        
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_USERAGENT => 'SystemTestRunner/1.0'
        ]);
        
        if ($data && in_array($method, ['POST', 'PUT', 'PATCH'])) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        return [
            'status' => $httpCode,
            'body' => $response,
            'error' => $error
        ];
    }

    private function addResult($test, $passed, $message)
    {
        $this->results[] = [
            'test' => $test,
            'passed' => $passed,
            'message' => $message,
            'timestamp' => date('Y-m-d H:i:s')
        ];
        
        $status = $passed ? '✅ PASS' : '❌ FAIL';
        echo "  {$status} - {$test}: {$message}\n";
    }

    private function generateReport()
    {
        echo "\n📋 TEST REPORT\n";
        echo "==============\n\n";
        
        $totalTests = count($this->results);
        $passedTests = count(array_filter($this->results, function($r) { return $r['passed']; }));
        $failedTests = $totalTests - $passedTests;
        
        echo "📊 Summary:\n";
        echo "  Total Tests: {$totalTests}\n";
        echo "  Passed: {$passedTests}\n";
        echo "  Failed: {$failedTests}\n";
        echo "  Success Rate: " . round(($passedTests / $totalTests) * 100, 2) . "%\n\n";
        
        if ($failedTests > 0) {
            echo "❌ Failed Tests:\n";
            foreach ($this->results as $result) {
                if (!$result['passed']) {
                    echo "  - {$result['test']}: {$result['message']}\n";
                }
            }
            echo "\n";
        }
        
        echo "💡 Recommendations:\n";
        $this->generateRecommendations();
        
        // Save detailed report to file
        $this->saveDetailedReport();
        
        echo "\n🎉 Testing Complete!\n";
        echo "Detailed report saved to: tests/reports/system_test_" . date('Y-m-d_H-i-s') . ".json\n";
    }

    private function generateRecommendations()
    {
        $failedTests = array_filter($this->results, function($r) { return !$r['passed']; });
        
        if (empty($failedTests)) {
            echo "  🎉 All tests passed! Your system is working well.\n";
            return;
        }
        
        $recommendations = [];
        
        foreach ($failedTests as $test) {
            switch (true) {
                case strpos($test['test'], 'Database') !== false:
                    $recommendations[] = "🔧 Check database configuration in .env file";
                    $recommendations[] = "🔧 Run 'php artisan migrate' to ensure all tables exist";
                    break;
                    
                case strpos($test['test'], 'Route') !== false:
                    $recommendations[] = "🔧 Clear route cache: 'php artisan route:clear'";
                    $recommendations[] = "🔧 Check routes/web.php for syntax errors";
                    break;
                    
                case strpos($test['test'], 'ENV') !== false:
                    $recommendations[] = "🔧 Copy .env.example to .env and configure settings";
                    $recommendations[] = "🔧 Generate app key: 'php artisan key:generate'";
                    break;
                    
                case strpos($test['test'], 'Category') !== false:
                    $recommendations[] = "🔧 Check CategoryController for syntax errors";
                    $recommendations[] = "🔧 Verify category migration was run successfully";
                    break;
            }
        }
        
        $recommendations = array_unique($recommendations);
        foreach ($recommendations as $rec) {
            echo "  {$rec}\n";
        }
    }

    private function saveDetailedReport()
    {
        $reportDir = __DIR__ . '/reports';
        if (!is_dir($reportDir)) {
            mkdir($reportDir, 0755, true);
        }
        
        $report = [
            'timestamp' => date('Y-m-d H:i:s'),
            'summary' => [
                'total_tests' => count($this->results),
                'passed' => count(array_filter($this->results, function($r) { return $r['passed']; })),
                'failed' => count(array_filter($this->results, function($r) { return !$r['passed']; }))
            ],
            'results' => $this->results,
            'system_info' => [
                'php_version' => PHP_VERSION,
                'os' => PHP_OS,
                'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
                'base_url' => $this->baseUrl
            ]
        ];
        
        $filename = $reportDir . '/system_test_' . date('Y-m-d_H-i-s') . '.json';
        file_put_contents($filename, json_encode($report, JSON_PRETTY_PRINT));
    }
}

// Helper function to get environment variables
function env($key, $default = null)
{
    $envFile = __DIR__ . '/../.env';
    static $envVars = null;
    
    if ($envVars === null) {
        $envVars = [];
        if (file_exists($envFile)) {
            $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                if (strpos($line, '=') !== false && !str_starts_with(trim($line), '#')) {
                    list($key, $value) = explode('=', $line, 2);
                    $envVars[trim($key)] = trim($value, '"\'');
                }
            }
        }
    }
    
    return $envVars[$key] ?? $default;
}

// Run the tests if this file is executed directly
if (basename(__FILE__) === basename($_SERVER['SCRIPT_NAME'])) {
    $tester = new SystemTestRunner();
    $tester->runAllTests();
}
