<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function show($username){
        $author = Author::with(['artikel.artikelKategori'])
                        ->where('username', $username)
                        ->first();
        
        if (!$author) {
            abort(404, 'Author tidak ditemukan');
        }

        return view('pages.author.show', compact('author'));
    }
}
