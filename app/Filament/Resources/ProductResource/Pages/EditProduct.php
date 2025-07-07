<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use App\Traits\HandlesCloudinaryUploads;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    use HandlesCloudinaryUploads;
    
    protected static string $resource = ProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\DeleteAction::make(),
        ];
    }
    
    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Jika product sudah memiliki cloudinary_id, kosongkan field image untuk menghindari CORS error
        if ($this->record && $this->record->cloudinary_id) {
            $data['image'] = null;
        }
        
        return $data;
    }
    
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $oldCloudinaryId = $this->record?->cloudinary_id;
        
        return $this->handleProductImageUpload($data, $oldCloudinaryId);
    }
}
