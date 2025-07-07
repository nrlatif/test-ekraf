<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Author;
use App\Models\Banner;
use App\Models\Katalog;
use App\Models\SubSektor;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index(){
        $subsektors = SubSektor::all();
        $katalogs = Katalog::with(['subSektor', 'products' => function($query) {
            $query->where('status', 'disetujui');
        }])->withCount('products')->latest()->take(6)->get();
            
        $featureds = Artikel::where('is_featured', true)->get();
        $artikels = Artikel::orderBy('created_at', 'desc')->get()->take(4);
        $authors = Author::all()->take(5);
        return view('pages.landing',compact('subsektors','katalogs', 'featureds', 'artikels', 'authors'));
    }
}
