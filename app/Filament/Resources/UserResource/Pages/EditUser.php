<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Traits\HandlesCloudinaryUploads;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    use HandlesCloudinaryUploads;
    
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    
    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Jika user sudah memiliki cloudinary_id, kosongkan field image untuk menghindari CORS error
        if ($this->record && $this->record->cloudinary_id) {
            $data['image'] = null;
        }
        
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $oldCloudinaryId = $this->record?->cloudinary_id;
        
        return $this->handleCloudinaryUpload(
            $data,
            'image',
            'cloudinary_id',
            'cloudinary_meta',
            'avatars',
            200,
            200,
            $oldCloudinaryId
        );
    }
}
