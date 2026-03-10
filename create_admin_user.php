<?php
/**
 * Emergency Admin User Creator
 * Creates admin user: admin@admin.com / admin@1234
 */

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

echo "🚨 Emergency Admin User Creation\n";
echo "================================\n\n";

try {
    // Test database connection
    DB::connection()->getPdo();
    echo "✅ Database connection successful\n";
    
    // Check if user already exists
    $existingUser = DB::table('users')->where('email', 'admin@admin.com')->first();
    
    if ($existingUser) {
        echo "👤 User admin@admin.com already exists. Updating password...\n";
        
        DB::table('users')
            ->where('email', 'admin@admin.com')
            ->update([
                'password' => Hash::make('admin@1234'),
                'role' => 'super_administrator',
                'updated_at' => Carbon::now()
            ]);
            
        echo "✅ Password updated for admin@admin.com\n";
    } else {
        echo "👤 Creating new admin user...\n";
        
        DB::table('users')->insert([
            'name' => 'System Administrator',
            'email' => 'admin@admin.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('admin@1234'),
            'role' => 'super_administrator',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        
        echo "✅ Admin user created successfully!\n";
    }
    
    echo "\n🔑 Login Credentials:\n";
    echo "📧 Email: admin@admin.com\n";
    echo "🔒 Password: admin@1234\n";
    echo "👑 Role: Super Administrator\n\n";
    
    echo "🌐 You can now login at: http://127.0.0.1:8000/login\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    
    if (strpos($e->getMessage(), 'database') !== false || strpos($e->getMessage(), 'connection') !== false) {
        echo "\n💡 Database connection issue. Let's try to fix this:\n";
        echo "1. Make sure MySQL server is running\n";
        echo "2. Check your database credentials in .env file\n";
        echo "3. Run: php artisan migrate:fresh\n\n";
    }
}

echo "\n🎉 Process completed!\n";
