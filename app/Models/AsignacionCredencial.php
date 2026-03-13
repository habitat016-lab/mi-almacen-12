<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AsignacionCredencialResource\Pages;
use App\Models\AsignacionCredencial;
use App\Models\Employee;
use App\Models\Puesto;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Placeholder;
use Filament\Tables\Columns\TextColumn;

class AsignacionCredencialResource extends Resource
{
    protected static ?string $model = AsignacionCredencial::class;
    protected static ?string $navigationIcon = 'heroicon-o-identification';
    protected static ?string $navigationLabel = 'Credenciales';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Asignación de Credencial')
                    ->schema([
                        // Selector de empleado (guarda id_empleado)
                        Select::make('id_empleado')
                            ->label('Empleado')
                            ->relationship('empleado', 'nombres')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                // Esta función se ejecuta cuando cambia el empleado
                                // No necesita hacer nada especial, pero podemos dejar
                                // un mensaje o limpiar algo si es necesario
                            })
                            ->getOptionLabelFromRecordUsing(fn ($record) =>
                                trim($record->nombres . ' ' . $record->apellido_paterno . ' ' . $record->apellido_materno)
                            ),

                        // Campo SOLO VISUAL que muestra el puesto actual del empleado
                        Placeholder::make('puesto_actual')
                            ->label('Puesto asignado')
                            ->content(function ($get) {
                                $empleadoId = $get('id_empleado');

                                if (!$empleadoId) {
                                    return '👈 Seleccione un empleado para ver su puesto';
                                }

                                $puesto = Puesto::where('employee_id', $empleadoId)
                                                ->latest()
                                                ->first();

                                if (!$puesto) {
                                    return '❌ El empleado no tiene ningún puesto asignado';
                                }

                                $nombrePuesto = $puesto->catPuesto->nombre_puesto ?? 'Puesto sin nombre';
                                $fechaIngreso = $puesto->fecha_ingreso ? $puesto->fecha_ingreso->format('d/m/Y') : 'Fecha no disponible';

                                return "✅ **{$nombrePuesto}** (desde {$fechaIngreso})";
                            })
                            ->extraAttributes(['class' => 'bg-gray-50 p-3 rounded border border-gray-200']),

                        // Campo de correo electrónico
                        TextInput::make('correo_electronico')
                            ->label('Correo Electrónico')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        // Campo de llave de acceso (contraseña)
                        TextInput::make('llave_acceso')
                            ->label('Llave de Acceso')
                            ->required()
                            ->maxLength(255)
                            ->password()
                            ->dehydrateStateUsing(fn ($state) => bcrypt($state))
                            ->visibleOn('create'), // Solo visible al crear

                        // Para edición, no mostramos la contraseña
                        TextInput::make('llave_acceso')
                            ->label('Nueva Llave de Acceso (dejar vacío para no cambiar)')
                            ->password()
                            ->dehydrateStateUsing(fn ($state) => $state ? bcrypt($state) : null)
                            ->visibleOn('edit'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('empleado.nombre_completo')
                    ->label('Empleado')
                    ->formatStateUsing(fn ($record) =>
                        $record->empleado
                            ? trim($record->empleado->nombres . ' ' . $record->empleado->apellido_paterno . ' ' . $record->empleado->apellido_materno)
                            : '—'
                    )
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                // Usamos el accessor del modelo para mostrar el puesto
                TextColumn::make('puesto_nombre')
                    ->label('Puesto asignado')
                    ->badge()
                    ->color('success')
                    ->searchable(),

                TextColumn::make('correo_electronico')
                    ->label('Correo')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-m-envelope'),

                TextColumn::make('llave_acceso')
                    ->label('Llave')
                    ->formatStateUsing(fn ($state) => '••••••••')
                    ->copyable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y')
                    ->sortable(),
            ])
            ->filters([])
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