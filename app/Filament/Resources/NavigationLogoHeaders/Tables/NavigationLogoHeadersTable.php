<?php

namespace App\Filament\Resources\NavigationLogoHeaders\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class NavigationLogoHeadersTable
{

    public static function configure(Table $table): Table
    {
        return $table->columns([
            ImageColumn::make('full_logo_path')
                ->label('Image')
                ->circular() // or use ->square()
                ->size(50), // adjust thumbnail size

            TextColumn::make('link')
                ->label('Logo URL')
                ->url(fn($record) => $record->link, shouldOpenInNewTab: true)
                ->icon('heroicon-m-link')
        ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([]); // no bulk delete
    }
}
