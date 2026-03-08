<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CatAreaResource\Pages;
use App\Models\CatArea;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class CatAreaResource extends Resource
{
    protected static ?string $model = CatArea::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    
    protected static ?string $navigationLabel = 'Áreas';
    
    protected static ?string $pluralModelLabel = 'Áreas';
    
    protected static ?string $modelLabel = 'Área';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información del Área')
                    ->schema([
                        Forms\Components\TextInput::make('nombre_area')
                            ->label('Nombre del Área')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->prefix('📌')
                            ->placeholder('Ej: Tecnología, Ventas, RH'),
                        
                        Forms\Components\Textarea::make('descripcion')
                            ->label('Descripción')
                            ->placeholder('Descripción del área...')
                            ->rows(3),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre_area')
                    ->label('Área')
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCatAreas::route('/'),
            'create' => Pages\CreateCatArea::route('/create'),
            'edit' => Pages\EditCatArea::route('/{record}/edit'),
        ];
    }
}