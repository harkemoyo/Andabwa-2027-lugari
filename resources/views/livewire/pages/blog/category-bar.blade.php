<div 
    class="sticky top-20 z-40 w-full bg-white/80 backdrop-blur-xl border-b border-slate-100 justify-center"
    x-data="{ open: false }"
    @click.away="open = false"
>
    <div class="max-w-4xl mx-auto px-4 md:px-10 py-3 ">

        <div class="relative w-full md:w-54">

            {{-- DROPDOWN TRIGGER --}}
            <button 
                @click="open = !open"
                class="flex items-center justify-between w-full px-5 py-3 rounded-2xl bg-white border border-slate-200 shadow-sm transition-all duration-200 hover:border-purple-300 group"
            >
                <div class="flex flex-col items-start">
                    <span class="text-[9px] text-slate-400 uppercase tracking-widest font-bold">
                        Category
                    </span>

                    <span class="text-[11px] uppercase font-black text-slate-700">
                        @if(!$activeCategory)
                            All Categories
                        @else
                            {{ $this->categories->firstWhere('id', $activeCategory)->name ?? 'Select Category' }}
                        @endif
                    </span>
                </div>

                {{-- CHEVRON --}}
                <svg 
                    class="w-4 h-4 text-slate-400 transition-transform duration-300" 
                    :class="open ? 'rotate-180' : ''"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            {{-- DROPDOWN --}}
            <div 
                x-show="open"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                x-cloak
                class="absolute left-0 mt-2 w-full bg-white border border-slate-100 rounded-2xl shadow-2xl overflow-hidden z-50 p-2 space-y-1"
            >

                {{-- ALL --}}
                <button
                    wire:click="setCategory(null)"
                    @click="open = false"
                    class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-[11px] uppercase font-black transition-all duration-200
                    {{ !$activeCategory 
                        ? 'bg-gradient-to-r from-purple-600 to-pink-600 text-white shadow-lg shadow-purple-200' 
                        : 'text-slate-500 hover:bg-slate-50' 
                    }}"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                    </svg>

                    All Categories
                </button>

                <div class="h-px bg-slate-50 mx-2 my-1"></div>

                {{-- CATEGORIES --}}
                <div class="max-h-64 overflow-y-auto">

                    @foreach($this->categories as $category)

                        @php
                            $icon = match(strtolower($category->name)) {
                                'empowerment' => 'heroicon-o-sparkles',
                                'scholarships' => 'heroicon-o-academic-cap',
                                'community support' => 'heroicon-o-users',
                                'lugari constituency' => 'heroicon-o-map-pin',
                                default => 'heroicon-o-tag',
                            };
                        @endphp

                        <button
                            wire:click="setCategory({{ $category->id }})"
                            @click="open = false"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-[11px] uppercase font-black transition-all duration-200
                            {{ $activeCategory === $category->id 
                                ? 'text-white shadow-lg scale-[1.02]' 
                                : 'text-slate-500 hover:bg-slate-50' 
                            }}"
                            @if($activeCategory === $category->id)
                                style="background: linear-gradient(135deg, {{ $category->color }}, {{ $category->color }}dd)"
                            @endif
                        >

                            {{-- ICON --}}
                            <span class="shrink-0">
                                @svg($icon, 'w-4 h-4')
                            </span>

                            {{-- NAME --}}
                            <span class="flex-1 text-left tracking-[0.18em]">
                                {{ $category->name }}
                            </span>

                            {{-- ACTIVE CHECK --}}
                            @if($activeCategory === $category->id)
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                </svg>
                            @endif

                        </button>

                    @endforeach

                </div>

            </div>
        </div>
    </div>
</div>