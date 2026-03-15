<?php

namespace App\Filament\Resources\LoginAuditoriaResource\Pages;

use App\Filament\Resources\LoginAuditoriaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLoginAuditorias extends ListRecords
{
    protected static string $resource = LoginAuditoriaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
