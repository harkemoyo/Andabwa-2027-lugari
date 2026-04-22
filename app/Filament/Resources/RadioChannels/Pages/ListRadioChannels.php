<?php

namespace App\Filament\Resources\RadioChannels\Pages;

use App\Filament\Resources\RadioChannels\RadioChannelResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRadioChannels extends ListRecords
{
    protected static string $resource = RadioChannelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
