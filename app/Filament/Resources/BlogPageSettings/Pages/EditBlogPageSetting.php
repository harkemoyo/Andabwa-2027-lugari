<?php

namespace App\Filament\Resources\BlogPageSettings\Pages;

use App\Filament\Resources\BlogPageSettings\BlogPageSettingResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditBlogPageSetting extends EditRecord
{
    protected static string $resource = BlogPageSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
