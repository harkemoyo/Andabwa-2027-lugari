<?php

namespace App\Filament\Resources\Widgets\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class WidgetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Section::make('Core Setup')
                            ->schema([
                                TextInput::make('title')
                                    ->required()
                                    ->maxLength(255),
                                    TextInput::make('room_name')
                                    ->required()
                                    ->maxLength(255),

                                TextInput::make('url')
                                    ->label('Target URL')
                                    ->url()
                                    ->maxLength(255),

                                // Replace: use Filament\Forms\Components\FileUpload;
                                // Inside Section::make('Core Setup')
                                SpatieMediaLibraryFileUpload::make('widget_image')
                                    ->collection('widget_images')
                                    ->disk('public')
                                    ->maxSize(10240)
                                    ->multiple(false)
                                    ->reorderable(false)
                                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                    ->columnSpanFull(),

                                RichEditor::make('content')
                                    ->required()
                                    ->columnSpanFull()
                                    ->helperText('HTML and inline styles are supported.'),
                            ])->columns(2),

                        Section::make('Ad Engine Features')
                            ->schema([
                                TextInput::make('weight')
                                    ->numeric()
                                    ->default(1)
                                    ->minValue(1)
                                    ->helperText('Higher weight = higher rotation priority.'),

                                TextInput::make('variant')
                                    ->maxLength(255)
                                    ->helperText('e.g., A or B for split testing.'),

                                TextInput::make('order')
                                    ->numeric()
                                    ->default(0),
                            ])->columns(3),
                    ])
                    ->columnSpan(['lg' => 2]),

                Group::make()
                    ->schema([
                        Section::make('Control')
                            ->schema([
                                Toggle::make('is_active')
                                    ->label('Widget Active')
                                    ->default(true),

                                Select::make('position')
                                    ->options([
                                        'sidebar' => 'Sidebar',
                                        'header' => 'Header',
                                        'footer' => 'Footer',
                                        'in_article' => 'In Article',
                                    ])
                                    ->required()
                                    ->default('sidebar'),

                                Select::make('type')
                                    ->options([
                                        'ad' => 'Advertisement',
                                        'promo' => 'Internal Promo',
                                        'newsletter' => 'Newsletter',
                                    ])
                                    ->required()
                                    ->default('ad'),
                            ]),

                        Section::make('Scheduling')
                            ->schema([
                                DateTimePicker::make('starts_at')
                                    ->label('Start Date (Optional)'),

                                DateTimePicker::make('ends_at')
                                    ->label('End Date (Optional)')
                                    ->afterOrEqual('starts_at'),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }
}
