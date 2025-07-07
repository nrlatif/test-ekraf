<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SubSektor;
use Illuminate\Http\Request;

class SubSektorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = SubSektor::query();

        // Search by title
        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // Include katalog count
        if ($request->has('with_count')) {
            $query->withCount('katalog');
        }

        $subSektors = $query->orderBy('title')->get();

        return response()->json([
            'success' => true,
            'data' => $subSektors,
            'message' => 'Sub sectors retrieved successfully'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $subSektor = SubSektor::with(['katalog' => function($query) {
            $query->with(['products' => function($productQuery) {
                $productQuery->where('status', 'approved');
            }]);
        }])->find($id);

        if (!$subSektor) {
            return response()->json([
                'success' => false,
                'message' => 'Sub sector not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $subSektor,
            'message' => 'Sub sector retrieved successfully'
        ]);
    }

    /**
     * Get katalogs for a specific sub sector
     */
    public function katalogs($id)
    {
        $subSektor = SubSektor::find($id);

        if (!$subSektor) {
            return response()->json([
                'success' => false,
                'message' => 'Sub sector not found'
            ], 404);
        }

        $katalogs = $subSektor->katalog()
            ->with(['products' => function($query) {
                $query->where('status', 'approved');
            }])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $katalogs,
            'message' => 'Sub sector katalogs retrieved successfully'
        ]);
    }
}
