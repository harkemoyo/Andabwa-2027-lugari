<?php

namespace App\Filament\Resources\BlogPageSettings\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BlogPageSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
               Section::make('Main Header')
                    ->schema([
                        TextInput::make('header_subtitle')->required(),
                        TextInput::make('header_title')->required(),
                        TextInput::make('header_emoji'),
                        TextInput::make('search_title')->required(),
                        Textarea::make('header_description')->rows(3)->required(),
                    ])->columns(2),

                Section::make('Section Headings')
                    ->schema([
                        TextInput::make('featured_title')->required(),
                        Textarea::make('featured_description')->rows(2)->required(),
                        TextInput::make('latest_title')->required(),
                        Textarea::make('latest_description')->rows(2)->required(),
                        Textarea::make('editorial_button_text')->required(),
                        Textarea::make('featured_insight_text')->required(),
                        Textarea::make('share')->required(),
                        
                    ])->columns(2),
            ]);
    }
}
