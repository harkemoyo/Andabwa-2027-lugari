<?php

namespace App\Filament\Resources\BlogPageSettings;

use App\Filament\Resources\BlogPageSettings\Pages\CreateBlogPageSetting;
use App\Filament\Resources\BlogPageSettings\Pages\EditBlogPageSetting;
use App\Filament\Resources\BlogPageSettings\Pages\ListBlogPageSettings;
use App\Filament\Resources\BlogPageSettings\Pages\ViewBlogPageSetting;
use App\Filament\Resources\BlogPageSettings\Schemas\BlogPageSettingForm;
use App\Filament\Resources\BlogPageSettings\Schemas\BlogPageSettingInfolist;
use App\Filament\Resources\BlogPageSettings\Tables\BlogPageSettingsTable;
use App\Models\BlogPageSetting;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BlogPageSettingResource extends Resource
{

    protected static ?string $model = BlogPageSetting::class;
    
    protected static string | \UnitEnum | null $navigationGroup = 'BlogPageSetting';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $recordTitleAttribute = 'BlogPageSetting';

    public static function form(Schema $schema): Schema
    {
        return BlogPageSettingForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return BlogPageSettingInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BlogPageSettingsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBlogPageSettings::route('/'),
            'create' => CreateBlogPageSetting::route('/create'),
            'view' => ViewBlogPageSetting::route('/{record}'),
            'edit' => EditBlogPageSetting::route('/{record}/edit'),
        ];
    }
}
