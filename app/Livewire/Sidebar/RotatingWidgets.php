<?php

namespace App\Livewire\Sidebar;


use App\Models\Widget;
use Livewire\Component;
use Livewire\Attributes\On;

class RotatingWidgets extends Component
{
    public $widgets = [];
    
    // Default to 'right' position, but allows flexibility if called via <livewire:sidebar.rotating-widgets position="sidebar" />
    public string $position = 'right'; 

    public function mount(string $position = 'right')
    {
        $this->position = $position;
        $this->loadWidgets();
    }

    // Consolidated Listeners into a single, clean method
    #[On('WidgetsUpdated')]
    #[On('echo:widgets-updates,widgets.updated')]
    public function refreshWidgets()
    {
        $this->loadWidgets();
        
        // Dispatch event exactly as Alpine expects it in the Blade file
        $this->dispatch('sidebar-data-updated');
    }

    public function loadWidgets()
    {
        // Now dynamically queries based on the component's assigned position
        $this->widgets = Widget::active()
            ->forPosition($this->position) 
            ->orderBy('order')
            ->get()
            ->map(function ($widget) {
                // Ensure weight is never null to prevent Alpine.js math errors
                $widget->weight = $widget->weight ?? 1;
                return $widget;
            });
    }

    public function render()
    {
        return view('livewire.sidebar.rotating-widgets');
    }
}