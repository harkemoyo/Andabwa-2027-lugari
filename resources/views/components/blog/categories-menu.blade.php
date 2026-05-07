<div 
    class="sticky top-20 z-40 w-full bg-white/80 backdrop-blur-xl border-b border-slate-100"
    x-data="{ open: false }"
    @click.away="open = false"
>
    <div class="max-w-6xl mx-auto px-4 md:px-8 py-3">
        <div class="relative w-full md:w-64">
            
            {{-- DROPDOWN TRIGGER --}}
            <button 
                @click="open = !open"
                class="flex items-center justify-between w-full px-5 py-3 rounded-2xl bg-white border border-slate-200 shadow-sm transition-all duration-200 hover:border-purple-300 group"
            >
                <div class="flex flex-col items-start">
                    <span class="text-[9px] text-slate-400 uppercase tracking-widest font-bold">Project Segment</span>
                    <span class="text-[11px] uppercase font-black text-slate-700">
                        {{-- Check request directly for the label to stay in sync with URL --}}
                        @if(!request('categoryId'))
                            All Segments
                        @else
                            {{ $this->categories->firstWhere('id', request('categoryId'))->name ?? 'Select Segment' }}
                        @endif
                    </span>
                </div>
                
                <svg class="w-4 h-4 text-slate-400 transition-transform duration-300" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            {{-- DROPDOWN MENU --}}
            <div 
                x-show="open"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-cloak
                class="absolute left-0 mt-2 w-full bg-white border border-slate-100 rounded-2xl shadow-2xl overflow-hidden z-50 p-2"
            >
                {{-- ALL SEGMENTS --}}
                <a
                    href="{{ route('blog.all-projects') }}"
                    wire:navigate.hover
                    @click="open = false"
                    class="flex items-center px-4 py-3 rounded-xl text-[11px] uppercase font-black transition-all duration-200
                    {{ !request('categoryId') 
                        ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white' 
                        : 'text-slate-500 hover:bg-purple-50 hover:text-purple-700' 
                    }}"
                >
                    All Segments
                </a>

                <div class="h-px bg-slate-50 mx-2 my-1"></div>

                {{-- CATEGORY LIST --}}
                <div class="max-h-64 overflow-y-auto scrollbar-hide space-y-1">
                    @foreach($this->categories as $category)
                        <a
                            href="{{ route('blog.all-projects', ['categoryId' => $category->id]) }}"
                            wire:navigate.hover
                            @click="open = false"
                            class="flex items-center justify-between px-4 py-3 rounded-xl text-[11px] uppercase font-black transition-all duration-200
                            {{ request('categoryId') == $category->id 
                                ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white shadow-lg shadow-purple-200' 
                                : 'text-slate-500 hover:bg-purple-50 hover:text-purple-700' 
                            }}"
                        >
                            <span>{{ $category->name }}</span>
                            @if(request('categoryId') == $category->id)
                                <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- LOADING INDICATOR (Re-added from your sidebar) --}}
    <div wire:loading.flex class="absolute bottom-0 left-0 w-full items-center justify-center gap-2 py-1 bg-white/50 border-t border-purple-100">
        <span class="relative flex h-1.5 w-1.5">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-purple-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-purple-600"></span>
        </span>
        <span class="text-[8px] font-bold uppercase tracking-widest text-purple-600">Syncing...</span>
    </div>
</div>