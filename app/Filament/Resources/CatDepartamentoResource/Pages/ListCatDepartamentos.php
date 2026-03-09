<?php

namespace App\Filament\Resources\CatDepartamentoResource\Pages;

use App\Filament\Resources\CatDepartamentoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCatDepartamentos extends ListRecords
{
    protected static string $resource = CatDepartamentoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
