<?php

namespace App\Filament\Resources\FooterCtas\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class FooterCtaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')->required(),
                Textarea::make('subtitle'),
                TextInput::make('button_text'),
                TextInput::make('button_link'),
            ]);
    }
}
