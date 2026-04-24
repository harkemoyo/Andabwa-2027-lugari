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
                                    ->maxLength(255),
                                
                                TextInput::make('slug')
                                    ->dehydrated(false) // Don't send empty value to server
                                    ->readOnly()
                                    ->placeholder('Auto-generated on save')
                                    ->helperText('The slug is permanent once created.'),

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


// use Filament\Forms\Components\FileUpload;
// use Filament\Forms\Components\RichEditor;
// use Filament\Forms\Components\Textarea;
// use Filament\Forms\Components\TextInput;
// use Filament\Forms\Components\Toggle;
// use Filament\Schemas\Components\Group;
// use Filament\Schemas\Components\Section;
// use Filament\Schemas\Components\Utilities\Set;
// use Filament\Schemas\Schema;
// use Illuminate\Support\Str;

// class LandingPageForm
// {
//     public static function configure(Schema $schema): Schema
//     {
//         return $schema
//             ->components([
//                 Group::make()
//                     ->schema([
//                         Section::make('Page Information')
//                             ->schema([
//                                 TextInput::make('title')
//                                     ->required()
//                                     ->maxLength(255),
//                                 // THIS WAS FOR AUTOSLUG AND CAN BE EDITED(write)
//                                 //     ->live(onBlur: true)
//                                 //     ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
//                                 // //READONLY NO EDITING
//                                 TextInput::make('slug')
//                                     ->readOnly() // Prevents user editing
//                                     ->unique(ignoreRecord: true)
//                                     ->helperText('The slug is generated automatically on first save and will remain intact.'),
//                                 // THIS WAS FOR AUTOSLUG AND CAN BE EDITED(write)
//                                 //     ->required()
//                                 //     ->maxLength(255)
//                                 //     ->unique(ignoreRecord: true),

//                                 Textarea::make('subtitle')
//                                     ->maxLength(65535)
//                                     ->columnSpanFull(),
//                             ])->columns(2),

//                         Section::make('Content')
//                             ->schema([
//                                 RichEditor::make('content')
//                                     ->toolbarButtons([
//                                         'attachFiles',
//                                         'blockquote',
//                                         'bold',
//                                         'bulletList',
//                                         'h2',
//                                         'h3',
//                                         'italic',
//                                         'link',
//                                         'orderedList',
//                                         'redo',
//                                         'strike',
//                                         'undo',
//                                     ])
//                                     ->columnSpanFull(),
//                             ]),
//                     ])
//                     ->columnSpan(['lg' => 2]),

//                 Group::make()
//                     ->schema([
//                         Section::make('Status & Media')
//                             ->schema([
//                                 Toggle::make('is_active')
//                                     ->label('Active')
//                                     ->default(true)
//                                     ->helperText('Should this page be publicly visible?'),

//                                 FileUpload::make('hero_image')
//                                     ->image()
//                                     ->directory('landing-pages/hero')
//                                     ->maxSize(5120) // 5MB limit
//                                     ->columnSpanFull(),
//                             ]),

//                         Section::make('Call to Action')
//                             ->schema([
//                                 TextInput::make('cta_text')
//                                     ->label('Button Text')
//                                     ->maxLength(255),

//                                 TextInput::make('cta_link')
//                                     ->label('Button URL')
//                                     ->url()
//                                     ->maxLength(255),
//                             ]),
//                     ])
//                     ->columnSpan(['lg' => 1]),
//             ])
//             ->columns(3);
//     }
// }
