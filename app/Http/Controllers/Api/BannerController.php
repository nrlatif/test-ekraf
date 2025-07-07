<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Banner::with(['artikel']);

        // Filter by active status
        if ($request->has('active')) {
            $query->where('is_active', $request->boolean('active'));
        }

        // Get only active banners by default
        if (!$request->has('active')) {
            $query->active();
        }

        $banners = $query->orderBy('sort_order')->get();

        return response()->json([
            'success' => true,
            'data' => $banners,
            'message' => 'Banners retrieved successfully'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $banner = Banner::with(['artikel'])->find($id);

        if (!$banner) {
            return response()->json([
                'success' => false,
                'message' => 'Banner not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $banner,
            'message' => 'Banner retrieved successfully'
        ]);
    }

    /**
     * Get active banners
     */
    public function active()
    {
        $banners = Banner::with(['artikel'])
            ->active()
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $banners,
            'message' => 'Active banners retrieved successfully'
        ]);
    }
}
