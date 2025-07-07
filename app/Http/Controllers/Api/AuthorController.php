<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Author::query();

        // Search by name
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Include artikel count
        if ($request->has('with_count')) {
            $query->withCount('artikel');
        }

        $authors = $query->orderBy('name')->get();

        return response()->json([
            'success' => true,
            'data' => $authors,
            'message' => 'Authors retrieved successfully'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $author = Author::with(['artikel' => function($query) {
            $query->with(['artikelKategori'])->orderBy('created_at', 'desc');
        }])->find($id);

        if (!$author) {
            return response()->json([
                'success' => false,
                'message' => 'Author not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $author,
            'message' => 'Author retrieved successfully'
        ]);
    }

    /**
     * Get articles for a specific author
     */
    public function articles($id)
    {
        $author = Author::find($id);

        if (!$author) {
            return response()->json([
                'success' => false,
                'message' => 'Author not found'
            ], 404);
        }

        $articles = $author->artikel()
            ->with(['artikelKategori'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $articles,
            'message' => 'Author articles retrieved successfully'
        ]);
    }
}
