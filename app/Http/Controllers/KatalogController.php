<?php

namespace App\Http\Controllers;

use App\Models\Katalog;
use App\Models\SubSektor;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    public function index(Request $request)
    {
        $subsektors = SubSektor::all();

        $katalogs = Katalog::with(['subSektor', 'products'])->withCount('products');

        // Filter berdasarkan subsektor
        if ($request->has('subsektor') && $request->subsektor != '') {
            $katalogs->where('sub_sector_id', $request->subsektor);
        }

        // Filter sort
        if ($request->sort == 'termurah') {
            $katalogs->orderBy('price', 'asc');
        } elseif ($request->sort == 'termahal') {
            $katalogs->orderBy('price', 'desc');
        } elseif ($request->sort == 'terbaru') {
            $katalogs->orderBy('created_at', 'desc');
        } else {
            $katalogs->orderBy('created_at', 'desc');
        }

        $katalogs = $katalogs->paginate(6)->withQueryString();

        return view('pages.katalog', compact('subsektors', 'katalogs'));
    }
    public function bySubsektor($slug)
    {
        $subsektors = SubSektor::all();
        $selectedSubsektor = SubSektor::where('slug', $slug)->firstOrFail();
        $katalogs = Katalog::with(['subSektor', 'products'])->withCount('products')
            ->where('sub_sector_id', $selectedSubsektor->id)
            ->latest()
            ->paginate(6)
            ->withQueryString();

        return view('pages.katalog', compact('subsektors', 'katalogs', 'selectedSubsektor'));
    }
    public function show($slug)
    {
        $katalog = Katalog::with([
            'subSektor', 
            'products' => function($query) {
                $query->where('status', 'disetujui');
            },
            'products.businessCategory', 
            'products.user'
        ])->where('slug', $slug)->firstOrFail();
        
        $others = Katalog::with('subSektor')
                        ->where('id', '!=', $katalog->id)
                        ->latest()
                        ->take(6)
                        ->get();
        return view('pages.katalog.show', compact('katalog', 'others'));
    }
}
