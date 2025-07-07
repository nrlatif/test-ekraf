<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ArtikelKategori;
use Illuminate\Http\Request;

class ArtikelKategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ArtikelKategori::query();

        // Search by name
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Include artikel count
        if ($request->has('with_count')) {
            $query->withCount('artikel');
        }

        $categories = $query->orderBy('name')->get();

        return response()->json([
            'success' => true,
            'data' => $categories,
            'message' => 'Article categories retrieved successfully'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category = ArtikelKategori::with(['artikel' => function($query) {
            $query->with(['author'])->orderBy('created_at', 'desc');
        }])->find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Article category not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $category,
            'message' => 'Article category retrieved successfully'
        ]);
    }

    /**
     * Get articles for a specific category
     */
    public function articles($id)
    {
        $category = ArtikelKategori::find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Article category not found'
            ], 404);
        }

        $articles = $category->artikel()
            ->with(['author'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $articles,
            'message' => 'Category articles retrieved successfully'
        ]);
    }
}
