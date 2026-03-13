<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AsignacionPermisoResource\Pages;
use App\Models\AsignacionPermiso;
use App\Models\CatPuesto;
use App\Models\Role;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;

class AsignacionPermisoResource extends Resource
{
    protected static ?string $model = AsignacionPermiso::class;
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static ?string $navigationLabel = 'Asignación Permisos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Asignación de Puesto y Rol')
                    ->schema([
                        Select::make('cat_puesto_id')
                            ->label('Puesto')
                            ->relationship('catPuesto', 'nombre_puesto')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->createOptionForm([
                                TextInput::make('nombre_puesto')
                                    ->required()
                                    ->unique('cat_puestos', 'nombre_puesto'),
                                Textarea::make('descripcion'),
                                Toggle::make('activo')->default(true),
                            ])
                            ->createOptionUsing(fn (array $data) => CatPuesto::create($data))
                            ->prefix('💼'),

                        Select::make('role_id')
                            ->label('Rol')
                            ->relationship('role', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->required()
                                    ->unique('roles', 'name'),
                                Textarea::make('description')
                                    ->label('Descripción'),
                            ])
                            ->createOptionUsing(fn (array $data) => Role::create($data))
                            ->prefix('🎭'),

                        Textarea::make('observaciones')
                            ->label('Observaciones')
                            ->rows(3)
                            ->columnSpanFull(),
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

                TextColumn::make('role.name')
                    ->label('Rol')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('success'),

                TextColumn::make('observaciones')
                    ->label('Observaciones')
                    ->limit(30),

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
            'index' => Pages\ListAsignacionPermisos::route('/'),
            'create' => Pages\CreateAsignacionPermiso::route('/create'),
            'edit' => Pages\EditAsignacionPermiso::route('/{record}/edit'),
        ];
    }
}