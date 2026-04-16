<?php

namespace App\Filament\Resources\NavigationMenus\Schemas;

use App\Models\NavigationMenu;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class NavigationMenuForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->required(),
                TextInput::make('slug')->required()->unique(NavigationMenu::class, 'slug', ignoreRecord: true),
                TextInput::make('order')->numeric()->default(0),
                Toggle::make('is_active')->default(true),
            ]);
    }
}