<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\CloudinaryService;

class Product extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'owner_name',
        'name',
        'description',
        'price',
        'stock',
        'image',
        'cloudinary_id',
        'cloudinary_meta',
        'image_meta',
        'phone_number',
        'uploaded_at',
        'user_id',
        'business_category_id',
        'status'
    ];

    protected $casts = [
        'uploaded_at' => 'datetime',
        'price' => 'decimal:2',
        'image_meta' => 'array',
        'cloudinary_meta' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function businessCategory()
    {
        return $this->belongsTo(BusinessCategory::class, 'business_category_id');
    }

    public function onlineStoreLinks()
    {
        return $this->hasMany(OnlineStoreLink::class, 'product_id');
    }

    /**
     * Many-to-Many relationship with Katalog
     * Satu produk bisa ditampilkan di banyak katalog,
     * dan satu katalog bisa memiliki banyak produk
     */
    public function katalogs()
    {
        return $this->belongsToMany(Katalog::class, 'catalog_product', 'product_id', 'catalog_id')
                    ->withTimestamps()
                    ->withPivot(['sort_order', 'is_featured'])
                    ->orderBy('sort_order');
    }

    /**
     * Get image URL with smart detection and fallback
     */
    public function getImageUrlAttribute(): string
    {
        // 1. PRIORITY: Direct URL from external service (Android-compatible)
        // If image field contains full URL (from external service or Next.js backend), use it directly
        if (!empty($this->image) && (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://'))) {
            return $this->image;
        }

        // 2. FALLBACK: If we have a Cloudinary ID (old Laravel admin upload), use it
        if (!empty($this->cloudinary_id)) {
            $cloudinaryService = app(CloudinaryService::class);
            $cloudinaryUrl = $cloudinaryService->getThumbnailUrl($this->cloudinary_id, 500, 500);
            
            if ($cloudinaryUrl) {
                return $cloudinaryUrl;
            }
        }

        // 3. FALLBACK: Local storage if image exists (legacy)
        if (!empty($this->image) && file_exists(public_path('storage/' . $this->image))) {
            return asset('storage/' . $this->image);
        }

        // 4. Final fallback to placeholder
        return asset('assets/img/placeholder-product.svg');
    }

    /**
     * Get optimized image for different sizes
     */
    public function getImageUrl(int $width = 300, int $height = 300): string
    {
        if (!empty($this->cloudinary_id)) {
            $cloudinaryService = app(CloudinaryService::class);
            $cloudinaryUrl = $cloudinaryService->getThumbnailUrl($this->cloudinary_id, $width, $height);
            
            if ($cloudinaryUrl) {
                return $cloudinaryUrl;
            }
        }

        return $this->image_url;
    }

    /**
     * Get the source type of the current image for debugging
     */
    public function getImageSource(): string
    {
        // Check in priority order
        if (!empty($this->image_url) && filter_var($this->image_url, FILTER_VALIDATE_URL)) {
            return 'Next.js URL';
        }
        
        if (!empty($this->cloudinary_id)) {
            return 'Cloudinary';
        }
        
        if (!empty($this->image) && file_exists(public_path('storage/' . $this->image))) {
            return 'Local Storage';
        }
        
        return 'Default Fallback';
    }
}
