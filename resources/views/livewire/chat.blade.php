<div class="flex flex-col h-full">
    
    <!-- Messages -->
    <div class="flex-1 overflow-y-auto space-y-2 mb-3">
        @foreach($messages as $msg)
            <div class="bg-gray-800 p-2 rounded">
                <strong>{{ $msg['user'] }}:</strong>
                <span>{{ $msg['text'] }}</span>
            </div>
        @endforeach
    </div>

    <!-- Input -->
    <div class="flex gap-2">
        <input 
            type="text" 
            wire:model="message"
            wire:keydown.enter="sendMessage"
            class="flex-1 p-2 rounded text-white"
            placeholder="Type message..."
        >

        <button 
            wire:click="sendMessage"
            class="bg-white px-3 rounded text-black">
            Send
        </button>
    </div>

</div>