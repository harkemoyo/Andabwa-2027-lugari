<?php

namespace App\Filament\Resources\Posts;

use App\Filament\Resources\Posts\Pages\CreatePost;
use App\Filament\Resources\Posts\Pages\EditPost;
use App\Filament\Resources\Posts\Pages\ListPosts;
use App\Filament\Resources\Posts\Schemas\PostForm;
use App\Filament\Resources\Posts\Tables\PostsTable;
use App\Models\Post;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PostResource extends Resource
{
    


    protected static ?string $model = Post::class;
    
    protected static string | \UnitEnum | null $navigationGroup = 'Posts';

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $recordTitleAttribute = 'Blog Update';

    public static function form(Schema $schema): Schema
    {
        return PostForm::configure($schema);
    }
    

    public static function table(Table $table): Table
    {
        return PostsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPosts::route('/'),
            'create' => CreatePost::route('/create'),
            'edit' => EditPost::route('/{record}/edit'),
        ];
    }

    protected static function afterCreate(): void
    {
        // Dispatch Livewire event for real-time updates
        \Livewire\Livewire::dispatch('post-updated');
    }

    protected static function afterUpdate(): void
    {
        // Dispatch Livewire event for real-time updates
        \Livewire\Livewire::dispatch('post-updated');
    }
}
