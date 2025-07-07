<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Services\CloudinaryService;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'gender',
        'phone_number',
        'image',
        'cloudinary_id',
        'cloudinary_meta',
        'business_name',
        'business_status',
        'level_id',
        'business_category_id',
        'resetPasswordToken',
        'resetPasswordTokenExpiry',
        'verifiedAt'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'resetPasswordToken',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'resetPasswordTokenExpiry' => 'datetime',
            'verifiedAt' => 'datetime',
            'level_id' => 'integer',
            'business_category_id' => 'integer',
            'cloudinary_meta' => 'array',
        ];
    }

    /**
     * Get the level that owns the user.
     */
    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id');
    }

    /**
     * Get the business category that owns the user.
     */
    public function businessCategory()
    {
        return $this->belongsTo(BusinessCategory::class, 'business_category_id');
    }

    /**
     * Get the products for the user.
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'user_id');
    }

    /**
     * Check if user is superadmin
     */
    public function isSuperAdmin(): bool
    {
        return $this->level_id === 1;
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->level_id === 2;
    }

    /**
     * Check if user is regular user
     */
    public function isUser(): bool
    {
        return $this->level_id === 3;
    }

    /**
     * Check if user has admin or superadmin access
     */
    public function hasAdminAccess(): bool
    {
        return $this->level_id === 1 || $this->level_id === 2;
    }

    /**
     * Get profile image URL with fallback
     */
    public function getProfileImageUrlAttribute(): string
    {
        // 1. PRIORITY: Direct URL from external service (Android-compatible)
        // If image field contains full URL (from external service), use it directly
        if (!empty($this->image) && (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://'))) {
            return $this->image;
        }

        // 2. FALLBACK: If we have a Cloudinary ID (old Laravel admin upload), use it
        if (!empty($this->cloudinary_id)) {
            $cloudinaryService = app(CloudinaryService::class);
            $cloudinaryUrl = $cloudinaryService->getThumbnailUrl($this->cloudinary_id, 200, 200);
            
            if ($cloudinaryUrl) {
                return $cloudinaryUrl;
            }
        }

        // 3. FALLBACK: Local storage if image exists (legacy)
        if (!empty($this->image) && file_exists(public_path('storage/' . $this->image))) {
            return asset('storage/' . $this->image);
        }

        // 4. Final fallback to default avatar
        return asset('assets/img/default-avatar.svg');
    }

    /**
     * Get optimized profile image for different sizes
     */
    public function getProfileImageUrl(int $width = 200, int $height = 200): string
    {
        if (!empty($this->cloudinary_id)) {
            $cloudinaryService = app(CloudinaryService::class);
            $cloudinaryUrl = $cloudinaryService->getThumbnailUrl($this->cloudinary_id, $width, $height);
            
            if ($cloudinaryUrl) {
                return $cloudinaryUrl;
            }
        }

        return $this->profile_image_url;
    }

    /**
     * Get avatar URL with fallback (alias for profile_image_url)
     */
    public function getAvatarUrlAttribute(): string
    {
        return $this->profile_image_url;
    }
}
