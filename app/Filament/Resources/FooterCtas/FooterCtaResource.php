<?php

namespace App\Filament\Resources\FooterCtas;

use App\Filament\Resources\FooterCtas\Pages\CreateFooterCta;
use App\Filament\Resources\FooterCtas\Pages\EditFooterCta;
use App\Filament\Resources\FooterCtas\Pages\ListFooterCtas;
use App\Filament\Resources\FooterCtas\Pages\ManageFooterCtas;
use App\Filament\Resources\FooterCtas\Schemas\FooterCtaForm;
use App\Filament\Resources\FooterCtas\Tables\FooterCtasTable;
use App\Models\FooterCta;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FooterCtaResource extends Resource
{
    protected static ?string $model = FooterCta::class;

     protected static string | \UnitEnum | null $navigationGroup = 'Socials';
    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-megaphone';
// heroicon-o-play-circle
    protected static ?string $recordTitleAttribute = 'SociaLinks';

    public static function form(Schema $schema): Schema
    {
        return FooterCtaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FooterCtasTable::configure($table);
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
            // 'index' => ListFooterCtas::route('/'),
            'index' => ManageFooterCtas::route('/'),
            'create' => CreateFooterCta::route('/create'),
            'edit' => EditFooterCta::route('/{record}/edit'),
        ];
    }
}
