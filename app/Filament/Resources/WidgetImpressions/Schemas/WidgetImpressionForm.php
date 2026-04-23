<?php

namespace App\Filament\Resources\WidgetImpressions\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class WidgetImpressionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('widget_id')
                    ->required()
                    ->numeric(),
                TextInput::make('session_id'),
                TextInput::make('ip'),
                DateTimePicker::make('viewed_at')
                    ->required(),
            ]);
    }
}
