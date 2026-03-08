<?php

namespace App\Filament\Resources\CatPuestoResource\Pages;

use App\Filament\Resources\CatPuestoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCatPuesto extends EditRecord
{
    protected static string $resource = CatPuestoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
