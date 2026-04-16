<?php

namespace App\Filament\Resources\FooterInfos\Pages;

use App\Filament\Resources\FooterInfos\FooterInfoResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFooterInfo extends EditRecord
{
    protected static string $resource = FooterInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
