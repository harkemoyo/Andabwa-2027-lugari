<?php

namespace App\Filament\Resources\FooterInfos;

use App\Filament\Resources\FooterInfos\Pages\CreateFooterInfo;
use App\Filament\Resources\FooterInfos\Pages\EditFooterInfo;
use App\Filament\Resources\FooterInfos\Pages\ManageFooterInfos;
use App\Filament\Resources\FooterInfos\Schemas\FooterInfoForm;
use App\Filament\Resources\FooterInfos\Tables\FooterInfosTable;
use App\Models\FooterInfo;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FooterInfoResource extends Resource
{
    protected static ?string $model = FooterInfo::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Socials';
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-building-office';
    // heroicon-o-play-circle
    protected static ?string $recordTitleAttribute = 'SociaLinks';

    public static function form(Schema $schema): Schema
    {
        return FooterInfoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FooterInfosTable::configure($table);
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
            'index' => ManageFooterInfos::route('/'),
            'create' => CreateFooterInfo::route('/create'),
            'edit' => EditFooterInfo::route('/{record}/edit'),
        ];
    }
}
