<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ArtikelController;
use App\Http\Controllers\Api\KatalogController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\SubSektorController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ArtikelKategoriController;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\BusinessCategoryController;
use App\Http\Controllers\Api\SyncController;
use App\Http\Requests\Api\SearchRequest;

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

// Apply security middleware to all API routes
Route::middleware(['throttle:api', 'api.security.headers'])->group(function () {

    // Health check endpoint (higher rate limit)
    Route::get('/health', function () {
        return response()->json([
            'success' => true,
            'message' => 'EKRAF API is running',
            'timestamp' => now()->toISOString(),
            'version' => '1.0.0'
        ]);
    })->middleware('throttle:health'); // Use health rate limiter

    // Artikel (Berita) Routes
    Route::prefix('artikel')->group(function () {
        Route::get('/', [ArtikelController::class, 'index']);
        Route::get('/featured', [ArtikelController::class, 'featured']);
        Route::get('/kategori/{categoryId}', [ArtikelController::class, 'byCategory']);
        Route::get('/{id}', [ArtikelController::class, 'show']);
    });

// Katalog Routes
Route::prefix('katalog')->group(function () {
    Route::get('/', [KatalogController::class, 'index']);
    Route::get('/sub-sektor/{subSektorId}', [KatalogController::class, 'bySubSektor']);
    Route::get('/{id}', [KatalogController::class, 'show']);
    Route::get('/{id}/products', [KatalogController::class, 'products']);
});

// Banner Routes
Route::prefix('banners')->group(function () {
    Route::get('/', [BannerController::class, 'index']);
    Route::get('/active', [BannerController::class, 'active']);
    Route::get('/{id}', [BannerController::class, 'show']);
});

// Sub Sektor Routes
Route::prefix('sub-sektor')->group(function () {
    Route::get('/', [SubSektorController::class, 'index']);
    Route::get('/{id}', [SubSektorController::class, 'show']);
    Route::get('/{id}/katalogs', [SubSektorController::class, 'katalogs']);
});

// Product Routes
Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/approved', [ProductController::class, 'approved']);
    Route::get('/kategori/{categoryId}', [ProductController::class, 'byCategory']);
    Route::get('/{id}', [ProductController::class, 'show']);
});

// Artikel Kategori Routes
Route::prefix('artikel-kategori')->group(function () {
    Route::get('/', [ArtikelKategoriController::class, 'index']);
    Route::get('/{id}', [ArtikelKategoriController::class, 'show']);
    Route::get('/{id}/articles', [ArtikelKategoriController::class, 'articles']);
});

// Author Routes
Route::prefix('authors')->group(function () {
    Route::get('/', [AuthorController::class, 'index']);
    Route::get('/{id}', [AuthorController::class, 'show']);
    Route::get('/{id}/articles', [AuthorController::class, 'articles']);
});

// Business Category Routes
Route::prefix('business-category')->group(function () {
    Route::get('/', [BusinessCategoryController::class, 'index']);
    Route::get('/{id}', [BusinessCategoryController::class, 'show']);
    Route::get('/{id}/products', [BusinessCategoryController::class, 'products']);
});

// Sync Routes (untuk sinkronisasi dengan backend Next.js)
Route::prefix('sync')->group(function () {
    Route::get('/status', [SyncController::class, 'syncStatus']);
    Route::post('/from-nextjs', [SyncController::class, 'syncFromNextjs']);
    Route::post('/to-nextjs', [SyncController::class, 'pushToNextjs']);

    // Manual push endpoints for testing
    Route::post('/push-to-nextjs/{type}', [SyncController::class, 'pushToNextjs'])
        ->where('type', 'all|authors|articles|products|katalogs');

    Route::post('/push-single-to-nextjs/{type}/{id}', [SyncController::class, 'pushSingleRecord'])
        ->where('type', 'authors|articles|products|katalogs');

    // Observer status and config
    Route::get('/observer-status', [SyncController::class, 'observerStatus']);
    Route::post('/toggle-observer/{type}', [SyncController::class, 'toggleObserver'])
        ->where('type', 'authors|articles|products|katalogs');
});

// General search endpoint (with stricter rate limiting)
Route::get('/search', function (Request $request) {
    $query = $request->get('q');
    $type = $request->get('type', 'all'); // all, artikel, katalog, product
    
    if (!$query) {
        return response()->json([
            'success' => false,
            'message' => 'Search query is required'
        ], 400);
    }
    
    $results = [];
    
    if ($type === 'all' || $type === 'artikel') {
        $articles = \App\Models\Artikel::with(['author', 'artikelKategori'])
            ->where('title', 'like', "%{$query}%")
            ->orWhere('content', 'like', "%{$query}%")
            ->limit(10)
            ->get();
        $results['articles'] = $articles;
    }
    
    if ($type === 'all' || $type === 'katalog') {
        $katalogs = \App\Models\Katalog::with(['subSektor'])
            ->where('title', 'like', "%{$query}%")
            ->orWhere('content', 'like', "%{$query}%")
            ->orWhere('contact', 'like', "%{$query}%")
            ->limit(10)
            ->get();
        $results['katalogs'] = $katalogs;
    }
    
    if ($type === 'all' || $type === 'product') {
        $products = \App\Models\Product::with(['businessCategory', 'katalogs' => function($query) {
                $query->select('catalogs.id', 'catalogs.title', 'catalogs.slug');
            }])
            ->where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->where('status', 'approved')
            ->limit(10)
            ->get();
        $results['products'] = $products;
    }
    
    return response()->json([
        'success' => true,
        'data' => $results,
        'query' => $query,
        'type' => $type,
        'message' => 'Search completed successfully'
    ]);
})->middleware('throttle:search'); // Apply search rate limiter

// Statistics endpoint
Route::get('/stats', function () {
    $stats = [
        'articles' => \App\Models\Artikel::count(),
        'featured_articles' => \App\Models\Artikel::where('is_featured', true)->count(),
        'katalogs' => \App\Models\Katalog::count(),
        'products' => \App\Models\Product::where('status', 'approved')->count(),
        'sub_sectors' => \App\Models\SubSektor::count(),
        'banners' => \App\Models\Banner::where('is_active', true)->count(),
        'authors' => \App\Models\Author::count(),
        'article_categories' => \App\Models\ArtikelKategori::count(),
        'business_categories' => \App\Models\BusinessCategory::count(),
    ];
    
    return response()->json([
        'success' => true,
        'data' => $stats,
        'message' => 'Statistics retrieved successfully'
    ]);
});

}); // End of security middleware group