<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CatPuestoResource\Pages;
use App\Models\CatPuesto;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

class CatPuestoResource extends Resource
{
    protected static ?string $model = CatPuesto::class;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';
    
    protected static ?string $navigationLabel = 'Puestos';
    
    protected static ?string $pluralModelLabel = 'Puestos (Catálogo)';
    
    protected static ?string $modelLabel = 'Puesto del Catálogo';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Datos del Puesto')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('nombre_puesto')
                                    ->label('Nombre del Puesto')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->prefix('💼')
                                    ->placeholder('Ej: Desarrollador Senior'),
                                
                                Forms\Components\Textarea::make('descripcion')
                                    ->label('Descripción')
                                    ->placeholder('Descripción del puesto...')
                                    ->rows(3),
                                
                                Forms\Components\Toggle::make('activo')
                                    ->label('Activo')
                                    ->default(true),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre_puesto')
                    ->label('Puesto')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->size('lg'),
                
                TextColumn::make('descripcion')
                    ->label('Descripción')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->descripcion),
                
                TextColumn::make('puestos_count')
                    ->label('Asignados')
                    ->counts('puestos')
                    ->badge()
                    ->color('info'),
                
                IconColumn::make('activo')
                    ->label('Activo')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('activo')
                    ->label('Estado')
                    ->placeholder('Todos')
                    ->trueLabel('Activos')
                    ->falseLabel('Inactivos'),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCatPuestos::route('/'),
            'create' => Pages\CreateCatPuesto::route('/create'),
            'edit' => Pages\EditCatPuesto::route('/{record}/edit'),
        ];
    }
}