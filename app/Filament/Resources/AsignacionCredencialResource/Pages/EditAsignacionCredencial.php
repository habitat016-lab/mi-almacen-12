<?php
// Ruta completa: app/Filament/Resources/AsignacionCredencialResource/Pages/EditAsignacionCredencial.php

namespace App\Filament\Resources\AsignacionCredencialResource\Pages;

use App\Filament\Resources\AsignacionCredencialResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAsignacionCredencial extends EditRecord
{
    protected static string $resource = AsignacionCredencialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Credencial actualizada correctamente';
    }
}