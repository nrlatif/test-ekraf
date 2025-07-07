<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubSektor extends Model
{
    protected $table = 'sub_sectors';

    protected $fillable = [
        'title',
        'slug',
        'image',
        'description',
    ];

    public function katalog()
    {
        return $this->hasMany(Katalog::class, 'sub_sector_id');
    }
}
