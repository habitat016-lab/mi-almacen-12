<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Empleados';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // ===== DATOS PERSONALES =====
                Section::make('Datos Personales')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                TextInput::make('nombres')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('apellido_paterno')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('apellido_materno')
                                    ->required()
                                    ->maxLength(255),
                            ]),
                        Grid::make(2)
                            ->schema([
                                DatePicker::make('fecha_nacimiento')
                                    ->required()
                                    ->displayFormat('d/m/Y'),
                                TextInput::make('telefono')
                                    ->required()
                                    ->tel()
                                    ->maxLength(20),
                            ]),
                        Grid::make(2)
                            ->schema([
                                TextInput::make('rfc')
                                    ->required()
                                    ->maxLength(13)
                                    ->unique(ignoreRecord: true),
                                TextInput::make('curp')
                                    ->required()
                                    ->maxLength(18)
                                    ->unique(ignoreRecord: true),
                            ]),
                    ]),

                // ===== FOTO DEL EMPLEADO (VERSIÓN ESTABLE) =====
                Section::make('Foto')
                    ->schema([
                        FileUpload::make('foto')
                            ->label('Fotografía')
                            ->image()
                            ->directory('empleados')
                            ->maxSize(2048)
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('1:1')
                            ->imageResizeTargetWidth(150)
                            ->imageResizeTargetHeight(150)
                            ->visibility('public')
                            ->helperText('JPG, PNG. Máximo 2MB. 
150x150px')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(false)
                    ->compact(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('foto')
                    ->label('Foto')
                    ->circular()
                    ->size(50)
                    ->defaultImageUrl(url('/images/default-avatar.png')),
                
                TextColumn::make('nombre_completo')
                    ->label('Nombre')
                    ->searchable(['nombres', 'apellido_paterno', 
'apellido_materno'])
                    ->sortable(),
                
                TextColumn::make('rfc')
                    ->label('RFC')
                    ->searchable(),
                
                TextColumn::make('curp')
                    ->label('CURP')
                    ->searchable(),
                
                TextColumn::make('telefono')
                    ->label('Teléfono'),
                
                TextColumn::make('created_at')
                    ->label('Registro')
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
