<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PuestoResource\Pages;
use App\Models\Puesto;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use App\Models\CatMotivo;

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
                                TextInput::make('numero_empleado')
                                    ->label('No. Empleado')
                                    ->prefix('🔢')
                                    ->placeholder('Ej: EMP001')
                                    ->required(),
                                
                                Select::make('employee_id')
                                    ->label('Empleado')
                                    ->relationship('employee', 'nombres')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->getOptionLabelFromRecordUsing(fn ($record) => 
                                        trim($record->nombres . ' ' . $record->apellido_paterno . ' ' . $record->apellido_materno)
                                    ),
                                
                                Select::make('cat_puesto_id')
                                    ->label('Puesto')
                                    ->relationship('catPuesto', 'nombre_puesto')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->createOptionForm([
                                        TextInput::make('nombre_puesto')
                                            ->required()
                                            ->unique(),
                                        Textarea::make('descripcion'),
                                        Forms\Components\Toggle::make('activo')
                                            ->default(true),
                                    ])
                                    ->createOptionUsing(fn ($data) => \App\Models\CatPuesto::create($data))
                                    ->prefix('💼'),

                                Select::make('id_gerencia')
                                    ->label('Gerencia')
                                    ->relationship('gerencia', 'nombre_gerencia')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->createOptionForm([
                                        TextInput::make('nombre_gerencia')
                                            ->required()
                                            ->unique('cat_gerencias', 'nombre_gerencia'),
                                        Textarea::make('descripcion'),
                                    ])
                                    ->createOptionUsing(fn ($data) => \App\Models\CatGerencia::create($data))
                                    ->prefix('🏛️'),
                                
                                Select::make('cat_departamento_id')
                                    ->label('Departamento')
                                    ->relationship('catDepartamento', 'nombre_departamento')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->createOptionForm([
                                        TextInput::make('nombre_departamento')
                                            ->required()
                                            ->unique('cat_departamentos', 'nombre_departamento'),
                                        Textarea::make('descripcion'),
                                        Forms\Components\Toggle::make('activo')
                                            ->default(true),
                                    ])
                                    ->createOptionUsing(fn ($data) => \App\Models\CatDepartamento::create($data))
                                    ->prefix('🏢'),
                                
                                Select::make('id_area')
                                    ->label('Área')
                                    ->relationship('area', 'nombre_area')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->createOptionForm([
                                        TextInput::make('nombre_area')
                                            ->required()
                                            ->unique('cat_areas', 'nombre_area'),
                                        Textarea::make('descripcion'),
                                    ])
                                    ->createOptionUsing(fn ($data) => \App\Models\CatArea::create($data))
                                    ->prefix('🏢'),
                                
                                DatePicker::make('fecha_ingreso')
                                    ->label('Fecha de ingreso')
                                    ->required()
                                    ->prefix('📅')
                                    ->displayFormat('d/m/Y'),
                                
                                TextInput::make('nss')
                                    ->label('NSS')
                                    ->required()
                                    ->maxLength(11)
                                    ->minLength(11)
                                    ->prefix('🆔')
                                    ->placeholder('12345678901'),
                                
                                Forms\Components\Toggle::make('activo')
                                    ->label('Puesto activo')
                                    ->default(true),

                                Select::make('motivo_id')
                                    ->label('Motivo de Asignación')
                                    ->relationship('motivo', 'nombre_motivo')
                                    ->nullable()
                                    ->searchable()
                                    ->preload()
                                    ->placeholder('Selecciona un motivo')
                                    ->createOptionForm([
                                        TextInput::make('nombre_motivo')
                                            ->required()
                                            ->unique('cat_motivos', 'nombre_motivo'),
                                        Textarea::make('descripcion'),
                                    ])
                                    ->createOptionUsing(fn ($data) => CatMotivo::create($data)),
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
                    ->formatStateUsing(fn ($record) => 
                        $record->employee 
                            ? trim($record->employee->nombres . ' ' . $record->employee->apellido_paterno . ' ' . $record->employee->apellido_materno)
                            : '—'
                    )
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('catPuesto.nombre_puesto')
                    ->label('Puesto')
                    ->searchable()
                    ->badge()
                    ->color('success'),
                
                TextColumn::make('catDepartamento.nombre_departamento')
                    ->label('Departamento')
                    ->searchable()
                    ->badge()
                    ->color('info'),
                
                TextColumn::make('area.nombre_area')
                    ->label('Área')
                    ->searchable()
                    ->badge()
                    ->color('info'),
                
                TextColumn::make('gerencia.nombre_gerencia')
                    ->label('Gerencia')
                    ->searchable()
                    ->badge()
                    ->color('info'),
                
                TextColumn::make('fecha_ingreso')
                    ->label('Ingreso')
                    ->date('d/m/Y')
                    ->sortable(),
                
                TextColumn::make('motivo.nombre_motivo')
                    ->label('Motivo')
                    ->badge()
                    ->color('warning')
                    ->searchable(),
                
                IconColumn::make('activo')
                    ->label('Activo')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                
                TextColumn::make('nss')
                    ->label('NSS')
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),
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