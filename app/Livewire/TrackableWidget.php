<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\WidgetImpression;

class TrackableWidget extends Component
{
    public $widgetId;
    public $hasTracked = false;

    public function track()
    {
        if ($this->hasTracked) return;

        WidgetImpression::record($this->widgetId);
        $this->hasTracked = true;
    }

    public function render()
    {
        return <<<'HTML'
            <div x-intersect.once="$wire.track()">
                <div class="p-4 bg-white shadow rounded">
                    Widget: {{ $widgetId }}
                </div>
            </div>
        HTML;
    }
}