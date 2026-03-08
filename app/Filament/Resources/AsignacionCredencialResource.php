<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AsignacionCredencialResource\Pages;
use App\Models\AsignacionCredencial;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class AsignacionCredencialResource extends Resource
{
    protected static ?string $model = AsignacionCredencial::class;

    protected static ?string $navigationIcon = 'heroicon-o-key';
    
    protected static ?string $navigationLabel = 'Credenciales';
    
    protected static ?string $pluralModelLabel = 'Credenciales';
    
    protected static ?string $modelLabel = 'Credencial';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Asignación de Credencial')
                    ->schema([
                        Forms\Components\Select::make('id_empleado')
                            ->label('Empleado')
                            ->relationship('empleado', 'id')
                            ->getOptionLabelFromRecordUsing(fn ($record) => 
                                trim($record->nombres . ' ' . $record->apellido_paterno . ' ' . $record->apellido_materno)
                            )
                            ->searchable(['nombres', 'apellido_paterno', 'apellido_materno'])
                            ->preload()
                            ->required(),
                        
                        Forms\Components\Select::make('id_puesto')
                            ->label('Puesto')
                            ->relationship('puesto', 'nombre_puesto')
                            ->searchable()
                            ->preload()
                            ->required(),
                        
                        Forms\Components\TextInput::make('correo_electronico')
                            ->label('Correo electrónico')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true),
                        
                        Forms\Components\Select::make('id_asignacion_puesto')
                            ->label('Número de empleado')
                            ->relationship('asignacionPuesto', 'numero_empleado')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->getOptionLabelFromRecordUsing(fn ($record) => 
                                $record->numero_empleado . ' - ' . $record->catPuesto->nombre_puesto
                            ),
                        
                        Forms\Components\TextInput::make('llave_acceso')
                            ->label('Contraseña')
                            ->password()
                            ->required(fn (string $context): bool => $context === 'create')
                            ->dehydrated(fn ($state) => filled($state))
                            ->confirmed(),
                        
                        Forms\Components\TextInput::make('llave_acceso_confirmation')
                            ->label('Confirmar contraseña')
                            ->password()
                            ->required(fn (string $context): bool => $context === 'create')
                            ->dehydrated(false),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('empleado.nombre_completo')
                    ->label('Empleado')
                    ->formatStateUsing(fn ($record) => 
                        trim($record->empleado->nombres . ' ' . 
                             $record->empleado->apellido_paterno . ' ' . 
                             $record->empleado->apellido_materno)
                    )
                    ->searchable(query: function ($query, $search) {
                        return $query->whereHas('empleado', function ($q) use ($search) {
                            $q->whereRaw("CONCAT(nombres, ' ', apellido_paterno, ' ', apellido_materno) like ?", ["%{$search}%"]);
                        });
                    })
                    ->sortable(),
                
                TextColumn::make('puesto.nombre_puesto')
                    ->label('Puesto')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('correo_electronico')
                    ->label('Correo')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Correo copiado'),
                
                TextColumn::make('asignacionPuesto.numero_empleado')
                    ->label('Número de Empleado')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('success'),
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
            'index' => Pages\ListAsignacionCredencials::route('/'),
            'create' => Pages\CreateAsignacionCredencial::route('/create'),
            'edit' => Pages\EditAsignacionCredencial::route('/{record}/edit'),
        ];
    }
}