<?php

namespace App\Filament\Resources\BlogPageSettings\Pages;

use App\Filament\Resources\BlogPageSettings\BlogPageSettingResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBlogPageSetting extends CreateRecord
{
    protected static string $resource = BlogPageSettingResource::class;
}
