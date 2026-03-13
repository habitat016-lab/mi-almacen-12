<?php

namespace App\Filament\Resources\CredencialUsuarioResource\Pages;

use App\Filament\Resources\CredencialUsuarioResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCredencialUsuario extends EditRecord
{
    protected static string $resource = CredencialUsuarioResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
