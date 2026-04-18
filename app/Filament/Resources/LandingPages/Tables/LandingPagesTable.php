<?php

namespace App\Filament\Resources\LandingPages\Tables;


use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LandingPagesTable
{
    public static function configure(Table $table): Table
    {
        

        return $table
            ->columns([
                ImageColumn::make('hero_image'),
                TextColumn::make('title')->searchable(),
                TextColumn::make('slug'),
                IconColumn::make('is_active')->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
            ]);
            
            
            // ->recordActions([
            //     EditAction::make(),
            // ])
            // ->toolbarActions([
            //     BulkActionGroup::make([
            //         DeleteBulkAction::make(),
            //     ]),
            // ]);
    }
}
