<?php

namespace App\Filament\Resources\LandingPages\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\LandingPage;
use Filament\Actions\EditAction;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Str;

class LandingPageForm
{


    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Page Header')
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn(string $operation, $state, Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),

                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true),

                        Textarea::make('subtitle')
                            ->rows(3)
                            ->columnSpanFull(),

                        FileUpload::make('hero_image')
                            ->image()
                            ->directory('landing-heroes')
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Page Content')
                    ->schema([
                        RichEditor::make('content')
                            ->required()
                            ->toolbarButtons([
                                'blockquote',
                                'bold',
                                'bulletList',
                                'h2',
                                'h3',
                                'italic',
                                'link',
                                'orderedList',
                                'redo',
                                'strike',
                                'undo',
                            ])
                            ->columnSpanFull(),
                    ]),

                Section::make('Call to Action (Optional)')
                    ->schema([
                        TextInput::make('cta_text')
                            ->placeholder('e.g., Apply Now'),
                        TextInput::make('cta_link')
                            ->placeholder('e.g., /scholarships/apply'),
                        Toggle::make('is_active')
                            ->default(true),
                    ])->columns(2),
            ]);
    }

    
}
