<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RolResource\Pages;
use App\Models\Rol;
use App\Models\Puesto;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class RolResource extends Resource
{
    protected static ?string $model = Rol::class;
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static ?string $navigationLabel = 'Roles';

    public static function form(Form $form): Form
    {
        // OBTENER PUESTOS DIRECTAMENTE SIN MIERDAS
        $puestos = [];
        foreach (Puesto::with('employee', 'catPuesto')->get() as $puesto) {
            $nombreEmpleado = trim(
                ($puesto->employee->nombres ?? '') . ' ' . 
                ($puesto->employee->apellido_paterno ?? '') . ' ' . 
                ($puesto->employee->apellido_materno ?? '')
            ) ?: 'Sin empleado';
            
            $nombrePuesto = $puesto->catPuesto->nombre_puesto ?? 'Sin nombre';
            
            $puestos[$puesto->id] = "ID:{$puesto->id} | {$nombrePuesto} | {$nombreEmpleado}";
        }

        return $form
            ->schema([
                Forms\Components\Section::make('Asignar Rol')
                    ->schema([
                        Forms\Components\Select::make('puesto_id')
                            ->label('Puesto')
                            ->options($puestos)
                            ->searchable()
                            ->required()
                            ->placeholder('Selecciona un puesto'),
                        
                        Forms\Components\Textarea::make('observaciones')
                            ->label('Observaciones')
                            ->rows(3),
                        
                        Forms\Components\Repeater::make('permisos')
                            ->label('Permisos')
                            ->schema([
                                Forms\Components\Select::make('modelo')
                                    ->label('Módulo')
                                    ->options([
                                        'Employee' => 'Empleados',
                                        'Puesto' => 'Puestos',
                                        'CatPuesto' => 'Catálogo Puestos',
                                        'CatDepartamento' => 'Catálogo Departamentos',
                                        'Rol' => 'Roles',
                                    ])
                                    ->required(),
                                Forms\Components\CheckboxList::make('acciones')
                                    ->label('Acciones')
                                    ->options([
                                        'view' => 'Ver',
                                        'create' => 'Crear',
                                        'update' => 'Editar',
                                        'delete' => 'Eliminar',
                                    ])
                                    ->columns(2)
                                    ->required(),
                            ])
                            ->defaultItems(1)
                            ->columnSpanFull()
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID'),
                TextColumn::make('puesto_id')->label('ID Puesto'),
                TextColumn::make('puesto.catPuesto.nombre_puesto')
                    ->label('Puesto')
                    ->searchable(),
                TextColumn::make('puesto.employee.nombres')
                    ->label('Empleado')
                    ->formatStateUsing(fn ($record) => 
                        trim(
                            ($record->puesto->employee->nombres ?? '') . ' ' . 
                            ($record->puesto->employee->apellido_paterno ?? '') . ' ' . 
                            ($record->puesto->employee->apellido_materno ?? '')
                        ) ?: 'Sin empleado'
                    ),
                TextColumn::make('observaciones')->limit(30),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRols::route('/'),
            'create' => Pages\CreateRol::route('/create'),
            'edit' => Pages\EditRol::route('/{record}/edit'),
        ];
    }
}