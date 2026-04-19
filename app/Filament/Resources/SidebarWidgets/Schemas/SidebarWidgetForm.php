<?php

namespace App\Filament\Resources\SidebarWidgets\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SidebarWidgetForm
{
    public static function configure(Schema $schema): Schema
{
    return $schema->components([

        TextInput::make('title') // ← also fix field name
            ->required(),

        Select::make('position')
            ->options([
                'left' => 'Left Sidebar',
                'right' => 'Right Sidebar',
            ])
            ->required(),

        Textarea::make('content')
            ->rows(5),

        Toggle::make('is_active')
            ->default(true),

        TextInput::make('order')
            ->numeric()
            ->default(0),

    ]);
}
}
