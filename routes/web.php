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

// Custom Login Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [CustomLoginController::class, 'create'])->name('login');
    Route::post('/login', [CustomLoginController::class, 'store']);
});

// Custom Logout Route
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
// Include authentication routes (excluding login routes that we override)
require __DIR__.'/auth.php';