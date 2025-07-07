<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArtikelKategori extends Model
{
    protected $table = 'artikel_kategoris';
    
    protected $fillable = [
        'title',
        'slug',
        'icon',
        'description',
        'color',
    ];

    public function artikel(){
        return $this->hasMany(Artikel::class, 'artikel_kategori_id');
    }
}
