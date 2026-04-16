<?php

namespace App\Filament\Resources\FooterCtas\Pages;

use App\Filament\Resources\FooterCtas\FooterCtaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFooterCtas extends ListRecords
{
    protected static string $resource = FooterCtaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
