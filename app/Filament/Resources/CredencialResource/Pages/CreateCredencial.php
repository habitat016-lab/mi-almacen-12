<?php

namespace App\Filament\Resources\CredencialResource\Pages;

use App\Filament\Resources\CredencialResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCredencial extends CreateRecord
{
    protected static string $resource = CredencialResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
