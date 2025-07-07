<?php

namespace App\Http\Controllers;
use App\Models\Artikel;
use App\Models\Author;
use App\Models\Banner;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index()
    {
        // Get active banners with their related articles, ordered by sort_order
        $banners = Banner::with('artikel')
            ->where('is_active', true)
            ->whereNotNull('artikel_id')
            ->orderBy('sort_order', 'asc')
            ->get();
            
        $featureds = Artikel::where('is_featured', true)->get();
        $artikels = Artikel::orderBy('created_at', 'desc')->get()->take(4);
        $authors = Author::all()->take(5);
        return view('pages.berita',compact('banners', 'featureds', 'artikels', 'authors'));
    }
}
