<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Artikel;
use App\Models\Product;
use App\Models\Katalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SyncController extends Controller
{
    private $nextjsApiUrl;

    public function __construct()
    {
        $this->nextjsApiUrl = env('NEXTJS_API_URL', 'https://ekraf.asepharyana.tech');
    }

    /**
     * Get current API URL for debugging
     */
    public function getApiUrl(): string
    {
        return $this->nextjsApiUrl;
    }

    /**
     * Sync data from Next.js backend to Laravel web
     */
    public function syncFromNextjs(Request $request)
    {
        $type = $request->get('type', 'all'); // all, authors, articles, products
        $results = [];

        try {
            switch ($type) {
                case 'all':
                    $results['authors'] = $this->syncAuthorsWithFallback();
                    $results['articles'] = $this->syncArticlesWithFallback();
                    $results['products'] = $this->syncProducts();
                    $results['katalogs'] = $this->syncKatalogsWithFallback();
                    break;
                case 'authors':
                    $results['authors'] = $this->syncAuthorsWithFallback();
                    break;
                case 'articles':
                    $results['articles'] = $this->syncArticlesWithFallback();
                    break;
                case 'products':
                    $results['products'] = $this->syncProducts();
                    break;
                case 'katalogs':
                    $results['katalogs'] = $this->syncKatalogsWithFallback();
                    break;
                default:
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid sync type. Use: all, authors, articles, products, katalogs'
                    ], 400);
            }

            return response()->json([
                'success' => true,
                'data' => $results,
                'message' => 'Sync completed successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Sync failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Sync failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Push local changes to Next.js backend
     */
    public function pushToNextjs(Request $request, string $type = null)
    {
        // Handle both old and new API formats
        $type = $type ?: $request->get('type');
        $id = $request->get('id');

        // If no type provided, default to 'all'
        if (!$type) {
            $type = 'all';
        }

        try {
            $results = [];
            
            // If ID is provided, push single record
            if ($id) {
                return $this->pushSingleRecord($request, $type, $id);
            }
            
            // Otherwise push all records of type
            switch ($type) {
                case 'all':
                    $results['authors'] = $this->pushAllAuthors();
                    $results['articles'] = $this->pushAllArticles();
                    $results['products'] = $this->pushAllProducts();
                    $results['katalogs'] = $this->pushAllKatalogs();
                    break;
                case 'authors':
                    $results['authors'] = $this->pushAllAuthors();
                    break;
                case 'articles':
                    $results['articles'] = $this->pushAllArticles();
                    break;
                case 'products':
                    $results['products'] = $this->pushAllProducts();
                    break;
                case 'katalogs':
                    $results['katalogs'] = $this->pushAllKatalogs();
                    break;
                default:
                    throw new \Exception("Unknown type: {$type}");
            }

            return response()->json([
                'status' => 'success',
                'message' => "Successfully pushed {$type} to Next.js",
                'data' => $results
            ]);

        } catch (\Exception $e) {
            Log::error("Error pushing {$type} to Next.js", [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => "Failed to push {$type} to Next.js",
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Push single record to Next.js
     */
    public function pushSingleRecord(Request $request, string $type, int $id)
    {
        try {
            $record = null;
            $data = null;

            switch ($type) {
                case 'authors':
                    $record = Author::findOrFail($id);
                    $data = [
                        'id' => $record->id,
                        'name' => $record->name,
                        'email' => $record->email,
                        'bio' => $record->bio,
                        'avatar' => $record->avatar,
                        'avatar_url' => $record->avatar_url,
                        'cloudinary_id' => $record->cloudinary_id,
                        'social_links' => $record->social_links,
                        'status' => $record->status,
                        'created_at' => $record->created_at?->toISOString(),
                        'updated_at' => $record->updated_at?->toISOString(),
                    ];
                    break;
                case 'articles':
                    $record = Artikel::findOrFail($id);
                    $data = [
                        'id' => $record->id,
                        'author_id' => $record->author_id,
                        'artikel_kategori_id' => $record->artikel_kategori_id,
                        'title' => $record->title,
                        'slug' => $record->slug,
                        'content' => $record->content,
                        'excerpt' => $record->excerpt,
                        'thumbnail' => $record->thumbnail,
                        'thumbnail_url' => $record->thumbnail_url,
                        'thumbnail_cloudinary_id' => $record->thumbnail_cloudinary_id,
                        'meta_description' => $record->meta_description,
                        'tags' => $record->tags,
                        'published_at' => $record->published_at?->toISOString(),
                        'status' => $record->status,
                        'views' => $record->views,
                        'featured' => $record->featured,
                        'created_at' => $record->created_at?->toISOString(),
                        'updated_at' => $record->updated_at?->toISOString(),
                    ];
                    break;
                case 'products':
                    $record = Product::findOrFail($id);
                    $data = [
                        'id' => $record->id,
                        'user_id' => $record->user_id,
                        'business_category_id' => $record->business_category_id,
                        'owner_name' => $record->owner_name,
                        'name' => $record->name,
                        'description' => $record->description,
                        'price' => $record->price,
                        'stock' => $record->stock,
                        'image' => $record->image,
                        'image_url' => $record->image_url,
                        'cloudinary_id' => $record->cloudinary_id,
                        'phone_number' => $record->phone_number,
                        'uploaded_at' => $record->uploaded_at?->toISOString(),
                        'status' => $record->status,
                        'created_at' => $record->created_at?->toISOString(),
                        'updated_at' => $record->updated_at?->toISOString(),
                    ];
                    break;
                case 'katalogs':
                    $record = Katalog::findOrFail($id);
                    $data = [
                        'id' => $record->id,
                        'sub_sector_id' => $record->sub_sector_id,
                        'title' => $record->title,
                        'slug' => $record->slug,
                        'content' => $record->content,
                        'image' => $record->image,
                        'image_url' => $record->image_url,
                        'cloudinary_id' => $record->cloudinary_id,
                        'contact' => $record->contact,
                        'phone_number' => $record->phone_number,
                        'email' => $record->email,
                        'instagram' => $record->instagram,
                        'shopee' => $record->shopee,
                        'tokopedia' => $record->tokopedia,
                        'lazada' => $record->lazada,
                        'created_at' => $record->created_at?->toISOString(),
                        'updated_at' => $record->updated_at?->toISOString(),
                    ];
                    break;
                default:
                    throw new \Exception("Unknown type: {$type}");
            }

            $response = $this->pushSingleToNextjs($type, $data, 'updated');

            return response()->json([
                'status' => 'success',
                'message' => "Successfully pushed {$type} #{$id} to Next.js",
                'data' => $response
            ]);

        } catch (\Exception $e) {
            Log::error("Error pushing single {$type} #{$id} to Next.js", [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => "Failed to push {$type} #{$id} to Next.js",
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Push all authors to Next.js
     */
    private function pushAllAuthors()
    {
        $authors = Author::all();
        $results = [];
        
        foreach ($authors as $author) {
            $data = [
                'id' => $author->id,
                'name' => $author->name,
                'email' => $author->email,
                'bio' => $author->bio,
                'avatar' => $author->avatar,
                'avatar_url' => $author->avatar_url,
                'cloudinary_id' => $author->cloudinary_id,
                'social_links' => $author->social_links,
                'status' => $author->status,
                'created_at' => $author->created_at?->toISOString(),
                'updated_at' => $author->updated_at?->toISOString(),
            ];
            
            $results[] = $this->pushSingleToNextjs('authors', $data, 'updated');
        }
        
        return $results;
    }

    /**
     * Push all articles to Next.js
     */
    private function pushAllArticles()
    {
        $articles = Artikel::all();
        $results = [];
        
        foreach ($articles as $article) {
            $data = [
                'id' => $article->id,
                'author_id' => $article->author_id,
                'artikel_kategori_id' => $article->artikel_kategori_id,
                'title' => $article->title,
                'slug' => $article->slug,
                'content' => $article->content,
                'excerpt' => $article->excerpt,
                'thumbnail' => $article->thumbnail,
                'thumbnail_url' => $article->thumbnail_url,
                'thumbnail_cloudinary_id' => $article->thumbnail_cloudinary_id,
                'meta_description' => $article->meta_description,
                'tags' => $article->tags,
                'published_at' => $article->published_at?->toISOString(),
                'status' => $article->status,
                'views' => $article->views,
                'featured' => $article->featured,
                'created_at' => $article->created_at?->toISOString(),
                'updated_at' => $article->updated_at?->toISOString(),
            ];
            
            $results[] = $this->pushSingleToNextjs('articles', $data, 'updated');
        }
        
        return $results;
    }

    /**
     * Push all products to Next.js
     */
    private function pushAllProducts()
    {
        $products = Product::all();
        $results = [];
        
        foreach ($products as $product) {
            $data = [
                'id' => $product->id,
                'user_id' => $product->user_id,
                'business_category_id' => $product->business_category_id,
                'owner_name' => $product->owner_name,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'stock' => $product->stock,
                'image' => $product->image,
                'image_url' => $product->image_url,
                'cloudinary_id' => $product->cloudinary_id,
                'phone_number' => $product->phone_number,
                'uploaded_at' => $product->uploaded_at?->toISOString(),
                'status' => $product->status,
                'created_at' => $product->created_at?->toISOString(),
                'updated_at' => $product->updated_at?->toISOString(),
            ];
            
            $results[] = $this->pushSingleToNextjs('products', $data, 'updated');
        }
        
        return $results;
    }

    /**
     * Push all katalogs to Next.js
     */
    private function pushAllKatalogs()
    {
        $katalogs = Katalog::all();
        $results = [];
        
        foreach ($katalogs as $katalog) {
            $data = [
                'id' => $katalog->id,
                'sub_sector_id' => $katalog->sub_sector_id,
                'title' => $katalog->title,
                'slug' => $katalog->slug,
                'content' => $katalog->content,
                'image' => $katalog->image,
                'image_url' => $katalog->image_url,
                'cloudinary_id' => $katalog->cloudinary_id,
                'contact' => $katalog->contact,
                'phone_number' => $katalog->phone_number,
                'email' => $katalog->email,
                'instagram' => $katalog->instagram,
                'shopee' => $katalog->shopee,
                'tokopedia' => $katalog->tokopedia,
                'lazada' => $katalog->lazada,
                'created_at' => $katalog->created_at?->toISOString(),
                'updated_at' => $katalog->updated_at?->toISOString(),
            ];
            
            $results[] = $this->pushSingleToNextjs('katalogs', $data, 'updated');
        }
        
        return $results;
    }

    /**
     * Get observer status
     */
    public function observerStatus()
    {
        return response()->json([
            'status' => 'success',
            'observers' => [
                'authors' => 'active',
                'articles' => 'active', 
                'products' => 'active',
                'katalogs' => 'active'
            ],
            'message' => 'All observers are active and will automatically sync changes to Next.js API'
        ]);
    }

    /**
     * Toggle observer (placeholder - observers are always active)
     */
    public function toggleObserver(Request $request, string $type)
    {
        return response()->json([
            'status' => 'info',
            'message' => "Observer for {$type} is always active. Changes will be automatically synced to Next.js API."
        ]);
    }

    /**
     * Push single record to Next.js API
     */
    public function pushSingleToNextjs(string $type, array $data, string $action = 'created')
    {
        try {
            $endpoint = $this->getNextjsEndpoint($type);
            
            switch ($action) {
                case 'created':
                case 'updated':
                    $response = Http::timeout(30)->post($endpoint, $data);
                    break;
                case 'deleted':
                    $response = Http::timeout(30)->delete($endpoint . '/' . $data['id']);
                    break;
                default:
                    throw new \Exception("Unknown action: {$action}");
            }

            if ($response->successful()) {
                return [
                    'success' => true,
                    'status' => $response->status(),
                    'data' => $response->json()
                ];
            } else {
                Log::warning("Failed to push {$type} to Next.js", [
                    'action' => $action,
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'data' => $data
                ]);
                
                return [
                    'success' => false,
                    'status' => $response->status(),
                    'error' => $response->body()
                ];
            }
        } catch (\Exception $e) {
            Log::error("Error pushing {$type} to Next.js", [
                'action' => $action,
                'error' => $e->getMessage(),
                'data' => $data
            ]);
            
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Get Next.js endpoint for specific data type
     */
    private function getNextjsEndpoint(string $type): string
    {
        $endpoints = [
            'authors' => '/api/authors',
            'articles' => '/api/articles', 
            'products' => '/api/products',
            'katalogs' => '/api/katalogs'
        ];

        if (!isset($endpoints[$type])) {
            throw new \Exception("Unknown data type: {$type}");
        }

        return $this->nextjsApiUrl . $endpoints[$type];
    }

    private function syncAuthors()
    {
        $response = Http::get($this->nextjsApiUrl . '/api/users');
        
        if (!$response->successful()) {
            throw new \Exception('Failed to fetch authors from Next.js API');
        }

        $authors = $response->json()['data'] ?? [];
        $synced = [];

        foreach ($authors as $authorData) {
            // Update or create author with URL from Next.js
            $author = Author::updateOrCreate(
                ['id' => $authorData['id']],
                [
                    'name' => $authorData['name'],
                    'username' => $authorData['username'] ?? null,
                    'bio' => $authorData['bio'] ?? null,
                    'avatar' => $authorData['image'], // Store full URL from Next.js
                    'email' => $authorData['email'] ?? null,
                ]
            );

            $synced[] = $author->name;
        }

        return $synced;
    }

    private function syncArticles()
    {
        $response = Http::get($this->nextjsApiUrl . '/api/articles');
        
        if (!$response->successful()) {
            throw new \Exception('Failed to fetch articles from Next.js API');
        }

        $articles = $response->json()['data'] ?? [];
        $synced = [];

        foreach ($articles as $articleData) {
            $article = Artikel::updateOrCreate(
                ['id' => $articleData['id']],
                [
                    'title' => $articleData['title'],
                    'slug' => $articleData['slug'],
                    'content' => $articleData['content'],
                    'thumbnail' => $articleData['thumbnail'], // Store full URL from Next.js
                    'author_id' => $articleData['author_id'],
                    'artikel_kategori_id' => $articleData['artikel_kategori_id'] ?? 1,
                    'is_featured' => $articleData['is_featured'] ?? false,
                    'published_at' => $articleData['created_at'],
                ]
            );

            $synced[] = $article->title;
        }

        return $synced;
    }

    private function syncProducts()
    {
        $response = Http::get($this->nextjsApiUrl . '/api/products');
        
        if (!$response->successful()) {
            throw new \Exception('Failed to fetch products from Next.js API');
        }

        $products = $response->json()['data'] ?? [];
        $synced = [];

        foreach ($products as $productData) {
            $product = Product::updateOrCreate(
                ['id' => $productData['id']],
                [
                    'name' => $productData['name'],
                    'description' => $productData['description'],
                    'price' => $productData['price'],
                    'stock' => $productData['stock'] ?? 0,
                    'image' => $productData['image'], // Store full URL from Next.js
                    'phone_number' => $productData['phone_number'],
                    'user_id' => $productData['user_id'],
                    'business_category_id' => $productData['business_category_id'],
                    'status' => $productData['status'] ?? 'pending',
                    'uploaded_at' => $productData['uploaded_at'],
                ]
            );

            $synced[] = $product->name;
        }

        return $synced;
    }

    private function syncKatalogs()
    {
        $response = Http::get($this->nextjsApiUrl . '/api/katalogs');
        
        if (!$response->successful()) {
            throw new \Exception('Failed to fetch katalogs from Next.js API');
        }

        $katalogs = $response->json()['data'] ?? [];
        $synced = [];

        foreach ($katalogs as $katalogData) {
            $katalog = Katalog::updateOrCreate(
                ['id' => $katalogData['id']],
                [
                    'sub_sector_id' => $katalogData['sub_sector_id'],
                    'title' => $katalogData['title'],
                    'slug' => $katalogData['slug'],
                    'image_url' => $katalogData['image'], // Store full URL from Next.js
                    'product_name' => $katalogData['product_name'],
                    'price' => $katalogData['price'],
                    'content' => $katalogData['content'],
                    'contact' => $katalogData['contact'],
                    'phone_number' => $katalogData['phone_number'],
                    'email' => $katalogData['email'],
                    'instagram' => $katalogData['instagram'],
                    'shopee' => $katalogData['shopee'],
                    'tokopedia' => $katalogData['tokopedia'],
                    'lazada' => $katalogData['lazada'],
                ]
            );

            $synced[] = $katalog->title;
        }

        return $synced;
    }

    private function pushAuthor($id)
    {
        $author = Author::findOrFail($id);
        
        $data = [
            'name' => $author->name,
            'username' => $author->username,
            'bio' => $author->bio,
            'image' => $author->avatar_url, // Use the processed URL
        ];

        // Try to update if exists, otherwise create
        $response = Http::put($this->nextjsApiUrl . "/api/users/{$id}", $data);
        
        if (!$response->successful()) {
            // If update fails, try to create
            $response = Http::post($this->nextjsApiUrl . '/api/users', array_merge($data, ['id' => $id]));
        }

        if (!$response->successful()) {
            throw new \Exception('Failed to push author to Next.js API');
        }

        return $response->json();
    }

    private function pushArticle($id)
    {
        $article = Artikel::with('author')->findOrFail($id);
        
        $data = [
            'title' => $article->title,
            'content' => $article->content,
            'thumbnail' => $article->thumbnail_url, // Use the processed URL
            'author_id' => $article->author_id,
            'artikel_kategori_id' => $article->artikel_kategori_id,
        ];

        $response = Http::put($this->nextjsApiUrl . "/api/articles/{$id}", $data);
        
        if (!$response->successful()) {
            $response = Http::post($this->nextjsApiUrl . '/api/articles', array_merge($data, ['id' => $id]));
        }

        if (!$response->successful()) {
            throw new \Exception('Failed to push article to Next.js API');
        }

        return $response->json();
    }

    private function pushProduct($id)
    {
        $product = Product::findOrFail($id);
        
        $data = [
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'stock' => $product->stock,
            'image' => $product->image_url, // Use the processed URL
            'phone_number' => $product->phone_number,
            'business_category_id' => $product->business_category_id,
            'status' => $product->status,
        ];

        $response = Http::put($this->nextjsApiUrl . "/api/products/{$id}", $data);
        
        if (!$response->successful()) {
            $response = Http::post($this->nextjsApiUrl . '/api/products', array_merge($data, ['id' => $id]));
        }

        if (!$response->successful()) {
            throw new \Exception('Failed to push product to Next.js API');
        }

        return $response->json();
    }

    /**
     * Get sync status and statistics
     */
    public function syncStatus()
    {
        try {
            // Count records with URLs vs Cloudinary
            $stats = [
                'authors' => [
                    'total' => Author::count(),
                    'with_url' => Author::where('avatar', 'like', 'http%')->count(),
                    'with_cloudinary' => Author::whereNotNull('cloudinary_id')->count(),
                    'with_local' => Author::whereNull('cloudinary_id')
                                        ->where(function($q) {
                                            $q->whereNull('avatar')
                                              ->orWhere('avatar', 'not like', 'http%');
                                        })->count(),
                ],
                'articles' => [
                    'total' => Artikel::count(),
                    'with_url' => Artikel::where('thumbnail', 'like', 'http%')->count(),
                    'with_cloudinary' => Artikel::whereNotNull('cloudinary_id')->count(),
                    'with_local' => Artikel::whereNull('cloudinary_id')
                                         ->where(function($q) {
                                             $q->whereNull('thumbnail')
                                               ->orWhere('thumbnail', 'not like', 'http%');
                                         })->count(),
                ],
                'products' => [
                    'total' => Product::count(),
                    'with_url' => Product::where('image', 'like', 'http%')->count(),
                    'with_cloudinary' => Product::whereNotNull('cloudinary_id')->count(),
                    'with_local' => Product::whereNull('cloudinary_id')
                                         ->where(function($q) {
                                             $q->whereNull('image')
                                               ->orWhere('image', 'not like', 'http%');
                                         })->count(),
                ],
                'katalogs' => [
                    'total' => Katalog::count(),
                    'with_url' => Katalog::whereNotNull('image_url')
                                        ->where('image_url', 'like', 'http%')->count(),
                    'with_cloudinary' => Katalog::whereNotNull('cloudinary_id')->count(),
                    'with_local' => Katalog::whereNull('cloudinary_id')
                                         ->where(function($q) {
                                             $q->whereNull('image_url')
                                               ->orWhere('image_url', 'not like', 'http%');
                                         })->count(),
                ]
            ];

            return response()->json([
                'success' => true,
                'data' => $stats,
                'message' => 'Sync status retrieved successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get sync status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Sync methods with fallback for unavailable endpoints
     */
    private function syncAuthorsWithFallback()
    {
        try {
            return $this->syncAuthors();
        } catch (\Exception $e) {
            Log::warning('Authors sync failed, endpoint may require authentication or be unavailable', [
                'error' => $e->getMessage(),
                'url' => $this->nextjsApiUrl . '/api/users'
            ]);
            return ['error' => 'Authors endpoint requires authentication or unavailable'];
        }
    }

    private function syncArticlesWithFallback()
    {
        try {
            return $this->syncArticles();
        } catch (\Exception $e) {
            Log::warning('Articles sync failed, endpoint may require authentication or be unavailable', [
                'error' => $e->getMessage(),
                'url' => $this->nextjsApiUrl . '/api/articles'
            ]);
            return ['error' => 'Articles endpoint requires authentication or unavailable'];
        }
    }

    private function syncKatalogsWithFallback()
    {
        try {
            return $this->syncKatalogs();
        } catch (\Exception $e) {
            Log::warning('Katalogs sync failed, endpoint may be unavailable', [
                'error' => $e->getMessage(),
                'url' => $this->nextjsApiUrl . '/api/katalogs'
            ]);
            return ['error' => 'Katalogs endpoint not available (404)'];
        }
    }
}
