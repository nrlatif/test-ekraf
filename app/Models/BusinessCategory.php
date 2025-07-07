<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessCategory extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'name',
        'image'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'business_category_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'business_category_id');
    }
}
