<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PuestoResource\Pages;
use App\Models\Puesto;
use App\Models\CatDepartamento;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

class PuestoResource extends Resource
{
    protected static ?string $model = Puesto::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    
    protected static ?string $navigationLabel = 'Asignación de Puesto';
    
    protected static ?string $pluralModelLabel = 'Asignaciones';
    
    protected static ?string $modelLabel = 'Asignación';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Asignación de Puesto')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('numero_empleado')
                                    ->label('No. Empleado')
                                    ->prefix('🔢')
                                    ->placeholder('Ej: EMP001')
                                    ->required(),
                                
                                Forms\Components\Select::make('employee_id')
                                    ->label('Empleado')
                                    ->relationship('employee', 'nombres')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->getOptionLabelFromRecordUsing(fn ($record) => 
                                        trim($record->nombres . ' ' . $record->apellido_paterno . ' ' . $record->apellido_materno)
                                    ),
                                
                                Forms\Components\Select::make('cat_puesto_id')
                                    ->label('Puesto (Catálogo)')
                                    ->relationship('catPuesto', 'nombre_puesto')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('nombre_puesto')
                                            ->label('Nombre del nuevo puesto')
                                            ->required()
                                            ->unique(),
                                        Forms\Components\Textarea::make('descripcion')
                                            ->label('Descripción'),
                                        Forms\Components\Toggle::make('activo')
                                            ->label('Activo')
                                            ->default(true),
                                    ])
                                    ->createOptionUsing(function (array $data) {
                                        return \App\Models\CatPuesto::create($data);
                                    })
                                    ->prefix('💼'),
                                
                                // SELECTOR DE DEPARTAMENTO CON BOTÓN PARA CREAR NUEVO
                                Forms\Components\Select::make('cat_departamento_id')
                                    ->label('Departamento')
                                    ->relationship('catDepartamento', 'nombre_departamento')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('nombre_departamento')
                                            ->label('Nombre del nuevo departamento')
                                            ->required()
                                            ->string()
                                            ->unique('cat_departamentos', 'nombre_departamento'),
                                        Forms\Components\Textarea::make('descripcion')
                                            ->label('Descripción'),
                                        Forms\Components\Toggle::make('activo')
                                            ->label('Activo')
                                            ->default(true),
                                    ])

                                    ->createOptionUsing(function (array $data) {
                                        // Forzar que todos los valores sean strings con comillas
                                        $departamento = \App\Models\CatDepartamento::create([
                                        'nombre_departamento' => (string) $data['nombre_departamento'],
                                        'descripcion' => isset($data['descripcion']) ? (string) $data['descripcion'] : null,
                                        'activo' => $data['activo'] ?? true,
                                        ]);
                                        return $departamento;
                                        })

                                    ->prefix('🏢'),
                                
                                Forms\Components\DatePicker::make('fecha_ingreso')
                                    ->label('Fecha de ingreso')
                                    ->required()
                                    ->prefix('📅')
                                    ->displayFormat('d/m/Y'),
                                
                                Forms\Components\TextInput::make('nss')
                                    ->label('NSS')
                                    ->required()
                                    ->maxLength(11)
                                    ->minLength(11)
                                    ->prefix('🆔')
                                    ->placeholder('12345678901'),
                                
                                Forms\Components\TextInput::make('area')
                                    ->label('Área')
                                    ->required()
                                    ->prefix('📌')
                                    ->placeholder('Ej: Tecnología'),
                                
                                Forms\Components\TextInput::make('gerencia')
                                    ->label('Gerencia')
                                    ->required()
                                    ->prefix('👔')
                                    ->placeholder('Ej: Sistemas'),
                                
                                Forms\Components\TextInput::make('motivo')
                                    ->label('Motivo')
                                    ->required()
                                    ->prefix('📝')
                                    ->placeholder('Ej: Nuevo ingreso, Promoción'),
                                
                                Forms\Components\Toggle::make('activo')
                                    ->label('Puesto activo')
                                    ->default(true),

Forms\Components\Select::make('id_area')
    ->label('Área')
    ->relationship('area', 'nombre_area')
    ->searchable()
    ->preload()
    ->required()
    ->createOptionForm([
        Forms\Components\TextInput::make('nombre_area')
            ->label('Nombre del área')
            ->required()
            ->unique('cat_areas', 'nombre_area'),
        Forms\Components\Textarea::make('descripcion')
            ->label('Descripción'),
    ])
    ->createOptionUsing(function (array $data) {
        return \App\Models\CatArea::create($data);
    })
    ->prefix('🏢'),



                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('numero_empleado')
                    ->label('No. Empleado')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                
                TextColumn::make('employee.nombre_completo')
                    ->label('Empleado')
                    ->formatStateUsing(function ($record) {
                        if (!$record->employee) return '—';
                        return trim($record->employee->nombres . ' ' . 
                                   $record->employee->apellido_paterno . ' ' . 
                                   $record->employee->apellido_materno);
                    })
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('catPuesto.nombre_puesto')
                    ->label('Puesto')
                    ->searchable()
                    ->badge()
                    ->color('success'),
                
                // COLUMNA DEL DEPARTAMENTO DESDE CATÁLOGO
                TextColumn::make('catDepartamento.nombre_departamento')
                    ->label('Departamento')
                    ->searchable()
                    ->badge()
                    ->color('info'),
                
                TextColumn::make('fecha_ingreso')
                    ->label('Ingreso')
                    ->date('d/m/Y')
                    ->sortable(),
                
                TextColumn::make('motivo')
                    ->label('Motivo')
                    ->badge()
                    ->color('warning'),
                
                IconColumn::make('activo')
                    ->label('Activo')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                
                TextColumn::make('area')
                    ->label('Área')
                    ->toggleable(isToggledHiddenByDefault: true),
                
                TextColumn::make('gerencia')
                    ->label('Gerencia')
                    ->toggleable(isToggledHiddenByDefault: true),
                
                TextColumn::make('nss')
                    ->label('NSS')
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),

                    TextColumn::make('area.nombre_area')
    ->label('Área')
    ->searchable()
    ->badge()
    ->color('info'),


            ])
            ->filters([
                Tables\Filters\SelectFilter::make('activo')
                    ->label('Estado')
                    ->options([
                        '1' => 'Activos',
                        '0' => 'Inactivos',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPuestos::route('/'),
            'create' => Pages\CreatePuesto::route('/create'),
            'edit' => Pages\EditPuesto::route('/{record}/edit'),
        ];
    }
}