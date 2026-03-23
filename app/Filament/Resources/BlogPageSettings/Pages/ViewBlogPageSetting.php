<?php

namespace App\Filament\Resources\BlogPageSettings\Pages;

use App\Filament\Resources\BlogPageSettings\BlogPageSettingResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewBlogPageSetting extends ViewRecord
{
    protected static string $resource = BlogPageSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
