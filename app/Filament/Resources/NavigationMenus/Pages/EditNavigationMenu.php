<?php

namespace App\Filament\Resources\NavigationMenus\Pages;

use App\Filament\Resources\NavigationMenus\NavigationMenuResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Livewire\Livewire;

class EditNavigationMenu extends EditRecord
{
    protected static string $resource = NavigationMenuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
{
    // clear cache already done in model but double ensure
    \Illuminate\Support\Facades\Cache::forget('navigation_menus_active');

    // If broadcasting is configured:
    event(new \App\Events\MenuUpdated());

    // dispatch Livewire event — this will affect users on the same session (or works with Echo)
    Livewire::dispatch('menuUpdated');
}
}
