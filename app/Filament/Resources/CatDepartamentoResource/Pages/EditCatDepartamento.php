<?php

namespace App\Filament\Resources\CatDepartamentoResource\Pages;

use App\Filament\Resources\CatDepartamentoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCatDepartamento extends EditRecord
{
    protected static string $resource = CatDepartamentoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
