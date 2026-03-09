<?php

namespace App\Filament\Resources\CatMotivoResource\Pages;

use App\Filament\Resources\CatMotivoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCatMotivos extends ListRecords
{
    protected static string $resource = CatMotivoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
