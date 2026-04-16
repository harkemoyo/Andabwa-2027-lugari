<?php

namespace App\Filament\Resources\NavigationItems\Pages;

use App\Filament\Resources\NavigationItems\NavigationItemResource;
use Filament\Resources\Pages\CreateRecord;
use Livewire\Livewire;

class CreateNavigationItem extends CreateRecord
{
    protected static string $resource = NavigationItemResource::class;
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




