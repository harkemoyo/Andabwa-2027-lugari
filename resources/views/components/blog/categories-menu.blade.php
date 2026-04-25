<div class="hidden md:block bg-white border border-1 hover:border-2 border-b border-gray-100 overflow-x-auto">
    <div class="max-w-[1400px] mx-auto px-10 h-12 flex items-center justify-between">
        <div class="flex items-center gap-6">
            @forelse($this->categories as $category)
            <a href="{{ route('blog.all-projects', ['categoryId' => $category->id]) }}"
                wire:navigate.hover
                class="text-[10px] font-black uppercase tracking-[0.2em] {{ request('categoryId') == $category->id ? 'text-red-600' : 'text-gray-400 hover:text-gray-900' }} transition-all">
               {{ $category->name }}
            </a>
            @empty
            <span class="text-gray-300 text-[10px] uppercase tracking-widest">No segments found</span>
            @endforelse
        </div>

        <div wire:loading class="flex items-center gap-2">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-90"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
            </span>
            <span class="text-[9px] font-bold uppercase tracking-widest text-red-500">Live Sync</span>
        </div>
    </div>
</div>