<?php

namespace App\Filament\Resources\NavigationItems\Schemas;

use App\Models\NavigationItem;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;
use Filament\Schemas\Components\Section as ComponentsSection;
use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Components\Utilities\Get;

class NavigationItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('menu_id')
                ->label('Menu')
                ->relationship('menu', 'name')
                ->required()
                ->hint('Choose which menu this link belongs to.'),

            Select::make('parent_id')
                ->label('Parent Item')
                ->options(
                    fn(callable $get) =>
                    NavigationItem::where('menu_id', $get('menu_id'))
                        ->get()
                        ->mapWithKeys(fn($item) => [$item->id => $item->label ?? "Untitled #{$item->id}"])
                        ->toArray()
                )
                ->searchable()
                ->nullable()
                ->hint('Optional: nest this under another item.'),


            // Label input (auto slug generator)
            TextInput::make('label')
                ->label('Link Name')
                ->placeholder('e.g., About Us')
                ->required()
                ->live(onBlur: true)
                ->afterStateUpdated(
                    fn($state, callable $set) =>
                    $set('slug', Str::slug($state))
                ),

            // Slug (auto-generated but editable)
            TextInput::make('slug')
                ->label('Slug')
                ->placeholder('e.g., about-us')
                ->helperText('Automatically generated from label; can be edited.')
                ->unique(ignoreRecord: true),

            // URL input
            TextInput::make('url')
                ->label('Link URL')
                ->placeholder('https:// or /about')
                ->hint('Absolute or relative link.'),
            
                // Visibility
            Toggle::make('is_active')
                ->label('Visible on site')
                ->default(true),

            // Inside your form schema Breakng:
            // Toggle::make('is_breaking')
            //     ->label('Breaking News')
            //     ->reactive(),

            // Toggle::make('is_live')
            //     ->label('Currently LIVE')
            //     ->helperText('Adds a pulsing red indicator next to the headline.')
            //     ->hidden(fn(Get $get) => ! $get('is_breaking')),

            // DateTimePicker::make('expires_at')
            //     ->label('Auto-Expire At')
            //     ->helperText('When should this stop being breaking news? Leave blank to keep indefinitely.'),

            // TextInput::make('ai_score')
            //     ->label('Priority Score')
            //     ->numeric()
            //     ->default(0)
            //     ->helperText('Higher numbers appear first. (Can be automated via AI)'),

            // Advanced fields grouped
            Group::make()
                ->schema([
                    TextInput::make('order')
                        ->numeric()
                        ->default(0)
                        ->label('Order')
                        ->hint('Lower numbers appear first.'),

                    TextInput::make('target')
                        ->label('Open Link In')
                        ->placeholder('_self or _blank')
                        ->hint('Leave empty for normal behavior.'),
                ])->columns(2),

            // // 🔥 Breaking News CMS
            // ComponentsSection::make('Breaking News Content')->schema([
            //     TextInput::make('breaking'),
            //     TextInput::make('link_url'),
            //     TextInput::make('elite'),
            //     TextInput::make('live'),
            //     TextInput::make('experience'),
            // ])->collapsed(),
        ]);
    }
}

