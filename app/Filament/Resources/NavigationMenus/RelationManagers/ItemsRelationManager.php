<?php

namespace App\Filament\Resources\NavigationMenus\RelationManagers;

use App\Filament\Resources\NavigationItems\NavigationItemResource;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn ;
use Filament\Tables\Table;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $relatedResource = NavigationItemResource::class;

    public function form(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('label')->required(),
            Textarea::make('description')->rows(2),
            TextInput::make('href'),
            TextInput::make('section_id'),
            Select::make('parent_id')
                ->label('Parent Item')
                ->relationship('menu', 'label'), // will be replaced below by a custom query
            TextInput::make('order')->numeric()->default(0),
            Toggle::make('is_active')->default(true),
        ]);
    }
    public function table(Table $table): Table
    {
         return $table->columns([
            TextColumn::make('label')->searchable()->sortable(),
            TextColumn::make('href')->limit(40),
            TextColumn::make('order')->sortable(),
        ])
        ->headerActions([CreateAction::make()])
        ->actions([EditAction::make(), DeleteAction::make()])
        ->bulkActions([DeleteBulkAction::make()]);
    }
}
