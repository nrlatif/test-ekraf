<?php

namespace App\Filament\Resources\BannerResource\Pages;

use App\Filament\Resources\BannerResource;
use App\Traits\HandlesCloudinaryUploads;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBanner extends CreateRecord
{
    use HandlesCloudinaryUploads;
    
    protected static string $resource = BannerResource::class;
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return $this->handleCloudinaryUpload(
            $data,
            'image',
            'cloudinary_id',
            'cloudinary_meta',
            'banners',
            1200,
            675
        );
    }
}
