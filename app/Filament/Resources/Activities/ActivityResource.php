<?php

namespace App\Filament\Resources\Activities;

use App\Filament\Resources\Activities\Pages\ListActivities;
use App\Models\Activity;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class ActivityResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-bell-alert';

    protected static ?int $navigationSort = 2;
     protected static string | \UnitEnum | null $navigationGroup = 'Trackers';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('action')
                    ->label('Action')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'created' => 'success',
                        'updated' => 'warning',
                        'deleted' => 'danger',
                        'viewed' => 'info',
                        'logged_in' => 'primary',
                        'logged_out' => 'secondary',
                        default => 'gray',
                    }),
                TextColumn::make('model_type')
                    ->label('Resource')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(fn (string $state): string => class_basename($state)),
                TextColumn::make('description')
                    ->label('Description')
                    ->searchable()
                    ->limit(50),
                TextColumn::make('created_at')
                    ->label('Time')
                    ->dateTime()
                    ->sortable()
                    ->description(fn ($record): string => $record->created_at->diffForHumans()),
            ])
            ->filters([
                SelectFilter::make('user')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('action')
                    ->options([
                        'created' => 'Created',
                        'updated' => 'Updated',
                        'deleted' => 'Deleted',
                        'viewed' => 'Viewed',
                        'logged_in' => 'Logged In',
                        'logged_out' => 'Logged Out',
                    ]),
                SelectFilter::make('model_type')
                    ->options([
                        'App\Models\User' => 'User',
                        'App\Models\Post' => 'Post',
                        'App\Models\Category' => 'Category',
                        'App\Models\NavigationMenu' => 'Navigation',
                        'App\Models\NavigationItem' => 'Navigation Item',
                    ])
                    ->label('Resource Type'),
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('60s'); // Refresh every 60 seconds
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
            'index' => ListActivities::route('/'),
        ];
    }

    public static function canViewAny(): bool
    {
        $user = Auth::user();
        
        if (!$user) {
            return false;
        }
        
        return $user->hasRole(['Super Admin', 'Admin']) || $user->hasPermissionTo('view activities');
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['action', 'description'];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('created_at', '>', now()->subHours(24))->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }
}
