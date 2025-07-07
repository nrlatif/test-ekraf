<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    public function show($slug){
        $artikels = Artikel::with(['author', 'artikelKategori'])
                          ->where('slug', $slug)
                          ->first();
        
        // Jika artikel tidak ditemukan, redirect ke halaman 404 atau halaman artikel
        if (!$artikels) {
            abort(404, 'Artikel tidak ditemukan');
        }
        
        $newests = Artikel::with(['artikelKategori'])
                         ->orderBy('created_at','desc')
                         ->take(4)
                         ->get();
                         
        return view('pages.artikel.show', compact('artikels', 'newests'));
    }
}
