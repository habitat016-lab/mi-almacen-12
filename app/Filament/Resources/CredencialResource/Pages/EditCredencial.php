<?php

namespace App\Filament\Resources\CredencialResource\Pages;

use App\Filament\Resources\CredencialResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCredencial extends EditRecord
{
    protected static string $resource = CredencialResource::class;

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
}
