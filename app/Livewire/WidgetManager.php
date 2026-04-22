<?php

namespace App\Livewire;

use App\Events\WidgetsUpdated;
use Livewire\Component;
use App\Models\Widget;

class WidgetManager extends Component
{
    public $widgets;
    public $editingId = null;

    public $title, $position, $type, $content, $url, $weight, $is_active, $order;

    public function mount()
    {
        $this->loadWidgets();
    }

    public function loadWidgets()
    {
        $this->widgets = Widget::orderBy('order')->get();
    }

    public function edit($id)
    {
        $widget = Widget::findOrFail($id);

        $this->editingId = $id;
        $this->title = $widget->title;
        $this->position = $widget->position;
        $this->type = $widget->type;
        $this->content = $widget->content;
        $this->url = $widget->url;
        $this->weight = $widget->weight;
        $this->is_active = $widget->is_active;
        $this->order = $widget->order;
    }

    public function update()
    {
        $this->validate([
            'title' => 'required',
            'position' => 'required',
            'type' => 'required',
        ]);

        Widget::updateOrCreate(
            ['id' => $this->editingId],
            [
                'title' => $this->title,
                'position' => $this->position,
                'type' => $this->type,
                'content' => $this->content,
                'url' => $this->url,
                'weight' => $this->weight,
                'is_active' => $this->is_active,
                'order' => $this->order,
            ]
        );
event(new WidgetsUpdated());
        
        $this->resetForm();
        $this->loadWidgets();
    }

    public function create()
    {
        $this->resetForm();
        $this->editingId = null;
    }

    public function delete($id)
    {
        Widget::find($id)?->delete();
        event(new WidgetsUpdated());
        $this->loadWidgets();
    }

    public function resetForm()
    {
        $this->reset([
            'title',
            'position',
            'type',
            'content',
            'url',
            'weight',
            'is_active',
            'order',
            'editingId'
        ]);
    }

    public function render()
    {
        return view('livewire.widget-manager');
    }
}