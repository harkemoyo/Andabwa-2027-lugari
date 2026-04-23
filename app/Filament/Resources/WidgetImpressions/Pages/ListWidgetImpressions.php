<?php

namespace App\Filament\Resources\WidgetImpressions\Pages;

use App\Filament\Resources\WidgetImpressions\WidgetImpressionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListWidgetImpressions extends ListRecords
{
    protected static string $resource = WidgetImpressionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
