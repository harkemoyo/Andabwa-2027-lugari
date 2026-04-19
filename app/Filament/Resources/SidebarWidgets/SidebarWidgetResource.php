<?php

namespace App\Filament\Resources\SidebarWidgets;

use App\Filament\Resources\SidebarWidgets\Pages\CreateSidebarWidget;
use App\Filament\Resources\SidebarWidgets\Pages\EditSidebarWidget;
use App\Filament\Resources\SidebarWidgets\Pages\ListSidebarWidgets;
use App\Filament\Resources\SidebarWidgets\Schemas\SidebarWidgetForm;
use App\Filament\Resources\SidebarWidgets\Tables\SidebarWidgetsTable;
use App\Models\SidebarWidget;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SidebarWidgetResource extends Resource
{
    protected static ?string $model = SidebarWidget::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'SidebarWidget';

    public static function form(Schema $schema): Schema
    {
        return SidebarWidgetForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SidebarWidgetsTable::configure($table);
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
            'index' => ListSidebarWidgets::route('/'),
            'create' => CreateSidebarWidget::route('/create'),
            'edit' => EditSidebarWidget::route('/{record}/edit'),
        ];
    }
}
