<?php 

namespace App\Livewire;

use Livewire\Component;
use App\Models\SidebarWidget;
use Livewire\Attributes\On;

class RightSidebar extends Component
{
    public $widgets = [];

    public function mount()
    {
        $this->load();
    }

    #[On('echo:sidebar,sidebar.updated')]
    public function load()
    {
        $this->widgets = SidebarWidget::where('position', 'left')
            ->where('is_active', true)
            ->orderBy('order')
            ->get();
    }

    public function render()
    {
        return view('livewire.right-sidebar');
    }
}