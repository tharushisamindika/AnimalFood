<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Email validation endpoint
Route::post('/validate-email', function (Request $request) {
    $request->validate([
        'email' => 'required|email'
    ]);

    $email = $request->email;
    $user = \App\Models\User::where('email', $email)->first();

    if ($user) {
        return response()->json([
            'valid' => false,
            'message' => 'This email address is already taken.'
        ]);
    }

    return response()->json([
        'valid' => true,
        'message' => 'Email address is available.'
    ]);
});
