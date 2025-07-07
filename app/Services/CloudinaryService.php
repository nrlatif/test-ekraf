<?php

namespace App\Services;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class CloudinaryService
{
    public function __construct()
    {
        // Cloudinary will be accessed via facade, no need for instance variable
    }
    /**
     * Upload file to Cloudinary
     *
     * @param UploadedFile $file
     * @param string $folder
     * @param array $options
     * @return array|null
     */
    public function uploadFile(UploadedFile $file, string $folder = 'EkrafWeb', array $options = []): ?array
    {
        try {
            $defaultOptions = [
                'folder' => $folder,
                'resource_type' => 'auto',
                'quality' => 'auto:good',
                'fetch_format' => 'auto',
            ];

            $uploadOptions = array_merge($defaultOptions, $options);

            $result = Cloudinary::uploadApi()->upload($file->getRealPath(), $uploadOptions);

            // Check if result is valid
            if (!$result) {
                Log::error('Cloudinary upload returned null result', [
                    'file' => $file->getClientOriginalName(),
                    'folder' => $folder,
                    'options' => $options
                ]);
                return null;
            }

            return [
                'public_id' => $result['public_id'],
                'secure_url' => $result['secure_url'],
                'url' => $result['url'],
                'width' => $result['width'] ?? null,
                'height' => $result['height'] ?? null,
                'format' => $result['format'] ?? null,
                'bytes' => $result['bytes'] ?? null,
                'version' => $result['version'] ?? null,
                'folder' => $folder,
            ];
        } catch (\Exception $e) {
            Log::error('Cloudinary upload failed: ' . $e->getMessage(), [
                'file' => $file->getClientOriginalName(),
                'folder' => $folder,
                'options' => $options,
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }

    /**
     * Upload image with specific transformations
     *
     * @param UploadedFile $file
     * @param string $folder
     * @param int $width
     * @param int $height
     * @param string $crop
     * @return array|null
     */
    public function uploadImage(UploadedFile $file, string $folder = 'ekraf', int $width = null, int $height = null, string $crop = 'fill'): ?array
    {
        $options = [];
        
        if ($width && $height) {
            $options['transformation'] = [
                'width' => $width,
                'height' => $height,
                'crop' => $crop,
                'quality' => 'auto:good',
                'fetch_format' => 'auto'
            ];
        }

        return $this->uploadFile($file, $folder, $options);
    }

    /**
     * Delete file from Cloudinary
     *
     * @param string $publicId
     * @return bool
     */
    public function deleteFile(string $publicId): bool
    {
        try {
            $result = Cloudinary::uploadApi()->destroy($publicId);
            return $result['result'] === 'ok';
        } catch (\Exception $e) {
            Log::error('Cloudinary delete failed: ' . $e->getMessage(), [
                'public_id' => $publicId
            ]);
            return false;
        }
    }

    /**
     * Get optimized URL for an image
     *
     * @param string $publicId
     * @param array $transformations
     * @return string|null
     */
    public function getImageUrl(string $publicId, array $transformations = []): ?string
    {
        try {
            if (empty($transformations)) {
                $transformations = [
                    'quality' => 'auto:good',
                    'fetch_format' => 'auto'
                ];
            }

            return (string) Cloudinary::image($publicId)->addTransformation($transformations);
        } catch (\Exception $e) {
            Log::error('Failed to get Cloudinary URL: ' . $e->getMessage(), [
                'public_id' => $publicId,
                'transformations' => $transformations
            ]);
            return null;
        }
    }

    /**
     * Get thumbnail URL
     *
     * @param string $publicId
     * @param int $width
     * @param int $height
     * @return string|null
     */
    public function getThumbnailUrl(string $publicId, int $width = 300, int $height = 200): ?string
    {
        try {
            $transformations = [
                'width' => $width,
                'height' => $height,
                'crop' => 'fill',
                'quality' => 'auto:good',
                'fetch_format' => 'auto'
            ];
            
            return (string) Cloudinary::image($publicId)->addTransformation($transformations);
        } catch (\Exception $e) {
            Log::error('Failed to get thumbnail URL: ' . $e->getMessage(), [
                'public_id' => $publicId,
                'width' => $width,
                'height' => $height
            ]);
            return null;
        }
    }

    /**
     * Check if file exists on Cloudinary
     *
     * @param string $publicId
     * @return bool
     */
    public function fileExists(string $publicId): bool
    {
        try {
            // Try to get URL, if it works file exists
            $url = (string) Cloudinary::image($publicId);
            return !empty($url);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get file info from Cloudinary
     *
     * @param string $publicId
     * @return array|null
     */
    public function getFileInfo(string $publicId): ?array
    {
        try {
            // For file info, we'll return basic info since admin API might not be available in facade
            $url = (string) Cloudinary::image($publicId);
            if ($url) {
                return [
                    'public_id' => $publicId,
                    'secure_url' => $url,
                    'url' => $url
                ];
            }
            return null;
        } catch (\Exception $e) {
            Log::error('Failed to get Cloudinary file info: ' . $e->getMessage(), [
                'public_id' => $publicId
            ]);
            return null;
        }
    }

    /**
     * Upload avatar with specific settings
     *
     * @param UploadedFile $file
     * @param string $userId
     * @return array|null
     */
    public function uploadAvatar(UploadedFile $file, string $userId): ?array
    {
        return $this->uploadImage(
            $file,
            'ekraf/avatars',
            200,
            200,
            'fill'
        );
    }

    /**
     * Upload banner with specific settings
     *
     * @param UploadedFile $file
     * @return array|null
     */
    public function uploadBanner(UploadedFile $file): ?array
    {
        return $this->uploadImage(
            $file,
            'ekraf/banners',
            1200,
            675,
            'fill'
        );
    }

    /**
     * Upload article thumbnail
     *
     * @param UploadedFile $file
     * @return array|null
     */
    public function uploadArticleThumbnail(UploadedFile $file): ?array
    {
        return $this->uploadImage(
            $file,
            'ekraf/articles',
            800,
            450,
            'fill'
        );
    }

    /**
     * Upload product image
     *
     * @param UploadedFile $file
     * @return array|null
     */
    public function uploadProductImage(UploadedFile $file): ?array
    {
        return $this->uploadImage(
            $file,
            'ekraf/products',
            500,
            500,
            'fill'
        );
    }

    /**
     * Upload catalog image
     *
     * @param UploadedFile $file
     * @return array|null
     */
    public function uploadCatalogImage(UploadedFile $file): ?array
    {
        return $this->uploadImage(
            $file,
            'ekraf/catalogs',
            800,
            600,
            'fill'
        );
    }
}
