<?php

namespace App\Filament\Resources\WidgetImpressions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\Summarizers\Count;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class WidgetImpressionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('widget_id')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('viewed_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('ip')
                    ->label('IP Address'),
                // Aggregate Column
                TextColumn::make('id')
                    ->label('Total Impressions')
                    ->summarize(Count::make())
            ])
            ->filters([
                SelectFilter::make('widget_id')
                    ->options([
                        'sidebar_ad' => 'Sidebar Ad',
                        'footer_news' => 'Footer News',
                    ]),
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
