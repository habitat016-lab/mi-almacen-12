<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CatGerenciaResource\Pages;
use App\Models\CatGerencia;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class CatGerenciaResource extends Resource
{
    protected static ?string $model = CatGerencia::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    
    protected static ?string $navigationLabel = 'Gerencias';
    
    protected static ?string $pluralModelLabel = 'Gerencias';
    
    protected static ?string $modelLabel = 'Gerencia';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información de Gerencia')
                    ->schema([
                        Forms\Components\TextInput::make('nombre_gerencia')
                            ->label('Nombre de Gerencia')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->prefix('📋')
                            ->placeholder('Ej: Sistemas, Administración, Ventas'),
                        
                        Forms\Components\Textarea::make('descripcion')
                            ->label('Descripción')
                            ->placeholder('Descripción de la gerencia...')
                            ->rows(3),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre_gerencia')
                    ->label('Gerencia')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->size('lg'),
                
                TextColumn::make('descripcion')
                    ->label('Descripción')
                    ->limit(50),
                
                TextColumn::make('puestos_count')
                    ->label('Asignados')
                    ->counts('puestos')
                    ->badge()
                    ->color('info'),
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
            'index' => Pages\ListCatGerencias::route('/'),
            'create' => Pages\CreateCatGerencia::route('/create'),
            'edit' => Pages\EditCatGerencia::route('/{record}/edit'),
        ];
    }
}