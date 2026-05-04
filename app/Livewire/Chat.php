<?php 

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;


#[Layout('layouts.app')] 
class Chat extends Component
{
    public string $room;
    public string $message = '';
    public array $messages = [];

    public function mount($room)
    {
        $this->room = $room;
    }

    public function sendMessage()
    {
        if (trim($this->message) === '') return;

        $this->messages[] = [
            'user' => Auth::user()->name ?? 'Guest',
            'text' => $this->message,
        ];

        $this->message = '';
    }

    public function render()
    {
        return view('livewire.chat');
    }
}