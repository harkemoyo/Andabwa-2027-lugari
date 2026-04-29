<?php

namespace App\Filament\Resources\Streams\Schemas;

use App\Filament\Resources\StreamResource\Pages;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class StreamForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Select::make('status')
                    ->options([
                        'scheduled' => 'Scheduled',
                        'live' => 'Live',
                        'ended' => 'Ended',
                    ])
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
            ]);
            
    }
}





