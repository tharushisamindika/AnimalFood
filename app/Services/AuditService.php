<?php

namespace App\Services;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuditService
{
    /**
     * Log user login activity
     */
    public static function logUserLogin(User $user, Request $request, bool $success = true): void
    {
        $description = $success 
            ? "User '{$user->name}' ({$user->email}) logged in successfully"
            : "Failed login attempt for user '{$user->name}' ({$user->email})";

        AuditLog::create([
            'action' => $success ? 'login' : 'login_failed',
            'model_type' => User::class,
            'model_id' => $user->id,
            'old_values' => null,
            'new_values' => [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
                'login_time' => now()->toDateTimeString(),
                'success' => $success
            ],
            'changed_fields' => null,
            'user_id' => $user->id,
            'user_name' => $user->name,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'url' => $request->fullUrl(),
            'description' => $description,
        ]);
    }

    /**
     * Log user logout activity
     */
    public static function logUserLogout(User $user, Request $request): void
    {
        AuditLog::create([
            'action' => 'logout',
            'model_type' => User::class,
            'model_id' => $user->id,
            'old_values' => null,
            'new_values' => [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
                'logout_time' => now()->toDateTimeString(),
            ],
            'changed_fields' => null,
            'user_id' => $user->id,
            'user_name' => $user->name,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'url' => $request->fullUrl(),
            'description' => "User '{$user->name}' ({$user->email}) logged out",
        ]);
    }

    /**
     * Log failed login attempt (when user doesn't exist)
     */
    public static function logFailedLoginAttempt(Request $request, string $email): void
    {
        AuditLog::create([
            'action' => 'login_failed',
            'model_type' => User::class,
            'model_id' => null,
            'old_values' => null,
            'new_values' => [
                'attempted_email' => $email,
                'attempt_time' => now()->toDateTimeString(),
                'reason' => 'User not found or invalid credentials'
            ],
            'changed_fields' => null,
            'user_id' => null,
            'user_name' => 'Unknown',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'url' => $request->fullUrl(),
            'description' => "Failed login attempt for email: {$email}",
        ]);
    }

    /**
     * Log password change
     */
    public static function logPasswordChange(User $user, Request $request): void
    {
        AuditLog::create([
            'action' => 'password_changed',
            'model_type' => User::class,
            'model_id' => $user->id,
            'old_values' => null,
            'new_values' => [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
                'change_time' => now()->toDateTimeString(),
            ],
            'changed_fields' => ['password'],
            'user_id' => $user->id,
            'user_name' => $user->name,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'url' => $request->fullUrl(),
            'description' => "User '{$user->name}' changed their password",
        ]);
    }

    /**
     * Log profile update
     */
    public static function logProfileUpdate(User $user, Request $request, array $oldValues, array $newValues): void
    {
        $changedFields = array_keys(array_diff_assoc($newValues, $oldValues));
        
        AuditLog::create([
            'action' => 'profile_updated',
            'model_type' => User::class,
            'model_id' => $user->id,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'changed_fields' => $changedFields,
            'user_id' => $user->id,
            'user_name' => $user->name,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'url' => $request->fullUrl(),
            'description' => "User '{$user->name}' updated their profile",
        ]);
    }

    /**
     * Log system configuration change
     */
    public static function logSystemConfigChange(string $configType, array $oldValues, array $newValues, Request $request): void
    {
        $changedFields = array_keys(array_diff_assoc($newValues, $oldValues));
        
        AuditLog::create([
            'action' => 'system_config_changed',
            'model_type' => 'System',
            'model_id' => null,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'changed_fields' => $changedFields,
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name ?? 'System',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'url' => $request->fullUrl(),
            'description' => "System configuration '{$configType}' was updated",
        ]);
    }

    /**
     * Log bill header settings change
     */
    public static function logBillHeaderChange(array $oldValues, array $newValues, Request $request): void
    {
        $changedFields = array_keys(array_diff_assoc($newValues, $oldValues));
        
        AuditLog::create([
            'action' => 'bill_header_updated',
            'model_type' => 'BillHeader',
            'model_id' => $oldValues['id'] ?? $newValues['id'] ?? null,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'changed_fields' => $changedFields,
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name ?? 'System',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'url' => $request->fullUrl(),
            'description' => "Bill header settings were updated",
        ]);
    }

    /**
     * Log user session timeout
     */
    public static function logSessionTimeout(User $user, Request $request): void
    {
        AuditLog::create([
            'action' => 'session_timeout',
            'model_type' => User::class,
            'model_id' => $user->id,
            'old_values' => null,
            'new_values' => [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
                'timeout_time' => now()->toDateTimeString(),
            ],
            'changed_fields' => null,
            'user_id' => $user->id,
            'user_name' => $user->name,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'url' => $request->fullUrl(),
            'description' => "User '{$user->name}' session timed out",
        ]);
    }

    /**
     * Log suspicious activity
     */
    public static function logSuspiciousActivity(string $activity, Request $request, ?User $user = null): void
    {
        AuditLog::create([
            'action' => 'suspicious_activity',
            'model_type' => User::class,
            'model_id' => $user?->id,
            'old_values' => null,
            'new_values' => [
                'activity' => $activity,
                'detected_time' => now()->toDateTimeString(),
                'user_id' => $user?->id,
                'user_name' => $user?->name ?? 'Unknown',
            ],
            'changed_fields' => null,
            'user_id' => $user?->id,
            'user_name' => $user?->name ?? 'Unknown',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'url' => $request->fullUrl(),
            'description' => "Suspicious activity detected: {$activity}",
        ]);
    }

    /**
     * Get user login history
     */
    public static function getUserLoginHistory(User $user, int $limit = 50)
    {
        return AuditLog::where('model_type', User::class)
            ->where('model_id', $user->id)
            ->whereIn('action', ['login', 'logout', 'login_failed'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get recent system activities
     */
    public static function getRecentSystemActivities(int $limit = 100)
    {
        return AuditLog::orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get bill header change history
     */
    public static function getBillHeaderChangeHistory(int $limit = 50)
    {
        return AuditLog::where('action', 'bill_header_updated')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
