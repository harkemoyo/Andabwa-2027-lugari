<?php

namespace App\Filament\Resources\FooterCtas\Pages;

use App\Filament\Resources\FooterCtas\FooterCtaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFooterCta extends EditRecord
{
    protected static string $resource = FooterCtaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
