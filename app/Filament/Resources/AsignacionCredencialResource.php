<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AsignacionCredencialResource\Pages;
use App\Models\AsignacionCredencial;
use App\Models\Employee;
use App\Models\CatPuesto;
use App\Models\Puesto;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;

class AsignacionCredencialResource extends Resource
{
    protected static ?string $model = AsignacionCredencial::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';
    
    protected static ?string $navigationLabel = 'Credenciales';
    
    protected static ?string $pluralModelLabel = 'Credenciales';
    
    protected static ?string $modelLabel = 'Credencial';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Asignación de Credencial')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                // SELECT DE EMPLEADO - Guarda ID, muestra nombre completo
                                Select::make('id_empleado')
                                    ->label('Empleado')
                                    ->relationship('empleado', 'nombres')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->getOptionLabelFromRecordUsing(fn ($record) => 
                                        trim($record->nombres . ' ' . $record->apellido_paterno . ' ' . $record->apellido_materno)
                                    )
                                    ->prefix('👤'),
                                
                                // SELECT DE PUESTO (catálogo) - Guarda ID, muestra nombre del puesto
                                Select::make('id_puesto')
                                    ->label('Puesto (Rol)')
                                    ->relationship('puesto', 'nombre_puesto')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->createOptionForm([
                                        Forms\Components\TextInput::make('nombre_puesto')
                                            ->label('Nombre del nuevo puesto')
                                            ->required()
                                            ->unique('cat_puestos', 'nombre_puesto'),
                                        Forms\Components\Textarea::make('descripcion')
                                            ->label('Descripción'),
                                        Forms\Components\Toggle::make('activo')
                                            ->label('Activo')
                                            ->default(true),
                                    ])
                                    ->createOptionUsing(fn (array $data) => CatPuesto::create($data))
                                    ->prefix('💼'),
                                
                                // SELECT DE ASIGNACIÓN DE PUESTO - Guarda ID de puestos, muestra número_empleado
                                Select::make('id_asignacion_puesto')
                                    ->label('Número de Empleado')
                                    ->relationship('asignacionPuesto', 'numero_empleado')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->getOptionLabelFromRecordUsing(fn ($record) => 
                                        $record->numero_empleado . ' - ' . optional($record->employee)->nombres . ' ' . optional($record->employee)->apellido_paterno
                                    )
                                    ->prefix('🔢'),
                                
                                // Correo electrónico
                                TextInput::make('correo_electronico')
                                    ->label('Correo Electrónico')
                                    ->email()
                                    ->required()
                                    ->maxLength(255)
                                    ->prefix('📧')
                                    ->placeholder('ejemplo@empresa.com'),
                                
                                // Llave de acceso
                                TextInput::make('llave_acceso')
                                    ->label('Llave de Acceso')
                                    ->required()
                                    ->maxLength(255)
                                    ->prefix('🔑')
                                    ->placeholder('Token o llave única'),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Columna de empleado (nombre completo)
                TextColumn::make('empleado.nombre_completo')
                    ->label('Empleado')
                    ->formatStateUsing(fn ($record) => 
                        $record->empleado 
                            ? trim($record->empleado->nombres . ' ' . $record->empleado->apellido_paterno . ' ' . $record->empleado->apellido_materno)
                            : '—'
                    )
                    ->searchable(query: function ($query, $search) {
                        $query->whereHas('empleado', function ($q) use ($search) {
                            $q->where('nombres', 'like', "%{$search}%")
                              ->orWhere('apellido_paterno', 'like', "%{$search}%")
                              ->orWhere('apellido_materno', 'like', "%{$search}%");
                        });
                    })
                    ->sortable()
                    ->weight('bold'),
                
                // Columna de puesto (nombre del puesto)
                TextColumn::make('puesto.nombre_puesto')
                    ->label('Puesto')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('success'),
                
                // Columna de número de empleado (desde tabla puestos)
                TextColumn::make('asignacionPuesto.numero_empleado')
                    ->label('No. Empleado')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info')
                    ->copyable(),
                
                // Correo electrónico
                TextColumn::make('correo_electronico')
                    ->label('Correo')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-m-envelope'),
                
                // Llave de acceso
                TextColumn::make('llave_acceso')
                    ->label('Llave')
                    ->limit(20)
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                // Fechas
                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('id_puesto')
                    ->label('Puesto')
                    ->relationship('puesto', 'nombre_puesto')
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
            'index' => Pages\ListAsignacionCredenciales::route('/'),
            'create' => Pages\CreateAsignacionCredencial::route('/create'),
            'edit' => Pages\EditAsignacionCredencial::route('/{record}/edit'),
        ];
    }
}