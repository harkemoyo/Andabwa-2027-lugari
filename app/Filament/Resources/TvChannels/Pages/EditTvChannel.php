<?php

namespace App\Filament\Resources\TvChannels\Pages;

use App\Filament\Resources\TvChannels\TvChannelResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTvChannel extends EditRecord
{
    protected static string $resource = TvChannelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
