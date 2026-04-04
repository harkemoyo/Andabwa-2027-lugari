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
                    ->default(MediaType::Image)
                    ->required()
                    ->native(false)
                    ->live()
                    ->afterStateUpdated(function (Set $set, $state) {
                        // Clear all media-related fields when type changes
                        $set('external_url', null);
                        $set('link_preview_data', null);
                        
                        // Log media type change for debugging
                        logger('PostForm: Media type changed to: ' . $state);
                    }),

                SpatieMediaLibraryFileUpload::make('featured')
                    ->label('Upload Media')
                    ->collection('featured')
                    ->disk('public')
                    ->maxSize(51200) // 50MB for production
                    ->acceptedFileTypes([
                        'image/jpeg',
                        'image/png', 
                        'image/webp',
                        'image/gif',
                        'video/mp4',
                        'video/quicktime',
                        'video/webm',
                        'video/avi',
                        'video/mov',
                    ])
                    ->imagePreviewHeight('300')
                    ->loadingIndicatorPosition('left')
                    ->panelAspectRatio('16:9')
                    ->panelLayout('integrated')
                    ->removeUploadedFileButtonPosition('right')
                    ->uploadButtonPosition('left')
                    ->uploadProgressIndicatorPosition('left')
                    ->reorderable()
                    ->appendFiles()
                    ->preserveFilenames()
                    ->multiple(false) // Single featured media
                    ->enableReordering()
                    ->enableDownload()
                    ->enableOpen()
                    ->visible(fn (Get $get, $record) => 
                        MediaType::isUploadable($get('media_type')) || 
                        ($record && $record->hasMedia('featured'))
                    )
                    ->live()
                    ->afterStateUpdated(function (Set $set, $state, Get $get, $record) {
                        // Log media upload for debugging
                        logger('PostForm: Media uploaded - Type: ' . $get('media_type')?->value . ', State: ' . ($state ? 'has files' : 'empty'));
                    })
                    ->helperText(fn (Get $get) => match($get('media_type')) {
                        'image' => 'Upload high-quality images (JPG, PNG, WebP). Recommended size: 1920x1080px.',
                        'local_video' => 'Upload MP4 videos. Max size: 50MB. Recommended format: H.264.',
                        default => 'Select a media type to see upload requirements.'
                    })
                    ->columnSpanFull(),

                // Media Preview Component
                ViewField::make('media_preview')
                    ->label('Current Media')
                    ->view('filament.components.media-preview')
                    ->live()
                    ->dehydrated(false)
                    ->visible(fn (Get $get, $record) => 
                        ($record && $record->hasMedia('featured')) || 
                        filled($get('featured'))
                    )
                    ->columnSpanFull(),

                TextInput::make('external_url')
                    ->label('External URL')
                    ->placeholder('https://youtube.com/watch?v=... or article link')
                    ->url()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Set $set, ?string $state, Get $get) {
                        if (blank($state)) {
                            $set('link_preview_data', null);
                            logger('PostForm: External URL cleared');
                            return;
                        }
                        
                        try {
                            logger('PostForm: Extracting preview for URL: ' . $state);
                            $data = app(LinkPreviewService::class)->extract($state);
                            $set('link_preview_data', $data);
                            logger('PostForm: Preview extracted successfully - Type: ' . ($data['type'] ?? 'unknown'));
                        } catch (\Throwable $e) {
                            logger('PostForm: Preview extraction failed - ' . $e->getMessage());
                            report($e);
                            $set('link_preview_data', null);
                        }
                    })
                    ->visible(fn(Get $get) => MediaType::isExternal($get('media_type')))
                    ->suffixAction(
                        Action::make('extractMetadata')
                            ->label('Preview')
                            ->icon('heroicon-m-sparkles')
                            ->color('primary')
                            ->action(function (Get $get, Set $set, ?string $state) {
                                if (blank($state)) return;
                                
                                try {
                                    logger('PostForm: Manual preview extraction for: ' . $state);
                                    $data = app(LinkPreviewService::class)->extract($state);
                                    $set('link_preview_data', $data);
                                    
                                    // Show success notification
                                    $set('preview_success', true);
                                    // Note: In Filament, temporary state clearing should be handled on the frontend
                                    // Consider using Filament's notification system instead
                                } catch (\Throwable $e) {
                                    logger('PostForm: Manual preview failed - ' . $e->getMessage());
                                    report($e);
                                    $set('preview_error', $e->getMessage());
                                    // Note: In Filament, temporary state clearing should be handled on the frontend
                                    // Consider using Filament's notification system instead
                                }
                            })
                    )
                    ->helperText('Enter YouTube, Vimeo, or article URLs. Preview will be generated automatically.')
                    ->columnSpanFull(),

                // External Link Preview Component
                ViewField::make('link_preview_data')
                    ->label('External Content Preview')
                    ->view('filament.components.link-preview')
                    ->visible(
                        fn(Get $get) =>
                        MediaType::isExternal($get('media_type')) && 
                        filled($get('external_url')) && 
                        filled($get('link_preview_data'))
                    )
                    ->columnSpanFull(),

                // Hidden field for triggering updates
                TextInput::make('media_preview_updated')
                    ->hidden()
                    ->dehydrated(false),
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
