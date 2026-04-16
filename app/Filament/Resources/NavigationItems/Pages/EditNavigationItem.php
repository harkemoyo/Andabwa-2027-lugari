<?php

namespace App\Filament\Resources\NavigationItems\Pages;

use App\Filament\Resources\NavigationItems\NavigationItemResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Livewire\Livewire;

class EditNavigationItem extends EditRecord
{
    protected static string $resource = NavigationItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
{
    event(new \App\Events\MenuUpdated());

    // Emits a Livewire event that other components can listen for
    $this->dispatch('menuUpdated');
}

}
