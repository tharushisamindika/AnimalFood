<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AuditLog;
use App\Models\User;
use Carbon\Carbon;

class AuditLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create a test user
        $user = User::first();
        if (!$user) {
            $user = User::create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => bcrypt('password'),
                'role' => 'administrator'
            ]);
        }

        // Create various types of audit logs for testing
        $actions = ['created', 'updated', 'deleted', 'login', 'logout', 'login_failed', 'session_timeout', 'bill_header_updated', 'profile_updated', 'password_changed'];
        $modelTypes = ['App\\Models\\User', 'App\\Models\\Product', 'App\\Models\\Customer', 'App\\Models\\Order', 'App\\Models\\BillHeader'];
        $descriptions = [
            'User logged in successfully',
            'Product information updated',
            'New customer registered',
            'Order created by user',
            'Bill header configuration changed',
            'User profile updated',
            'Password changed for security',
            'Failed login attempt detected',
            'User session timed out',
            'Product deleted from inventory'
        ];

        // Create 50 test audit logs
        for ($i = 0; $i < 50; $i++) {
            $action = $actions[array_rand($actions)];
            $modelType = $modelTypes[array_rand($modelTypes)];
            $description = $descriptions[array_rand($descriptions)];
            
            // Create random dates within the last 30 days
            $createdAt = Carbon::now()->subDays(rand(0, 30))->subHours(rand(0, 23))->subMinutes(rand(0, 59));
            
            $oldValues = null;
            $newValues = null;
            $changedFields = null;
            
            // Add some change data for 'updated' actions
            if ($action === 'updated') {
                $oldValues = ['name' => 'Old Name', 'email' => 'old@example.com'];
                $newValues = ['name' => 'New Name', 'email' => 'new@example.com'];
                $changedFields = ['name', 'email'];
            }

            AuditLog::create([
                'action' => $action,
                'model_type' => $modelType,
                'model_id' => rand(1, 100),
                'old_values' => $oldValues,
                'new_values' => $newValues,
                'changed_fields' => $changedFields,
                'user_id' => $user->id,
                'user_name' => $user->name,
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                'url' => 'http://127.0.0.1:8000/admin/test',
                'description' => $description,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);
        }

        $this->command->info('Created 50 test audit log entries');
    }
}