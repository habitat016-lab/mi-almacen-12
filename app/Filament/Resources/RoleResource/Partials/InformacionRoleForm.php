<?php

namespace App\Filament\Resources\RoleResource\Partials;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Section;

class InformacionRoleForm
{
    public static function getSchema(): array
    {
        return [
            Section::make('Información del Rol')
                ->schema([
                    TextInput::make('name')
                        ->label('Nombre del Rol')
                        ->required()
                        ->unique('roles', 'name', ignoreRecord: true)
                        ->maxLength(255)
                        ->placeholder('Ej: Administrador, Supervisor, 
etc.'),

                    Textarea::make('description')
                        ->label('Descripción')
                        ->rows(3)
                        ->nullable()
                        ->placeholder('Descripción del rol y sus 
responsabilidades'),
                ]),
        ];
    }
}
