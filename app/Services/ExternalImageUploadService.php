<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ExternalImageUploadService
{
    private $uploadUrl;

    public function __construct()
    {
        // Same service as Android app
        $this->uploadUrl = 'https://apidl.asepharyana.cloud/api/uploader/ryzencdn';
    }

    /**
     * Upload image to external service (same as Android)
     *
     * @param UploadedFile $file
     * @return string|null URL of uploaded image
     */
    public function uploadImage(UploadedFile $file): ?string
    {
        try {
            Log::info('ExternalImageUploadService: Starting upload', [
                'original_name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'upload_url' => $this->uploadUrl
            ]);

            $response = Http::attach(
                'file',
                file_get_contents($file->getPathname()),
                $file->getClientOriginalName()
            )->post($this->uploadUrl);

            if ($response->successful()) {
                $result = $response->json();
                
                Log::info('ExternalImageUploadService: Upload successful', [
                    'response' => $result
                ]);

                if (isset($result['url'])) {
                    return $result['url'];
                }

                Log::warning('ExternalImageUploadService: No URL in response', [
                    'response' => $result
                ]);
                return null;
            }

            Log::error('ExternalImageUploadService: Upload failed', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return null;

        } catch (\Exception $e) {
            Log::error('ExternalImageUploadService: Upload exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return null;
        }
    }

    /**
     * Upload file from local path
     *
     * @param string $filePath
     * @param string $originalName
     * @return string|null
     */
    public function uploadFromPath(string $filePath, string $originalName): ?string
    {
        try {
            if (!file_exists($filePath)) {
                Log::error('ExternalImageUploadService: File not found', [
                    'path' => $filePath
                ]);
                return null;
            }

            Log::info('ExternalImageUploadService: Starting upload from path', [
                'path' => $filePath,
                'original_name' => $originalName,
                'upload_url' => $this->uploadUrl
            ]);

            $response = Http::attach(
                'file',
                file_get_contents($filePath),
                $originalName
            )->post($this->uploadUrl);

            if ($response->successful()) {
                $result = $response->json();
                
                Log::info('ExternalImageUploadService: Upload from path successful', [
                    'response' => $result
                ]);

                if (isset($result['url'])) {
                    return $result['url'];
                }

                Log::warning('ExternalImageUploadService: No URL in response from path', [
                    'response' => $result
                ]);
                return null;
            }

            Log::error('ExternalImageUploadService: Upload from path failed', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return null;

        } catch (\Exception $e) {
            Log::error('ExternalImageUploadService: Upload from path exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return null;
        }
    }

    /**
     * Get upload service URL
     *
     * @return string
     */
    public function getUploadUrl(): string
    {
        return $this->uploadUrl;
    }
}
