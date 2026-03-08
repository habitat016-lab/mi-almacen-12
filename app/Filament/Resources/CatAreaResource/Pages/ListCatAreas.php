<?php

namespace App\Filament\Resources\CatAreaResource\Pages;

use App\Filament\Resources\CatAreaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCatAreas extends ListRecords
{
    protected static string $resource = CatAreaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
