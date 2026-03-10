<?php
/**
 * Simple test runner for Animal Food System
 * Usage: php run_tests.php
 */

echo "🐾 Animal Food System - Automated Testing\n";
echo "=========================================\n\n";

// Check if server is running
$serverCheck = @file_get_contents('http://127.0.0.1:8000', false, stream_context_create(['http' => ['timeout' => 5]]));
if ($serverCheck === false) {
    echo "❌ Laravel server is not running on http://127.0.0.1:8000\n";
    echo "💡 Please start the server first: php artisan serve\n\n";
    
    // Try to start server automatically
    echo "🚀 Attempting to start Laravel server...\n";
    $command = 'php artisan serve --host=127.0.0.1 --port=8000 > /dev/null 2>&1 &';
    
    if (PHP_OS_FAMILY === 'Windows') {
        $command = 'start /B php artisan serve --host=127.0.0.1 --port=8000';
    }
    
    exec($command);
    sleep(3); // Wait for server to start
    
    // Check again
    $serverCheck = @file_get_contents('http://127.0.0.1:8000', false, stream_context_create(['http' => ['timeout' => 5]]));
    if ($serverCheck === false) {
        echo "❌ Failed to start server automatically.\n";
        echo "🔧 Please run manually: php artisan serve\n";
        exit(1);
    } else {
        echo "✅ Server started successfully!\n\n";
    }
} else {
    echo "✅ Laravel server is running\n\n";
}

// Include and run the test suite
require_once __DIR__ . '/tests/SystemTestRunner.php';

$tester = new SystemTestRunner();
$tester->runAllTests();
