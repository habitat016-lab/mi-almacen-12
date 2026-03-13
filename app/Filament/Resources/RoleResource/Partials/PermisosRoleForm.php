<?php

namespace App\Filament\Resources\RoleResource\Partials;

use App\Services\PermisoService;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\ViewField;

class PermisosRoleForm
{
    public static function getSchema(): array
    {
        return [
            Section::make('Matriz de Permisos')
                ->schema([
                    ViewField::make('permissions')
                        ->view('filament.forms.components.tabla-permisos')
                        ->default(PermisoService::getDefaultPermisos()),
                ]),
        ];
    }
}
