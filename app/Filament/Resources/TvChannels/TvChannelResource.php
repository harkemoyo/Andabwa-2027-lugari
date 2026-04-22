<?php

namespace App\Filament\Resources\TvChannels;

use App\Filament\Resources\TvChannels\Pages\CreateTvChannel;
use App\Filament\Resources\TvChannels\Pages\EditTvChannel;
use App\Filament\Resources\TvChannels\Pages\ListTvChannels;
use App\Filament\Resources\TvChannels\Schemas\TvChannelForm;
use App\Filament\Resources\TvChannels\Tables\TvChannelsTable;
use App\Models\TvChannels;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TvChannelResource extends Resource
{
    protected static ?string $model = TvChannels::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'TvChannels';
    protected static string | \UnitEnum | null $navigationGroup = 'Pages';


    public static function form(Schema $schema): Schema
    {
        return TvChannelForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TvChannelsTable::configure($table);
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
            'index' => ListTvChannels::route('/'),
            'create' => CreateTvChannel::route('/create'),
            'edit' => EditTvChannel::route('/{record}/edit'),
        ];
    }
}
