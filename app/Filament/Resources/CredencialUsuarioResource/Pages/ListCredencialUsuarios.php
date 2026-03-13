<?php

namespace App\Filament\Resources\CredencialUsuarioResource\Pages;

use App\Filament\Resources\CredencialUsuarioResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCredencialUsuarios extends ListRecords
{
    protected static string $resource = CredencialUsuarioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
