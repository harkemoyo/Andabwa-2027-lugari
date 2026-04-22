<?php

namespace App\Filament\Resources\LiveEvents\Pages;

use App\Filament\Resources\LiveEvents\LiveEventResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLiveEvent extends EditRecord
{
    protected static string $resource = LiveEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
