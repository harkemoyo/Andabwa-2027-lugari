<?php

namespace App\Filament\Resources\SocialLinks\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SocialLinksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('full_image_path')
                    ->label('Image')
                    ->circular() // or use ->square()
                    ->size(50) // adjust thumbnail size
                    ->defaultImageUrl(url('/images/default-social.png')),
                TextColumn::make('platform_name'),
                TextColumn::make('url')->limit(30),
                IconColumn::make('is_active')->boolean(),
                TextColumn::make('order')->sortable(),
            ])
            ->reorderable('order')
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
