<?php

namespace App\Filament\Resources\LandingPages\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use Filament\Schemas\Components\Utilities\Set;

class LandingPageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                    ->schema([
                        Section::make('Page Information')
                            ->schema([
                                TextInput::make('title')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (Set $set, ?string $state) =>
                                        $set('slug', Str::slug($state))
                                    ),

                                TextInput::make('slug')
                                    ->readOnly()
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->helperText('Auto-generated once and remains permanent.'),

                                Textarea::make('subtitle')
                                    ->maxLength(65535)
                                    ->columnSpanFull(),
                            ])->columns(2),

                        Section::make('Content')
                            ->schema([
                                RichEditor::make('content')
                                    ->toolbarButtons([
                                        'attachFiles', 'blockquote', 'bold', 'bulletList',
                                        'h2', 'h3', 'italic', 'link', 'orderedList',
                                        'redo', 'strike', 'undo',
                                    ])
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpan(['lg' => 2]),

                Group::make()
                    ->schema([
                        Section::make('Status & Media')
                            ->schema([
                                Toggle::make('is_active')
                                    ->label('Active')
                                    ->default(true),

                                FileUpload::make('hero_image')
                                    ->image()
                                    ->directory('landing-pages/hero')
                                    ->collection('hero_images') // ✅ FIXED
                                    ->imageEditor()
                                    ->columnSpanFull(),
                            ]),

                        Section::make('Call to Action')
                            ->schema([
                                TextInput::make('cta_text')->label('Button Text'),
                                TextInput::make('cta_link')->label('Button URL')->url(),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }
}