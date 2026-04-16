<?php

namespace App\Filament\Resources\FooterInfos\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FooterInfosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                 TextColumn::make('company_name')->sortable(),
                TextColumn::make('email'),
                TextColumn::make('phone'),
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
