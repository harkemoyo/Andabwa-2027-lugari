 <div class="grid grid-cols-1 items-center justify-center md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($this->streams as $stream)
   
    @empty
    <div class="col-span-full p-12 text-center border-2 border-dashed rounded-xl">
        <p class="text-gray-500">No active streams at the moment.</p>
    </div>
    @endforelse

    <div class=" mx-auto py-10">
        <h1 class="text-3xl font-extrabold mb-8">Live Feed</h1>
        
         <x-blog.stream-card :stream="$stream" wire:key="stream-{{ $stream->id }}" />  
       
        
    </div>
</div>











        

        
         
       
