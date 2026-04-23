<?php

namespace App\Filament\Resources\WidgetImpressions\Pages;

use App\Filament\Resources\WidgetImpressions\WidgetImpressionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditWidgetImpression extends EditRecord
{
    protected static string $resource = WidgetImpressionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
