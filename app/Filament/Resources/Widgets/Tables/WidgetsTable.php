<?php

namespace App\Filament\Resources\Widgets\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class WidgetsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                    
                BadgeColumn::make('position')
                    ->colors(['primary']),
                    
                BadgeColumn::make('type')
                    ->colors([
                        'danger' => 'ad',
                        'warning' => 'promo',
                        'success' => 'newsletter',
                    ]),

                IconColumn::make('is_active')
                    ->boolean()
                    ->sortable()
                    ->label('Active'),
                    
                TextColumn::make('weight')
                    ->sortable()
                    ->alignCenter(),

                // Analytics Cache
                TextColumn::make('impressions')
                    ->numeric()
                    ->sortable()
                    ->alignRight(),
                    
                TextColumn::make('clicks')
                    ->numeric()
                    ->sortable()
                    ->alignRight(),
            ])
            ->filters([
                SelectFilter::make('position'),
                SelectFilter::make('type'),
                SelectFilter::make('is_active')->label('Active Only'),
            ])
            ->actions([
                EditAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
