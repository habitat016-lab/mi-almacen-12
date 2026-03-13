<?php

namespace App\Filament\Resources\AsignacionPermisoResource\Pages;

use App\Filament\Resources\AsignacionPermisoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAsignacionPermisos extends ListRecords
{
    protected static string $resource = AsignacionPermisoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
