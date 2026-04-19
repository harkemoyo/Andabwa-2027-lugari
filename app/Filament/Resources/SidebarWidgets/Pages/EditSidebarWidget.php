<?php

namespace App\Filament\Resources\SidebarWidgets\Pages;

use App\Filament\Resources\SidebarWidgets\SidebarWidgetResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSidebarWidget extends EditRecord
{
    protected static string $resource = SidebarWidgetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
