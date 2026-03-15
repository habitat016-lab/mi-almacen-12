<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LoginAuditoriaResource\Pages;
use App\Models\LoginAuditoria;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class LoginAuditoriaResource extends Resource
{
    protected static ?string $model = LoginAuditoria::class;
    protected static ?string $navigationIcon = 
'heroicon-o-clipboard-document-list';
    protected static ?string $navigationLabel = 'Historial de Accesos';
    protected static ?string $navigationGroup = 'Seguridad';
    protected static ?int $navigationSort = 10;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),
                    
                TextColumn::make('credencial.name')
                    ->label('Usuario')
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('credencial.empleado.nombre_completo')
                    ->label('Empleado')
                    ->searchable(),
                    
                TextColumn::make('ip_address')
                    ->label('IP')
                    ->searchable()
                    ->copyable(),
                    
                TextColumn::make('device_fingerprint')
                    ->label('Huella')
                    ->limit(20)
                    ->copyable(),
                    
                TextColumn::make('login_at')
                    ->label('Inicio')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable(),
                    
                TextColumn::make('last_activity_at')
                    ->label('Última actividad')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable(),
                    
                TextColumn::make('created_at')
                    ->label('Registrado')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('credencial_id')
                    ->label('Usuario')
                    ->relationship('credencial', 'correo_electronico')
                    ->searchable()
                    ->preload(),
                    
                Filter::make('login_at')
                    ->form([
                        Forms\Components\DatePicker::make('desde'),
                        Forms\Components\DatePicker::make('hasta'),
                    ])
                    ->query(function (Builder $query, array $data): 
Builder {
                        return $query
                            ->when(
                                $data['desde'],
                                fn (Builder $query, $date): Builder => 
$query->whereDate('login_at', '>=', $date),
                            )
                            ->when(
                                $data['hasta'],
                                fn (Builder $query, $date): Builder => 
$query->whereDate('login_at', '<=', $date),
                            );
                    }),
            ])
            ->defaultSort('login_at', 'desc')
            ->poll('10s')
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLoginAuditorias::route('/'),
        ];
    }
}
