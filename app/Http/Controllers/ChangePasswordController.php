<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\JsonResponse;

class ChangePasswordController extends Controller
{
    public function show()
    {
        return view('auth.change-password');
    }

    public function update(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = auth()->user();

        // Check if current password matches
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors([
                'current_password' => 'The current password is incorrect. Please re-enter your current password.',
            ])->withInput();
        }

        // Check if new password is same as current password
        if (Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'New password must be different from your current password.',
            ])->withInput();
        }

        // Check if password was used before
        if ($user->isPasswordInHistory($request->password)) {
            $lastChanged = $user->password_changed_at ? $user->password_changed_at->format('F j, Y \a\t g:i A') : 'previously';
            return back()->withErrors([
                'password' => "This password was used before and cannot be reused. Last changed: {$lastChanged}",
            ])->withInput();
        }

        // Store current password in history before updating
        $user->addToPasswordHistory($user->password);

        // Update password
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('status', 'Password changed successfully!');
    }

    /**
     * Validate current password via AJAX
     */
    public function validateCurrentPassword(Request $request): JsonResponse
    {
        $request->validate([
            'current_password' => 'required|string'
        ]);

        $user = auth()->user();
        $isValid = Hash::check($request->current_password, $user->password);

        return response()->json([
            'valid' => $isValid,
            'message' => $isValid ? 'Current password is correct' : 'Current password is incorrect. Please re-enter.'
        ]);
    }

    /**
     * Validate password confirmation via AJAX
     */
    public function validatePasswordConfirmation(Request $request): JsonResponse
    {
        $request->validate([
            'password' => 'required|string',
            'password_confirmation' => 'required|string'
        ]);

        $password = $request->password;
        $passwordConfirmation = $request->password_confirmation;

        $isValid = $password === $passwordConfirmation;
        $message = $isValid ? 'Passwords match' : 'Passwords do not match';

        return response()->json([
            'valid' => $isValid,
            'message' => $message
        ]);
    }

    /**
     * Check if password was used before via AJAX
     */
    public function checkPasswordHistory(Request $request): JsonResponse
    {
        $request->validate([
            'password' => 'required|string'
        ]);

        $user = auth()->user();
        $wasUsedBefore = $user->isPasswordInHistory($request->password);

        if ($wasUsedBefore) {
            $lastChanged = $user->password_changed_at ? $user->password_changed_at->format('F j, Y \a\t g:i A') : 'previously';
            return response()->json([
                'valid' => false,
                'message' => "This password was used before and cannot be reused. Last changed: {$lastChanged}"
            ]);
        }

        return response()->json([
            'valid' => true,
            'message' => 'Password is available for use'
        ]);
    }

    /**
     * Generate a secure password
     */
    public function generatePassword(): JsonResponse
    {
        $length = 12;
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lowercase = 'abcdefghijklmnopqrstuvwxyz';
        $numbers = '0123456789';
        $symbols = '!@#$%^&*()_+-=[]{}|;:,.<>?';

        $password = '';
        
        // Ensure at least one character from each category
        $password .= $uppercase[random_int(0, strlen($uppercase) - 1)];
        $password .= $lowercase[random_int(0, strlen($lowercase) - 1)];
        $password .= $numbers[random_int(0, strlen($numbers) - 1)];
        $password .= $symbols[random_int(0, strlen($symbols) - 1)];

        // Fill the rest with random characters
        $allChars = $uppercase . $lowercase . $numbers . $symbols;
        for ($i = 4; $i < $length; $i++) {
            $password .= $allChars[random_int(0, strlen($allChars) - 1)];
        }

        // Shuffle the password to make it more random
        $password = str_shuffle($password);

        return response()->json([
            'password' => $password
        ]);
    }
} 