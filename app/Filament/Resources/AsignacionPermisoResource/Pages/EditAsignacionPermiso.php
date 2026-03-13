<?php

namespace App\Filament\Resources\AsignacionPermisoResource\Pages;

use App\Filament\Resources\AsignacionPermisoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAsignacionPermiso extends EditRecord
{
    protected static string $resource = AsignacionPermisoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
