<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Models\Employee;
use App\Models\Puesto;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Empleados';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Datos Personales')
                    ->schema([
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('nombres')->required(),
                                Forms\Components\TextInput::make('apellido_paterno')->required(),
                                Forms\Components\TextInput::make('apellido_materno')->required(),
                            ]),
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\DatePicker::make('fecha_nacimiento')->required(),
                                Forms\Components\TextInput::make('telefono')->required(),
                            ]),
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('rfc')->required()->maxLength(13),
                                Forms\Components\TextInput::make('curp')->required()->maxLength(18),
                            ]),
                    ]),
                
                Forms\Components\Section::make('Datos Laborales')
                    ->schema([
                        Forms\Components\Select::make('puesto_id')
                            ->label('Asignación de Puesto')
                            ->relationship('puesto', 'numero_empleado')
                            ->searchable()
                            ->preload()
                            ->getOptionLabelFromRecordUsing(fn ($record) => 
                                $record->numero_empleado . ' - ' . 
                                optional($record->catPuesto)->nombre_puesto
                            )
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre_completo')
                    ->label('NOMBRE COMPLETO')
                    ->getStateUsing(function ($record) {
                        return trim($record->nombres . ' ' . $record->apellido_paterno . ' ' . $record->apellido_materno);
                    })
                    ->searchable(['nombres', 'apellido_paterno', 'apellido_materno'])
                    ->sortable()
                    ->size('lg')
                    ->weight('bold'),
                
                TextColumn::make('puesto.catPuesto.nombre_puesto')
                    ->label('Puesto')
                    ->badge()
                    ->color('success'),
                
                TextColumn::make('puesto.fecha_ingreso')
                    ->label('Ingreso')
                    ->date('d/m/Y'),
                
                TextColumn::make('puesto.nss')
                    ->label('NSS')
                    ->copyable(),
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}