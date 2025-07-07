<?php

use Illuminate\Support\Facades\Route;

// Test route untuk cek apakah user sudah login dan punya akses admin
Route::get('/test-admin', function () {
    if (auth()->check()) {
        $user = auth()->user();
        return response()->json([
            'authenticated' => true,
            'user_id' => $user->id,
            'user_email' => $user->email,
            'user_level' => $user->level_id,
            'is_admin' => in_array($user->level_id, [1, 2]),
            'can_access_admin' => in_array($user->level_id, [1, 2]) ? 'Yes' : 'No'
        ]);
    }
    
    return response()->json([
        'authenticated' => false,
        'message' => 'User not authenticated'
    ]);
})->middleware('web');
