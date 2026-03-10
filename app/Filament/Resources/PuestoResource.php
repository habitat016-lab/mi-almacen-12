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
use App\Models\CatPuesto;
use App\Models\CatArea;
use App\Models\CatGerencia;
use App\Models\CatDepartamento;

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
                                // Número de Empleado
                                TextInput::make('numero_empleado')
                                    ->label('No. Empleado')
                                    ->prefix('🔢')
                                    ->placeholder('Ej: EMP001')
                                    ->required(),
                                
                                // SELECT DE EMPLEADO (guarda employee_id)
                                Select::make('employee_id')
                                    ->label('Empleado')
                                    ->relationship('employee', 'nombres')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->getOptionLabelFromRecordUsing(fn ($record) => 
                                        trim($record->nombres . ' ' . $record->apellido_paterno . ' ' . $record->apellido_materno)
                                    ),
                                
                                // SELECT DE PUESTO (guarda cat_puesto_id)
                                Select::make('cat_puesto_id')
                                    ->label('Puesto')
                                    ->relationship('catPuesto', 'nombre_puesto')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->createOptionForm([
                                        TextInput::make('nombre_puesto')
                                            ->label('Nombre del nuevo puesto')
                                            ->required()
                                            ->unique('cat_puestos', 'nombre_puesto'),
                                        Textarea::make('descripcion')
                                            ->label('Descripción'),
                                        Forms\Components\Toggle::make('activo')
                                            ->label('Activo')
                                            ->default(true),
                                    ])
                                    ->createOptionUsing(fn (array $data): CatPuesto => CatPuesto::create($data))
                                    ->prefix('💼'),

                                // SELECT DE GERENCIA (guarda id_gerencia)
                                Select::make('id_gerencia')
                                    ->label('Gerencia')
                                    ->relationship('gerencia', 'nombre_gerencia')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->createOptionForm([
                                        TextInput::make('nombre_gerencia')
                                            ->label('Nombre de la gerencia')
                                            ->required()
                                            ->unique('cat_gerencias', 'nombre_gerencia'),
                                        Textarea::make('descripcion')
                                            ->label('Descripción'),
                                    ])
                                    ->createOptionUsing(fn (array $data): CatGerencia => CatGerencia::create($data))
                                    ->prefix('🏛️'),
                                
                                // SELECT DE DEPARTAMENTO (guarda cat_departamento_id)
                                Select::make('cat_departamento_id')
                                    ->label('Departamento')
                                    ->relationship('catDepartamento', 'nombre_departamento')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->createOptionForm([
                                        TextInput::make('nombre_departamento')
                                            ->label('Nombre del nuevo departamento')
                                            ->required()
                                            ->unique('cat_departamentos', 'nombre_departamento'),
                                        Textarea::make('descripcion')
                                            ->label('Descripción'),
                                        Forms\Components\Toggle::make('activo')
                                            ->label('Activo')
                                            ->default(true),
                                    ])
                                    ->createOptionUsing(fn (array $data): CatDepartamento => CatDepartamento::create($data))
                                    ->prefix('🏢'),
                                
                                // SELECT DE ÁREA (guarda id_area)
                                Select::make('id_area')
                                    ->label('Área')
                                    ->relationship('area', 'nombre_area')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->createOptionForm([
                                        TextInput::make('nombre_area')
                                            ->label('Nombre del área')
                                            ->required()
                                            ->unique('cat_areas', 'nombre_area'),
                                        Textarea::make('descripcion')
                                            ->label('Descripción'),
                                    ])
                                    ->createOptionUsing(fn (array $data): CatArea => CatArea::create($data))
                                    ->prefix('🏢'),
                                
                                // Fecha de ingreso
                                DatePicker::make('fecha_ingreso')
                                    ->label('Fecha de ingreso')
                                    ->required()
                                    ->prefix('📅')
                                    ->displayFormat('d/m/Y'),
                                
                                // NSS
                                TextInput::make('nss')
                                    ->label('NSS')
                                    ->required()
                                    ->maxLength(11)
                                    ->minLength(11)
                                    ->prefix('🆔')
                                    ->placeholder('12345678901'),
                                
                                // Activo
                                Forms\Components\Toggle::make('activo')
                                    ->label('Puesto activo')
                                    ->default(true),

                                // SELECT DE MOTIVO (guarda motivo_id)
                                Select::make('motivo_id')
                                    ->label('Motivo de Asignación')
                                    ->relationship('motivo', 'nombre_motivo')
                                    ->nullable()
                                    ->searchable()
                                    ->preload()
                                    ->placeholder('Selecciona un motivo')
                                    ->createOptionForm([
                                        TextInput::make('nombre_motivo')
                                            ->label('Nombre del motivo')
                                            ->required()
                                            ->unique('cat_motivos', 'nombre_motivo'),
                                        Textarea::make('descripcion')
                                            ->label('Descripción'),
                                    ])
                                    ->createOptionUsing(fn (array $data): CatMotivo => CatMotivo::create($data)),
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
                    ->formatStateUsing(fn ($record): string => 
                        $record->employee 
                            ? trim($record->employee->nombres . ' ' . $record->employee->apellido_paterno . ' ' . $record->employee->apellido_materno)
                            : '—'
                    )
                    ->searchable(query: function ($query, $search): void {
                        $query->whereHas('employee', function ($q) use ($search): void {
                            $q->where('nombres', 'like', "%{$search}%")
                              ->orWhere('apellido_paterno', 'like', "%{$search}%")
                              ->orWhere('apellido_materno', 'like', "%{$search}%");
                        });
                    })
                    ->sortable(),
                
                TextColumn::make('catPuesto.nombre_puesto')
                    ->label('Puesto')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('success'),
                
                TextColumn::make('catDepartamento.nombre_departamento')
                    ->label('Departamento')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info'),
                
                TextColumn::make('area.nombre_area')
                    ->label('Área')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info'),
                
                TextColumn::make('gerencia.nombre_gerencia')
                    ->label('Gerencia')
                    ->searchable()
                    ->sortable()
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
                    ->searchable()
                    ->sortable(),
                
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
                Tables\Filters\SelectFilter::make('cat_puesto_id')
                    ->label('Puesto')
                    ->relationship('catPuesto', 'nombre_puesto')
                    ->searchable()
                    ->preload(),
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