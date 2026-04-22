<?php

namespace App\Filament\Resources\LiveEvents;

use App\Filament\Resources\LiveEvents\Pages\CreateLiveEvent;
use App\Filament\Resources\LiveEvents\Pages\EditLiveEvent;
use App\Filament\Resources\LiveEvents\Pages\ListLiveEvents;
use App\Filament\Resources\LiveEvents\Schemas\LiveEventForm;
use App\Filament\Resources\LiveEvents\Tables\LiveEventsTable;
use App\Models\LiveEvents;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LiveEventResource extends Resource
{
    protected static ?string $model = LiveEvents::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'LiveEvents';
    protected static string | \UnitEnum | null $navigationGroup = 'Pages';


    public static function form(Schema $schema): Schema
    {
        return LiveEventForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LiveEventsTable::configure($table);
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
            'index' => ListLiveEvents::route('/'),
            'create' => CreateLiveEvent::route('/create'),
            'edit' => EditLiveEvent::route('/{record}/edit'),
        ];
    }
}
