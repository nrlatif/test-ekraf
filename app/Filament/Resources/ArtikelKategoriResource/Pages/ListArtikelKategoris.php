<?php

namespace App\Filament\Resources\ArtikelKategoriResource\Pages;

use App\Filament\Resources\ArtikelKategoriResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListArtikelKategoris extends ListRecords
{
    protected static string $resource = ArtikelKategoriResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
