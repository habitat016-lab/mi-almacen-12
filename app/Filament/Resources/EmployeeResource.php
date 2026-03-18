<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ViewField;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    
    protected static ?string $navigationGroup = 'Recursos Humanos';
    
    protected static ?string $navigationLabel = 'Empleados';
    
    protected static ?string $pluralLabel = 'Empleados';
    
    protected static ?string $singularLabel = 'Empleado';

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Section::make('Datos Personales')
                ->schema([
                    // ELIMINADO: numero_empleado (no existe)
                    
                    TextInput::make('nombres')
                        ->label('Nombres')
                        ->required()
                        ->maxLength(100),
                    
                    TextInput::make('apellido_paterno')
                        ->label('Apellido Paterno')
                        ->required()
                        ->maxLength(100),
                    
                    TextInput::make('apellido_materno')
                        ->label('Apellido Materno')
                        ->maxLength(100),
                    
                    TextInput::make('rfc')
                        ->label('RFC')
                        ->maxLength(20),
                    
                    TextInput::make('curp')
                        ->label('CURP')
                        ->maxLength(20),
                    
                    TextInput::make('telefono')
                        ->label('Teléfono')
                        ->tel()
                        ->maxLength(20),
                    
                    DatePicker::make('fecha_nacimiento')
                        ->label('Fecha de Nacimiento')
                        ->format('Y-m-d')
                        ->displayFormat('d/m/Y'),
                    
                    // Checkbox para activo (aunque no está en la tabla, lo manejaremos aparte)
                    Toggle::make('activo')
                        ->label('Activo')
                        ->default(true)
                        ->disabled(), // Solo informativo por ahora
                ])->columns(2),
            
            // SECCIÓN DE FOTO - Usando nuestro componente unificado
            Section::make('Foto del Empleado')
                ->schema([
                    ViewField::make('foto')
                        ->view('components.foto-empleado')
                        ->label('')
                ])->columnSpanFull(),
        ]);
}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('numero_empleado')
                    ->label('No. Empleado')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('nombre_completo')
                    ->label('Nombre Completo')
                    ->searchable(['nombre', 'apellido_paterno', 
'apellido_materno'])
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('email')
                    ->label('Correo')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('telefono')
                    ->label('Teléfono'),
                
                Tables\Columns\IconColumn::make('activo')
                    ->label('Estado')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                
                Tables\Columns\ImageColumn::make('foto')
                    ->label('Foto')
                    ->circular()
                    ->size(40)
                    ->defaultImageUrl(url('/images/default-avatar.png')),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('activo')
                    ->label('Activos')
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
        return [
            //
        ];
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
