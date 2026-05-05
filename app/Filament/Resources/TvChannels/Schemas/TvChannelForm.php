<?php

namespace App\Filament\Resources\TvChannels\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class TvChannelForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('General Info')->schema([
                    TextInput::make('title')->required()->live(onBlur: true),
                    Textarea::make('description')->rows(3),
                    Select::make('type')
                        ->options(['upload' => 'Uploaded File', 'live' => 'Live Stream'])
                        ->required()
                        ->live(), // Triggers UI refresh
                ])->columns(2),

                Section::make('Media Assets')->schema([
                    // 2. Changed to SpatieMediaLibraryFileUpload
                    SpatieMediaLibraryFileUpload::make('cover_image')
                        ->image()
                        ->collection('cover_images') // 3. directory() removed to prevent another error
                        ->imageEditor(),

                    // Conditional Fields
                    // Standard FileUpload is fine here if you are just storing the URL/path directly on the model
                    FileUpload::make('audio_url')
                        ->label('Audio File')
                        ->visible(fn(Get $get) => $get('type') === 'upload'),
                        // ->required(fn(Get $get) => $get('type') === 'upload'),

                    TextInput::make('live_url')
                        ->label('Stream Link')
                        ->url()
                        ->visible(fn(Get $get) => $get('type') === 'live')
                        ->required(fn(Get $get) => $get('type') === 'live'),

                    DateTimePicker::make('scheduled_at')
                        ->label('Going Live At')
                        ->visible(fn(Get $get) => $get('type') === 'live'),
                ])->columns(2),
            ]);
    }
}
