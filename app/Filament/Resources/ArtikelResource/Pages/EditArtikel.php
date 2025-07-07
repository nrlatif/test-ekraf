<?php

namespace App\Filament\Resources\ArtikelResource\Pages;

use App\Filament\Resources\ArtikelResource;
use App\Traits\HandlesCloudinaryUploads;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditArtikel extends EditRecord
{
    use HandlesCloudinaryUploads;
    
    protected static string $resource = ArtikelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    
    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Jika artikel sudah memiliki cloudinary_id, kosongkan field thumbnail untuk menghindari CORS error
        if ($this->record && $this->record->cloudinary_id) {
            $data['thumbnail'] = null;
        }
        
        return $data;
    }
    
    protected function fillForm(): void
    {
        $data = $this->record->attributesToArray();
        
        // Kosongkan field thumbnail jika sudah ada di Cloudinary untuk menghindari CORS
        if ($this->record && $this->record->cloudinary_id) {
            $data['thumbnail'] = [];
        }
        
        $data = $this->mutateFormDataBeforeFill($data);
        
        $this->form->fill($data);
    }
    
    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
        
        $this->authorizeAccess();
        
        // Custom form filling untuk menghindari CORS
        $data = $this->record->attributesToArray();
        if ($this->record && $this->record->cloudinary_id) {
            $data['thumbnail'] = [];
        }
        
        $this->form->fill($data);
    }
    
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $oldCloudinaryId = $this->record?->cloudinary_id;
        
        // Handle thumbnail upload using external service (Android-compatible)
        return $this->handleThumbnailUpload($data, $oldCloudinaryId);
    }
}
