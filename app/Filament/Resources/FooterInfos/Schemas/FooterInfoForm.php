<?php

namespace App\Filament\Resources\FooterInfos\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FooterInfoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('company_name')->required(),
                TextInput::make('title'),
                Textarea::make('description'),
                TextInput::make('address'),
                TextInput::make('phone'),
                TextInput::make('email'),
            ]);
    }
}
