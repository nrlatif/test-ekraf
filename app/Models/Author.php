<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Services\CloudinaryService;

class Author extends Model
{
    protected $fillable = [
        'name',
        'username',
        'avatar',
        'cloudinary_id',
        'cloudinary_meta',
        'avatar_meta',
        'bio'
    ];

    protected $casts = [
        'avatar_meta' => 'array',
        'cloudinary_meta' => 'array',
    ];

    public function artikel(){
        return $this->hasMany(Artikel::class, 'author_id');
    }

    /**
     * Get avatar URL with smart detection and fallback
     */
    public function getAvatarUrlAttribute(): string
    {
        // 1. PRIORITY: Direct URL from external service (Android-compatible)
        // If avatar field contains full URL (from external service, Next.js backend or Cloudinary), use it directly
        if (!empty($this->avatar) && (str_starts_with($this->avatar, 'http://') || str_starts_with($this->avatar, 'https://'))) {
            return $this->avatar;
        }

        // 2. FALLBACK: If we have a Cloudinary ID (old Laravel admin upload), use it
        if (!empty($this->cloudinary_id)) {
            $cloudinaryService = app(CloudinaryService::class);
            $cloudinaryUrl = $cloudinaryService->getThumbnailUrl($this->cloudinary_id, 200, 200);
            
            if ($cloudinaryUrl) {
                return $cloudinaryUrl;
            }
        }

        // 3. FALLBACK: Local storage if avatar exists (legacy)
        if (!empty($this->avatar)) {
            $localPath = public_path('storage/' . $this->avatar);
            if (file_exists($localPath)) {
                return secure_asset('storage/' . $this->avatar);
            }
        }

        // 4. Final fallback to default avatar
        return secure_asset('assets/img/default-avatar.svg');
    }

    /**
     * Get optimized avatar for different sizes
     */
    public function getAvatarUrl(int $width = 200, int $height = 200): string
    {
        if (!empty($this->cloudinary_id)) {
            $cloudinaryService = app(CloudinaryService::class);
            $cloudinaryUrl = $cloudinaryService->getThumbnailUrl($this->cloudinary_id, $width, $height);
            
            if ($cloudinaryUrl) {
                return $cloudinaryUrl;
            }
        }

        return $this->avatar_url;
    }

    /**
     * Get the source type of the current image for debugging
     */
    public function getImageSource(): string
    {
        // Check in priority order
        if (!empty($this->avatar) && filter_var($this->avatar, FILTER_VALIDATE_URL)) {
            return 'URL (Next.js/Cloudinary)';
        }
        
        if (!empty($this->cloudinary_id)) {
            return 'Cloudinary';
        }
        
        if (!empty($this->avatar)) {
            $localPath = public_path('storage/' . $this->avatar);
            if (file_exists($localPath)) {
                return 'Local Storage';
            }
        }
        
        return 'Default Fallback';
    }
}
