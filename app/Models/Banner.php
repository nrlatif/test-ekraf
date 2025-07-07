<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\CloudinaryService;

class Banner extends Model
{
    protected $fillable = [
        'title',
        'image',
        'cloudinary_id',
        'cloudinary_meta',
        'image_meta',
        'link_url',
        'is_active',
        'sort_order',
        'description',
        'artikel_id'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'image_meta' => 'array',
        'cloudinary_meta' => 'array',
    ];

    // Relasi ke artikel
    public function artikel()
    {
        return $this->belongsTo(Artikel::class);
    }

    // Scope untuk banner aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope untuk urutan
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    /**
     * Get image URL with fallback
     */
    public function getImageUrlAttribute(): string
    {
        // 1. PRIORITY: Direct URL from external service (Android-compatible)
        // If image field contains full URL (from external service), use it directly
        if (!empty($this->image) && (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://'))) {
            return $this->image;
        }

        // 2. FALLBACK: If we have a Cloudinary ID (old Laravel admin upload), use it
        if (!empty($this->cloudinary_id)) {
            $cloudinaryService = app(CloudinaryService::class);
            $cloudinaryUrl = $cloudinaryService->getThumbnailUrl($this->cloudinary_id, 1200, 675);
            
            if ($cloudinaryUrl) {
                return $cloudinaryUrl;
            }
        }

        // 3. FALLBACK: Local storage if image exists (legacy)
        if (!empty($this->image) && file_exists(public_path('storage/' . $this->image))) {
            return secure_asset('storage/' . $this->image);
        }

        // 4. Final fallback to placeholder
        return secure_asset('assets/img/placeholder-banner.svg');
    }

    /**
     * Get optimized image for different sizes
     */
    public function getImageUrl(int $width = 800, int $height = 400): string
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
}
