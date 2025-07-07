<?php

namespace App\Filament\Resources\KatalogResource\Pages;

use App\Filament\Resources\KatalogResource;
use App\Traits\HandlesCloudinaryUploads;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateKatalog extends CreateRecord
{
    use HandlesCloudinaryUploads;
    
    protected static string $resource = KatalogResource::class;
    
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return $this->handleCloudinaryUpload(
            $data,
            'image',
            'cloudinary_id',
            'cloudinary_meta',
            'katalogs',
            800,
            600
        );
    }
}
