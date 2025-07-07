<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with(['user', 'businessCategory']);

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        } else {
            // Only show approved products by default
            $query->where('status', 'approved');
        }

        // Filter by business category
        if ($request->has('business_category_id')) {
            $query->where('business_category_id', $request->business_category_id);
        }

        // Search by name
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter by price range
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Pagination
        $perPage = $request->get('per_page', 15);
        $products = $query->orderBy('uploaded_at', 'desc')->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $products,
            'message' => 'Products retrieved successfully'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::with(['user', 'businessCategory', 'katalogs'])->find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found'
            ], 404);
        }

        // Only show if approved (unless explicitly requested with admin access)
        if ($product->status !== 'approved') {
            return response()->json([
                'success' => false,
                'message' => 'Product not available'
            ], 403);
        }

        return response()->json([
            'success' => true,
            'data' => $product,
            'message' => 'Product retrieved successfully'
        ]);
    }

    /**
     * Get products by business category
     */
    public function byCategory($categoryId)
    {
        $products = Product::with(['user', 'businessCategory'])
            ->where('business_category_id', $categoryId)
            ->where('status', 'approved')
            ->orderBy('uploaded_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $products,
            'message' => 'Products by category retrieved successfully'
        ]);
    }

    /**
     * Get approved products
     */
    public function approved()
    {
        $products = Product::with(['user', 'businessCategory'])
            ->where('status', 'approved')
            ->orderBy('uploaded_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $products,
            'message' => 'Approved products retrieved successfully'
        ]);
    }
}
