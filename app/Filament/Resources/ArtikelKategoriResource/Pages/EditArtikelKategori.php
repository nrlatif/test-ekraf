<?php

namespace App\Filament\Resources\ArtikelKategoriResource\Pages;

use App\Filament\Resources\ArtikelKategoriResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditArtikelKategori extends EditRecord
{
    protected static string $resource = ArtikelKategoriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
