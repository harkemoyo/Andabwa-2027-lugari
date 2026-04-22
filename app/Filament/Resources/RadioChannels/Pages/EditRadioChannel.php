<?php

namespace App\Filament\Resources\RadioChannels\Pages;

use App\Filament\Resources\RadioChannels\RadioChannelResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRadioChannel extends EditRecord
{
    protected static string $resource = RadioChannelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
