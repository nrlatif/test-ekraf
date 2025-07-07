<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Traits\HandlesCloudinaryUploads;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    use HandlesCloudinaryUploads;
    
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return $this->handleCloudinaryUpload(
            $data,
            'image',
            'cloudinary_id',
            'cloudinary_meta',
            'avatars',
            200,
            200
        );
    }
}
