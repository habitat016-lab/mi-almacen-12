<?php

namespace App\Filament\Resources\CatGerenciaResource\Pages;

use App\Filament\Resources\CatGerenciaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCatGerencias extends ListRecords
{
    protected static string $resource = CatGerenciaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
