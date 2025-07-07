<?php

namespace App\Filament\Resources\BusinessCategoryResource\Pages;

use App\Filament\Resources\BusinessCategoryResource;
use Filament\Resources\Pages\ListRecords;

class ListBusinessCategories extends ListRecords
{
    protected static string $resource = BusinessCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\CreateAction::make(),
        ];
    }
}
