<?php

namespace App\Filament\Resources\CatPuestoResource\Pages;

use App\Filament\Resources\CatPuestoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCatPuestos extends ListRecords
{
    protected static string $resource = CatPuestoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
