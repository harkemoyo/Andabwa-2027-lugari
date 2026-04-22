<?php

namespace App\Livewire\Sidebar;

use App\Models\Widget;
use Livewire\Component;
use Livewire\Attributes\On;

class RotatingWidgets extends Component
{
    public $widgets = [];

    public function mount()
    {
        $this->loadWidgets();
    }

    #[On('WidgetsUpdated')]
    #[On('echo:widgets-updates,widgets.updated')]
    public function reloadWidgets()
    {
        $this->loadWidgets();
        $this->dispatch('widgets-refreshed');
    }


   

    // Listen for Laravel Broadcasts (Echo) on the 'widgets' channel
    #[On('echo:widgets-updates,widgets.updated')]
    public function refreshWidgets()
    {
        // Re-query your updated widgets
        $this->widgets = Widget::active()->forPosition('sidebar')->get();

        // Dispatch the browser event that Alpine is listening for
        $this->dispatch('sidebar-data-updated');
    }

    

    public function loadWidgets()
    {
        $this->widgets = Widget::where('position', 'right')
            ->where('is_active', true)
            ->orderBy('order')
            ->get()
            ->map(function ($widget) {
                // Default weight to 1 if null
                $widget->weight = $widget->weight ?? 1;
                return $widget;
            });
    }

    public function render()
    {
        return view('livewire.sidebar.rotating-widgets');
    }
}
