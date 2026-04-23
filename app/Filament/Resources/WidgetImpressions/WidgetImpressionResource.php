<?php

namespace App\Filament\Resources\WidgetImpressions;

use App\Filament\Resources\WidgetImpressions\Pages\CreateWidgetImpression;
use App\Filament\Resources\WidgetImpressions\Pages\EditWidgetImpression;
use App\Filament\Resources\WidgetImpressions\Pages\ListWidgetImpressions;
use App\Filament\Resources\WidgetImpressions\Schemas\WidgetImpressionForm;
use App\Filament\Resources\WidgetImpressions\Tables\WidgetImpressionsTable;
use App\Models\WidgetImpression;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class WidgetImpressionResource extends Resource
{
    protected static ?string $model = WidgetImpression::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $label = 'WidgetImpression';
    protected static string | \UnitEnum | null $navigationGroup = 'Ad Engine';
    protected static ?string $recordTitleAttribute = 'WidgetImpression';

    public static function form(Schema $schema): Schema
    {
        return WidgetImpressionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return WidgetImpressionsTable::configure($table);
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
            'index' => ListWidgetImpressions::route('/'),
            'create' => CreateWidgetImpression::route('/create'),
            'edit' => EditWidgetImpression::route('/{record}/edit'),
        ];
    }
}
