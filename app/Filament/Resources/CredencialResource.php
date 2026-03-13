<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CredencialResource\Pages;
use App\Models\AsignacionCredencial;
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

class CredencialResource extends Resource
{
    protected static ?string $model = AsignacionCredencial::class;
    protected static ?string $navigationIcon = 
'heroicon-o-identification';
    protected static ?string $navigationLabel = 'Credenciales';
    protected static ?string $pluralModelLabel = 'Credenciales';
    protected static ?string $modelLabel = 'Credencial';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Asignación de Credencial')
                    ->schema([
                        Select::make('id_empleado')
                            ->label('Empleado')
                            ->relationship('empleado', 'nombres')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->reactive()
                            ->getOptionLabelFromRecordUsing(fn ($record) 
=>
                                trim($record->nombres . ' ' . 
$record->apellido_paterno . ' ' . $record->apellido_materno)
                            ),

                        Placeholder::make('puesto_actual')
                            ->label('Puesto asignado')
                            ->content(function ($get) {
                                $empleadoId = $get('id_empleado');
                                if (!$empleadoId) {
                                    return '👈 Seleccione un empleado';
                                }
                                $puesto = Puesto::where('employee_id', 
$empleadoId)
                                                ->latest()
                                                ->first();
                                if (!$puesto || !$puesto->catPuesto) {
                                    return '❌ Sin puesto asignado';
                                }
                                return '✅ ' . 
$puesto->catPuesto->nombre_puesto;
                            })
                            ->extraAttributes(['class' => 'bg-gray-50 p-3 
rounded border']),

                        TextInput::make('correo_electronico')
                            ->label('Correo Electrónico')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        TextInput::make('llave_acceso')
                            ->label('Llave de Acceso')
                            ->required()
                            ->maxLength(255)
                            ->password()
                            ->dehydrateStateUsing(fn ($state) => 
bcrypt($state))
                            ->visibleOn('create'),

                        TextInput::make('llave_acceso')
                            ->label('Nueva Llave de Acceso')
                            ->password()
                            ->dehydrateStateUsing(fn ($state) => $state ? 
bcrypt($state) : null)
                            ->visibleOn('edit'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre_empleado')
                    ->label('Empleado')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('puesto_nombre')
                    ->label('Puesto asignado')
                    ->badge()
                    ->color('success'),

                TextColumn::make('correo_electronico')
                    ->label('Correo')
                    ->searchable()
                    ->copyable()
                    ->icon('heroicon-m-envelope'),

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
            'index' => Pages\ListCredencials::route('/'),
            'create' => Pages\CreateCredencial::route('/create'),
            'edit' => Pages\EditCredencial::route('/{record}/edit'),
        ];
    }
}
