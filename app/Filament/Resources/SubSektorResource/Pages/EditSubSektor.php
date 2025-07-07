<?php

namespace App\Filament\Resources\SubSektorResource\Pages;

use App\Filament\Resources\SubSektorResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubSektor extends EditRecord
{
    protected static string $resource = SubSektorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
