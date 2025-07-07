<?php

namespace App\Filament\Resources\AuthorResource\Pages;

use App\Filament\Resources\AuthorResource;
use App\Traits\HandlesCloudinaryUploads;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAuthor extends CreateRecord
{
    use HandlesCloudinaryUploads;
    
    protected static string $resource = AuthorResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return $this->handleCloudinaryUpload(
            $data,
            'avatar',
            'cloudinary_id',
            'cloudinary_meta',
            'avatars',
            200,
            200
        );
    }
}
