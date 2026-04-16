<?php

namespace App\Filament\Resources\Activities\Pages;

use App\Filament\Resources\Activities\ActivityResource;
use Filament\Resources\Pages\ListRecords;

class ListActivities extends ListRecords
{
    protected static string $resource = ActivityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // No create action for activities - they are logged automatically
        ];
    }

    public function getTitle(): string
    {
        return 'Activity Log';
    }

    protected function getHeaderWidgets(): array
    {
        return [
            // Add activity statistics widgets here if needed
        ];
    }
}
