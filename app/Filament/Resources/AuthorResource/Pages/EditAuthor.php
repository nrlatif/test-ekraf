<?php

namespace App\Filament\Resources\AuthorResource\Pages;

use App\Filament\Resources\AuthorResource;
use App\Traits\HandlesCloudinaryUploads;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAuthor extends EditRecord
{
    use HandlesCloudinaryUploads;
    
    protected static string $resource = AuthorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    
    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Jika author sudah memiliki cloudinary_id, kosongkan field avatar untuk menghindari CORS error
        if ($this->record && $this->record->cloudinary_id) {
            $data['avatar'] = null;
        }
        
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $oldCloudinaryId = $this->record?->cloudinary_id;
        
        return $this->handleCloudinaryUpload(
            $data,
            'avatar',
            'cloudinary_id',
            'cloudinary_meta',
            'avatars',
            200,
            200,
            $oldCloudinaryId
        );
    }
}
