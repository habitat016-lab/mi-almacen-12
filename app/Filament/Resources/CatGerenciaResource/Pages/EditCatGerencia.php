<?php

namespace App\Filament\Resources\CatGerenciaResource\Pages;

use App\Filament\Resources\CatGerenciaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCatGerencia extends EditRecord
{
    protected static string $resource = CatGerenciaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
