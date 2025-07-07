<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Katalog;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Katalog::with(['subSektor', 'products']);

        // Filter by sub sector
        if ($request->has('sub_sector_id')) {
            $query->where('sub_sector_id', $request->sub_sector_id);
        }

        // Search by title
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Pagination
        $perPage = $request->get('per_page', 15);
        $katalogs = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $katalogs,
            'message' => 'Katalogs retrieved successfully'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $katalog = Katalog::with(['subSektor', 'products' => function($query) {
            $query->where('status', 'approved');
        }])->find($id);

        if (!$katalog) {
            return response()->json([
                'success' => false,
                'message' => 'Katalog not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $katalog,
            'message' => 'Katalog retrieved successfully'
        ]);
    }

    /**
     * Get katalogs by sub sector
     */
    public function bySubSektor($subSektorId)
    {
        $katalogs = Katalog::with(['subSektor', 'products'])
            ->where('sub_sector_id', $subSektorId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $katalogs,
            'message' => 'Katalogs by sub sector retrieved successfully'
        ]);
    }

    /**
     * Get katalog products
     */
    public function products($id)
    {
        $katalog = Katalog::find($id);

        if (!$katalog) {
            return response()->json([
                'success' => false,
                'message' => 'Katalog not found'
            ], 404);
        }

        $products = $katalog->products()
            ->where('status', 'approved')
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $products,
            'message' => 'Katalog products retrieved successfully'
        ]);
    }
}
