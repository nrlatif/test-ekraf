<?php

namespace App\Filament\Resources\ArtikelResource\Pages;

use App\Filament\Resources\ArtikelResource;
use App\Traits\HandlesCloudinaryUploads;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Log;

class CreateArtikel extends CreateRecord
{
    use HandlesCloudinaryUploads;
    
    protected static string $resource = ArtikelResource::class;
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        try {
            // Handle thumbnail upload using external service (Android-compatible)
            $data = $this->handleThumbnailUpload($data);
            
            Log::info('Article creation data processed', [
                'title' => $data['title'] ?? 'N/A',
                'thumbnail_uploaded' => !empty($data['thumbnail']),
                'external_service' => isset($data['cloudinary_meta']['service']) && $data['cloudinary_meta']['service'] === 'external'
            ]);
            
            return $data;
        } catch (\Exception $e) {
            Log::error('Article creation upload error', [
                'error' => $e->getMessage(),
                'data' => $data,
                'trace' => $e->getTraceAsString()
            ]);
            
            // Re-throw the exception to show user-friendly error
            throw new \Exception('Gagal mengupload gambar: ' . $e->getMessage());
        }
    }
}
