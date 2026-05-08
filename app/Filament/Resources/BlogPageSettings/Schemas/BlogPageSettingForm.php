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
                        TextInput::make('header_subtitle')
                            ->label('Trending Title')
                            ->placeholder('Enter trending title...')
                            ->required(),
                        TextInput::make('header_emoji'),
                        TextInput::make('search_title')->required(),
                        Textarea::make('header_description')->rows(3)
                         ->label('Featured Priority Updates title')
                            ->placeholder('Enter Priority Updates title...')
                            ->required(),
                    ])->columns(2),

                Section::make('Section Headings')
                    ->schema([
                        TextInput::make('featured_title')
                        ->label('Featured Title')
                            ->placeholder('Enter Featured title ...')
                            ->required(),
                        Textarea::make('featured_description')
                            ->rows(2)
                            ->label('Featured Description')
                            ->placeholder('Enter Featured Description ...')
                            ->required(),
                        TextInput::make('latest_title')
                            ->label('Latest Description')
                            ->placeholder('Enter latest description...')
                            ->required(),
                        
                        TextInput::make('header_title')
                            ->label('Latest Happenings title')
                            ->placeholder('Enter Happening Now title ...')
                            ->required(),
                            TextInput::make('view_all_button')->required(),
                        TextInput::make('view_all_button')->required(),
                        Textarea::make('editorial_button_text')->required(),
                        Textarea::make('featured_insight_text')->required(),
                        Textarea::make('share')->required(),

                    ])->columns(2),
            ]);
    }
}
