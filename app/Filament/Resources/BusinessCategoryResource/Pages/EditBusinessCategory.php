<?php

namespace App\Filament\Resources\BusinessCategoryResource\Pages;

use App\Filament\Resources\BusinessCategoryResource;
use Filament\Resources\Pages\EditRecord;

class EditBusinessCategory extends EditRecord
{
    protected static string $resource = BusinessCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\DeleteAction::make(),
        ];
    }
}
