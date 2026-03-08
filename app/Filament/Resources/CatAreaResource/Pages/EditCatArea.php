<?php

namespace App\Filament\Resources\CatAreaResource\Pages;

use App\Filament\Resources\CatAreaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCatArea extends EditRecord
{
    protected static string $resource = CatAreaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
