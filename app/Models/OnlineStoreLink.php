<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnlineStoreLink extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'product_id',
        'platform_name',
        'url'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
