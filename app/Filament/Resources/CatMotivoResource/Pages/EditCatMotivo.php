<?php

namespace App\Filament\Resources\CatMotivoResource\Pages;

use App\Filament\Resources\CatMotivoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCatMotivo extends EditRecord
{
    protected static string $resource = CatMotivoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
