<?php

namespace App\Filament\Resources\CredencialResource\Pages;

use App\Filament\Resources\CredencialResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCredencials extends ListRecords
{
    protected static string $resource = CredencialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
