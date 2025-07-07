<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BusinessCategory;
use Illuminate\Http\Request;

class BusinessCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = BusinessCategory::query();

        // Search by name
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Include product count
        if ($request->has('with_count')) {
            $query->withCount(['products' => function($productQuery) {
                $productQuery->where('status', 'approved');
            }]);
        }

        $categories = $query->orderBy('name')->get();

        return response()->json([
            'success' => true,
            'data' => $categories,
            'message' => 'Business categories retrieved successfully'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category = BusinessCategory::with(['products' => function($query) {
            $query->where('status', 'approved')->with(['user'])->orderBy('uploaded_at', 'desc');
        }])->find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Business category not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $category,
            'message' => 'Business category retrieved successfully'
        ]);
    }

    /**
     * Get products for a specific business category
     */
    public function products($id)
    {
        $category = BusinessCategory::find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Business category not found'
            ], 404);
        }

        $products = $category->products()
            ->where('status', 'approved')
            ->with(['user'])
            ->orderBy('uploaded_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $products,
            'message' => 'Category products retrieved successfully'
        ]);
    }
}
