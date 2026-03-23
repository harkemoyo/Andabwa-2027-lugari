<?php

namespace App\Filament\Resources\BlogPageSettings\Pages;

use App\Filament\Resources\BlogPageSettings\BlogPageSettingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBlogPageSettings extends ListRecords
{
    protected static string $resource = BlogPageSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
