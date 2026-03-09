<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CatMotivoResource\Pages;
use App\Models\CatMotivo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;

class CatMotivoResource extends Resource
{
    protected static ?string $model = CatMotivo::class;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';
    
    protected static ?string $navigationLabel = 'Motivos';
    
    protected static ?string $navigationGroup = 'Catálogos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nombre_motivo')
                    ->label('Nombre del Motivo')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                    
                Textarea::make('descripcion')
                    ->label('Descripción')
                    ->nullable()
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre_motivo')
                    ->label('Motivo')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('descripcion')
                    ->label('Descripción')
                    ->limit(50)
                    ->searchable(),
                    
                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCatMotivos::route('/'),
            'create' => Pages\CreateCatMotivo::route('/create'),
            'edit' => Pages\EditCatMotivo::route('/{record}/edit'),
        ];
    }
}