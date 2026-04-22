<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Models\User;
use BackedEnum;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Schemas\Components\Section as ComponentsSection;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-users';

    protected static ?int $navigationSort = 1;
    protected static string | \UnitEnum | null $navigationGroup = 'Guests';


    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make('User Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->required(fn(string $context): bool => $context === 'create')
                            ->dehydrateStateUsing(fn($state) => $state ? Hash::make($state) : null)
                            ->dehydrated(fn($state) => filled($state))
                            ->rule(Password::default())
                            ->label(fn(string $context): string => $context === 'edit' ? 'New Password' : 'Password'),
                        Forms\Components\DateTimePicker::make('email_verified_at')
                            ->label('Email Verified At')
                            ->nullable(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable()
                    ->label('Email Verified'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('verified')
                    ->query(fn(Builder $query): Builder => $query->whereNotNull('email_verified_at'))
                    ->label('Verified'),
                Tables\Filters\Filter::make('unverified')
                    ->query(fn(Builder $query): Builder => $query->whereNull('email_verified_at'))
                    ->label('Unverified'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email'];
    }

    public static function canViewAny(): bool
    {
        return true; // Temporarily allow all authenticated users
    }

    public static function canCreate(): bool
    {
        return true; // Temporarily allow all authenticated users
    }

    public static function canEdit($record): bool
    {
        return true; // Temporarily allow all authenticated users
    }

    public static function canDelete($record): bool
    {
        // Prevent users from deleting themselves
        if (Auth::user()->id === $record->id) {
            return false;
        }
        return true; // Temporarily allow all authenticated users
    }

    public static function canDeleteAny(): bool
    {
        return true; // Temporarily allow all authenticated users
    }
}
