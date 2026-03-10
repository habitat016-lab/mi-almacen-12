<?php

namespace App\Filament\Resources;

use App\Services\PermisoService;
use App\Filament\Resources\RolResource\Pages;
use App\Models\Rol;
use App\Models\CatPuesto;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\ViewField;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

class RolResource extends Resource
{
    protected static ?string $model = Rol::class;
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static ?string $navigationLabel = 'Roles';
    protected static ?string $navigationGroup = 'Seguridad';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Información del Rol')
                    ->schema([
                        Select::make('cat_puesto_id')
                            ->label('Puesto')
                            ->relationship('catPuesto', 'nombre_puesto')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state) {
                                    $puesto = CatPuesto::find($state);
                                    if ($puesto && $puesto->permisos) {
                                        $set('permisos', $puesto->permisos);
                                    }
                                }
                            })
                            ->createOptionForm([
                                Forms\Components\TextInput::make('nombre_puesto')
                                    ->required()
                                    ->unique('cat_puestos', 'nombre_puesto'),
                                Forms\Components\Textarea::make('descripcion'),
                                Forms\Components\Toggle::make('activo')->default(true),
                            ])
                            ->createOptionUsing(fn (array $data) => CatPuesto::create($data)),
                        
                        Textarea::make('observaciones')
                            ->label('Observaciones')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
                
                Section::make('Permisos')
                    ->schema([
                        ViewField::make('permisos')
                            ->view('filament.forms.components.tabla-permisos')
                            ->default(PermisoService::getDefaultPermisos()),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('catPuesto.nombre_puesto')
                    ->label('Puesto')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('nivel_permisos')
                    ->label('Nivel')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'admin' => 'success',
                        'consultor' => 'info',
                        'personalizado' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'admin' => '👑 Administrador',
                        'consultor' => '👁️ Consultor',
                        'personalizado' => '🔧 Personalizado',
                        default => '⚪ Sin permisos',
                    }),
                
                TextColumn::make('observaciones')
                    ->label('Observaciones')
                    ->limit(30)
                    ->toggleable(),
                
                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('cat_puesto_id')
                    ->label('Puesto')
                    ->relationship('catPuesto', 'nombre_puesto')
                    ->searchable(),
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
            'index' => Pages\ListRols::route('/'),
            'create' => Pages\CreateRol::route('/create'),
            'edit' => Pages\EditRol::route('/{record}/edit'),
        ];
    }
}