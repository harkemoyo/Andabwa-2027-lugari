<?php

namespace App\Filament\Resources\LiveEvents\Pages;

use App\Filament\Resources\LiveEvents\LiveEventResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLiveEvents extends ListRecords
{
    protected static string $resource = LiveEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
