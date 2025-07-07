<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\CloudinaryService;

class Katalog extends Model
{
    use HasFactory;

    protected $table = 'catalogs';

    protected $fillable = [
        'sub_sector_id',
        'title',
        'slug',
        'image',
        'image_url',        // URL langsung dari Next.js backend
        'cloudinary_id',
        'cloudinary_meta',
        'image_meta',
        'product_name',
        'price',      
        'content',
        'contact',
        'phone_number',      
        'email',
        'instagram',  
        'shopee',     
        'tokopedia', 
        'lazada',    
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'image_meta' => 'array',
        'cloudinary_meta' => 'array',
    ];

    public function subSektor()
    {
        return $this->belongsTo(SubSektor::class, 'sub_sector_id');
    }

    /**
     * Many-to-Many relationship with Product
     * Satu katalog bisa memiliki banyak produk, 
     * dan satu produk bisa ditampilkan di banyak katalog
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'catalog_product', 'catalog_id', 'product_id')
                    ->withTimestamps()
                    ->withPivot(['sort_order', 'is_featured'])
                    ->orderBy('sort_order');
    }

    /**
     * Get image URL with fallback (supports External service, Next.js URL, Cloudinary, and local)
     */
    public function getImageUrlAttribute(): string
    {
        // 1. PRIORITY: Direct URL from external service (Android-compatible)
        // If image_url field contains full URL, use it directly
        if (!empty($this->image_url) && filter_var($this->image_url, FILTER_VALIDATE_URL)) {
            return $this->image_url;
        }

        // 2. PRIORITY: Direct URL in image field (from external service)
        if (!empty($this->image) && (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://'))) {
            return $this->image;
        }

        // 3. FALLBACK: If we have a Cloudinary ID (old Laravel admin upload), use it
        if (!empty($this->cloudinary_id)) {
            $cloudinaryService = app(CloudinaryService::class);
            $cloudinaryUrl = $cloudinaryService->getThumbnailUrl($this->cloudinary_id, 800, 600);
            
            if ($cloudinaryUrl) {
                return $cloudinaryUrl;
            }
        }

        // 4. FALLBACK: Local storage if image exists (legacy)
        if (!empty($this->image) && file_exists(public_path('storage/' . $this->image))) {
            return secure_asset('storage/' . $this->image);
        }

        // 5. Final fallback to placeholder
        return secure_asset('assets/img/placeholder-catalog.svg');
    }

    /**
     * Get optimized image for different sizes
     */
    public function getImageUrl(int $width = 400, int $height = 300): string
    {
        // For Next.js URLs, return as-is (assume they're already optimized)
        if (!empty($this->image_url) && filter_var($this->image_url, FILTER_VALIDATE_URL)) {
            return $this->image_url;
        }

        // For Cloudinary, get optimized version
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
