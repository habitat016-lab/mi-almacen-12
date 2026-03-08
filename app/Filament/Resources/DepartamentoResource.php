<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DepartamentoResource\Pages;
use App\Models\Departamento;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

class DepartamentoResource extends Resource
{
    protected static ?string $model = Departamento::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    
    protected static ?string $navigationLabel = 'Departamentos';
    
    protected static ?string $pluralModelLabel = 'Departamentos';
    
    protected static ?string $modelLabel = 'Departamento';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información del Departamento')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('nombre_departamento')
                                    ->label('Nombre del Departamento')
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->prefix('📌')
                                    ->placeholder('Ej: Recursos Humanos'),
                                
                                Forms\Components\TextInput::make('responsable')
                                    ->label('Responsable')
                                    ->prefix('👤')
                                    ->placeholder('Ej: Juan Pérez'),
                                
                                Forms\Components\Textarea::make('descripcion')
                                    ->label('Descripción')
                                    ->placeholder('Descripción del departamento...')
                                    ->rows(3)
                                    ->columnSpanFull(),
                                
                                Forms\Components\Toggle::make('activo')
                                    ->label('Departamento activo')
                                    ->default(true),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre_departamento')
                    ->label('Departamento')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->size('lg'),
                
                TextColumn::make('responsable')
                    ->label('Responsable')
                    ->searchable(),
                
                TextColumn::make('descripcion')
                    ->label('Descripción')
                    ->limit(50)
                    ->toggleable(isToggledHiddenByDefault: true),
                
                TextColumn::make('employees_count')
                    ->label('Empleados')
                    ->counts('employees')
                    ->badge()
                    ->color('info'),
                
                IconColumn::make('activo')
                    ->label('Estado')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
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

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDepartamentos::route('/'),
            'create' => Pages\CreateDepartamento::route('/create'),
            'edit' => Pages\EditDepartamento::route('/{record}/edit'),
        ];
    }
}