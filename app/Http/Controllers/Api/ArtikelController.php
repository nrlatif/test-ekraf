<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use App\Http\Requests\Api\ApiIndexRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class ArtikelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ApiIndexRequest $request): JsonResponse
    {
        try {
            $query = Artikel::with(['author', 'artikelKategori']);

            // Filter by category
            if ($request->has('kategori_id') && is_numeric($request->kategori_id)) {
                $query->where('artikel_kategori_id', $request->kategori_id);
            }

            // Filter by featured
            if ($request->has('featured')) {
                $query->where('is_featured', $request->boolean('featured'));
            }

            // Search by title (with SQL injection protection)
            if ($request->has('search')) {
                $searchTerm = $request->validated()['search'];
                $query->where('title', 'like', '%' . addslashes($searchTerm) . '%');
            }

            // Pagination with limits
            $perPage = min($request->get('per_page', 15), 100); // Max 100 items
            $articles = $query->orderBy('created_at', 'desc')->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $articles,
                'message' => 'Articles retrieved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve articles'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        try {
            // Validate ID is numeric
            if (!is_numeric($id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid article ID'
                ], 400);
            }

            $article = Artikel::with(['author', 'artikelKategori', 'banners'])->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $article,
                'message' => 'Article retrieved successfully'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Article not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve article'
            ], 500);
        }
    }

    /**
     * Get featured articles
     */
    public function featured()
    {
        $articles = Artikel::with(['author', 'artikelKategori'])
            ->featured()
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $articles,
            'message' => 'Featured articles retrieved successfully'
        ]);
    }

    /**
     * Get articles by category
     */
    public function byCategory($categoryId)
    {
        $articles = Artikel::with(['author', 'artikelKategori'])
            ->byKategori($categoryId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $articles,
            'message' => 'Articles by category retrieved successfully'
        ]);
    }
}
