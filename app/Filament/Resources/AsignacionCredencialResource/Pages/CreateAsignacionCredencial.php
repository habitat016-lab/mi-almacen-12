<?php
// Ruta completa: app/Filament/Resources/AsignacionCredencialResource/Pages/CreateAsignacionCredencial.php

namespace App\Filament\Resources\AsignacionCredencialResource\Pages;

use App\Filament\Resources\AsignacionCredencialResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAsignacionCredencial extends CreateRecord
{
    protected static string $resource = AsignacionCredencialResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Credencial creada correctamente';
    }
}