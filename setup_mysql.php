<?php
/**
 * MySQL Setup Script for Animal Food System
 * This script will help configure MySQL and restore your system
 */

echo "🗄️ MySQL Configuration for Animal Food System\n";
echo "===============================================\n\n";

// Check if .env file exists
if (!file_exists('.env')) {
    echo "❌ .env file not found. Creating one...\n";
    
    // Create .env file with MySQL configuration
    $envContent = 'APP_NAME="Animal Food System"
APP_ENV=local
APP_KEY=' . 'base64:' . base64_encode(random_bytes(32)) . '
APP_DEBUG=true
APP_TIMEZONE=UTC
APP_URL=http://127.0.0.1:8000

LOG_CHANNEL=stack
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=animalfood
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=database
SESSION_LIFETIME=120

CACHE_STORE=database
QUEUE_CONNECTION=database

MAIL_MAILER=log';

    file_put_contents('.env', $envContent);
    echo "✅ .env file created with MySQL configuration\n\n";
} else {
    echo "✅ .env file exists\n\n";
}

echo "📝 Please provide your MySQL database details:\n";
echo "Default values are shown in brackets. Press Enter to use default.\n\n";

// Get database details from user
$dbHost = readline("Database Host [127.0.0.1]: ") ?: '127.0.0.1';
$dbPort = readline("Database Port [3306]: ") ?: '3306';
$dbName = readline("Database Name [animalfood]: ") ?: 'animalfood';
$dbUser = readline("Database Username [root]: ") ?: 'root';
$dbPassword = readline("Database Password []: ");

echo "\n🔧 Updating .env file with your settings...\n";

// Update .env file
$envContent = file_get_contents('.env');
$envContent = preg_replace('/DB_HOST=.*/', "DB_HOST={$dbHost}", $envContent);
$envContent = preg_replace('/DB_PORT=.*/', "DB_PORT={$dbPort}", $envContent);
$envContent = preg_replace('/DB_DATABASE=.*/', "DB_DATABASE={$dbName}", $envContent);
$envContent = preg_replace('/DB_USERNAME=.*/', "DB_USERNAME={$dbUser}", $envContent);
$envContent = preg_replace('/DB_PASSWORD=.*/', "DB_PASSWORD={$dbPassword}", $envContent);

file_put_contents('.env', $envContent);

echo "✅ Database configuration updated!\n\n";

// Test database connection
echo "🔌 Testing database connection...\n";

try {
    $pdo = new PDO("mysql:host={$dbHost};port={$dbPort}", $dbUser, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Connected to MySQL server\n";
    
    // Check if database exists
    $stmt = $pdo->query("SHOW DATABASES LIKE '{$dbName}'");
    if ($stmt->rowCount() == 0) {
        echo "📦 Database '{$dbName}' doesn't exist. Creating...\n";
        $pdo->exec("CREATE DATABASE {$dbName}");
        echo "✅ Database '{$dbName}' created\n";
    } else {
        echo "✅ Database '{$dbName}' exists\n";
    }
    
} catch (Exception $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "\n";
    echo "💡 Please check your MySQL server is running and credentials are correct\n";
    exit(1);
}

echo "\n🚀 Running migrations to set up tables...\n";
system('php artisan migrate:fresh');

echo "\n👤 Creating admin user for system access...\n";

// Create admin user
try {
    $pdo = new PDO("mysql:host={$dbHost};port={$dbPort};dbname={$dbName}", $dbUser, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Check if admin user exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
    $stmt->execute(['admin@animalfood.com']);
    $userExists = $stmt->fetchColumn() > 0;
    
    if (!$userExists) {
        $adminPassword = password_hash('admin123', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
        $stmt->execute(['System Administrator', 'admin@animalfood.com', $adminPassword, 'super_administrator']);
        echo "✅ Admin user created successfully!\n";
        echo "📋 Login Credentials:\n";
        echo "   Email: admin@animalfood.com\n";
        echo "   Password: admin123\n";
    } else {
        echo "✅ Admin user already exists\n";
    }
    
} catch (Exception $e) {
    echo "❌ Failed to create admin user: " . $e->getMessage() . "\n";
}

echo "\n🌱 Seeding database with initial data...\n";
system('php artisan db:seed');

echo "\n🎉 MySQL setup completed!\n";
echo "🔑 You can now log in with: admin@animalfood.com / admin123\n";
echo "🌐 Visit: http://127.0.0.1:8000/login\n\n";
