<?php

use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\Auth\CustomLoginController;
use Illuminate\Support\Str;

Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/test-https', function() {
    return view('test-https');
})->name('test-https');
Route::get('/search', function() {
    return view('pages.search');
})->name('search');
Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog');
Route::get('/katalog/detail/{slug}', [KatalogController::class, 'show'])->name('katalog.show');
Route::get('/katalog/subsektor/{subsektor}', [KatalogController::class, 'bySubsektor'])->name('katalog.subsektor');
Route::get('/kontak', [KontakController::class, 'index'])->name('kontak');
Route::get('/artikel', [BeritaController::class, 'index'])->name('artikel');
Route::get('/artikels/{slug}', [ArtikelController::class,'show'])->name('artikels.show');

Route::get('/author/{username}',[AuthorController::class, 'show'])->name('author.show');

// Redirect login route ke admin login
Route::get('/login', function () {
    return redirect('/admin/login');
})->name('login');

// Custom Logout Route untuk halaman publik (jika diperlukan)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [CustomLoginController::class, 'destroy'])->name('logout');
});

// Route untuk menangani storage files dengan CORS headers
Route::get('/storage/{path}', function ($path) {
    $filePath = storage_path('app/public/' . $path);
    
    if (!file_exists($filePath)) {
        abort(404);
    }
    
    $response = response()->file($filePath);
    
    // Tambahkan CORS headers
    $response->headers->set('Access-Control-Allow-Origin', '*');
    $response->headers->set('Access-Control-Allow-Methods', 'GET, OPTIONS');
    $response->headers->set('Access-Control-Allow-Headers', 'Content-Type');
    
    return $response;
})->where('path', '.*');

// Test route untuk debug admin access
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

// Include authentication routes (excluding login routes that we override)
require __DIR__.'/auth.php';