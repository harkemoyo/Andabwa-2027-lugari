<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Enums\MediaType;
use App\Services\LinkPreviewService;
use Filament\Actions\Action;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ViewField;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Group::make()
                ->schema([
                    static::getGeneralSection(),
                    static::getMediaSection(),
                ])
                ->columnSpan(['lg' => 2]),

            Group::make()
                ->schema([
                    static::getPublishingSection(),
                    static::getTaxonomySection(),
                    static::getSeoSection(),
                ])
                ->columnSpan(['lg' => 1]),
        ])->columns(3);
    }

    /**
     * Main Title and Content
     */
    protected static function getGeneralSection(): Section
    {
        return Section::make('Article Content')
            ->description('Write the main post content.')
            ->schema([
                TextInput::make('title')
                    ->label('Post Title')
                    ->placeholder('Enter post title...')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state))),

                TextInput::make('slug')
                    ->label('Slug (URL)')
                    ->disabled()
                    ->dehydrated()
                    ->required()
                    ->unique('posts', 'slug', ignoreRecord: true)
                    ->helperText('Auto-generated from the title.'),

                RichEditor::make('content')
                    ->label('Post Body')
                    ->required()
                    ->columnSpanFull()
                    ->toolbarButtons([
                        'bold',
                        'italic',
                        'strike',
                        'link',
                        'bulletList',
                        'orderedList',
                        'h2',
                        'h3',
                        'blockquote',
                        'codeBlock',
                    ]),
            ]);
    }

    /**
     * Dynamic Media Section (Spatie + External)
     */
    protected static function getMediaSection(): Section
    {
        return Section::make('Featured Media')
            ->description('Attach media or external content.')
            ->collapsible()
            ->schema([
                Select::make('media_type')
                    ->label('Media Type')
                    ->options(MediaType::class)
                    ->default(MediaType::Article)
                    ->required()
                    ->native(false)
                    ->live()
                    ->afterStateUpdated(function (Set $set) {
                        $set('external_url', null);
                        $set('link_preview_data', null);
                    }),

                SpatieMediaLibraryFileUpload::make('featured') // match your collection name!
                    ->collection('featured')
                    ->disk('public')        // save to public disk
                    ->maxSize(5120)         // 5MB for videos
                    ->acceptedFileTypes([
                        'image/jpeg',
                        'image/png',
                        'image/webp',
                        'video/mp4',
                        'video/quicktime',
                    ])
                    ->imagePreviewHeight('250')
                    ->loadingIndicatorPosition('left')
                    ->panelAspectRatio('2:1')
                    ->panelLayout('integrated')
                    ->removeUploadedFileButtonPosition('right')
                    ->uploadButtonPosition('left')
                    ->uploadProgressIndicatorPosition('left')
                    ->visible(fn(Get $get) => MediaType::isUploadable($get('media_type')))
                    ->columnSpanFull(),

                

                TextInput::make('external_url')
                    ->label('External URL')
                    ->placeholder('https://youtube.com/... or article link')
                    ->url()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Set $set, ?string $state) {
                        if (blank($state)) {
                            $set('link_preview_data', null);
                            return;
                        }
                        try {
                            $data = app(LinkPreviewService::class)->extract($state);
                            $set('link_preview_data', $data);
                        } catch (\Throwable $e) {
                            report($e);
                            $set('link_preview_data', null);
                        }
                    })
                    ->visible(fn(Get $get) => MediaType::isExternal($get('media_type')))
                    ->suffixAction(
                        Action::make('extractMetadata')
                            ->label('Preview')
                            ->icon('heroicon-m-sparkles')
                            ->action(function (Get $get, Set $set, ?string $state) {
                                if (blank($state)) return;
                                try {
                                    $data = app(LinkPreviewService::class)->extract($state);
                                    $set('link_preview_data', $data);
                                } catch (\Throwable $e) {
                                    report($e);
                                }
                            })
                    )
                    ->columnSpanFull(),

                ViewField::make('link_preview_data')
                    ->view('filament.components.link-preview')
                    ->visible(
                        fn(Get $get) =>
                        MediaType::isExternal($get('media_type')) && filled($get('external_url'))
                    )
                    ->columnSpanFull(),
            ]);
    }

    /**
     * Sidebar: Status Toggles
     */
    protected static function getPublishingSection(): Section
    {
        return Section::make('Publishing Settings')
            ->schema([
                Toggle::make('is_published')
                    ->label('Publish Post')
                    ->default(true)
                    ->onColor('success'),

                Toggle::make('is_featured')
                    ->label('Feature on Homepage')
                    ->helperText('Appears in the hero section.')
                    ->onIcon('heroicon-m-star')
                    ->offIcon('heroicon-m-x-mark')
                    ->onColor('warning'),
            ]);
    }

    /**
     * Sidebar: Relations
     */
    protected static function getTaxonomySection(): Section
    {
        return Section::make('Taxonomy')
            ->schema([
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('tags')
                    ->multiple()
                    ->relationship('tags', 'name')
                    ->searchable()
                    ->preload(),
            ]);
    }

    /**
     * Sidebar: SEO
     */
    protected static function getSeoSection(): Section
    {
        return Section::make('SEO & Metadata')
            ->collapsible()
            ->collapsed()
            ->schema([
                TextInput::make('meta_title')
                    ->maxLength(60)
                    ->helperText('Recommended: 50–60 characters'),

                TextInput::make('meta_description')
                    ->maxLength(160)
                    ->helperText('Recommended: 150–160 characters'),
            ]);
    }
}
