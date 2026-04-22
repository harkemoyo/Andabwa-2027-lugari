<?php

namespace App\Filament\Resources\RadioChannels;

use App\Filament\Resources\RadioChannels\Pages\CreateRadioChannel;
use App\Filament\Resources\RadioChannels\Pages\EditRadioChannel;
use App\Filament\Resources\RadioChannels\Pages\ListRadioChannels;
use App\Filament\Resources\RadioChannels\Schemas\RadioChannelForm;
use App\Filament\Resources\RadioChannels\Tables\RadioChannelsTable;
use App\Models\RadioChannel;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RadioChannelResource extends Resource
{
    protected static ?string $model = RadioChannel::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'RadioChannels';

    public static function form(Schema $schema): Schema
    {
        return RadioChannelForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RadioChannelsTable::configure($table);
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
            'index' => ListRadioChannels::route('/'),
            'create' => CreateRadioChannel::route('/create'),
            'edit' => EditRadioChannel::route('/{record}/edit'),
        ];
    }
}
