<div wire:key="navbar-root"
    x-data="{ mobileOpen: false }"
    @keydown.escape="mobileOpen = false"
    class="sticky top-0 z-50">
    {{-- 1. BREAKING NEWS TICKER (Optimized) --}}
    @if($this->hasBreaking())
    <div wire:key="breaking-ticker"
        x-data
        class="bg-red-600 text-white text-sm font-semibold flex items-center overflow-hidden border-b border-black/10">

        {{-- Static Label --}}
        <div class="px-4 py-2 bg-white uppercase tracking-wider shrink-0 shadow-lg z-10">
            <p class="text-red-600 flex items-center gap-2">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-red-600"></span>
                </span>
                Breaking
            </p>
        </div>

        {{-- Scrolling Area --}}
        <div class="flex-1 overflow-hidden whitespace-nowrap">
            <div class="flex animate-ticker hover:[animation-play-state:paused] w-max">
                {{-- Loop through the repeated template --}}
                <template x-for="i in 10" :key="i">
                    <div class="flex items-center gap-8 px-4">
                        @foreach ($breakingItems as $item)
                        <div class="flex items-center gap-2" wire:key="breaking-{{ $item->id }}">
                            <button class="py-3 px-1.5">
                                <span class="text-white-300 text-md opacity-70 py-2 px-1.5">•LIVE</span>
                            </button>

                            {{-- Updated Link Logic --}}
                            <a href="{{ $item->url }}"
                                {{-- In the <a> tag --}}
                                target="{{ str_starts_with($item->url, config('app.url')) ? '_self' : '_blank' }}"
                                rel="noopener noreferrer"
                                class="hover:text-yellow-300 transition-colors uppercase tracking-tight decoration-none">
                                {{ $item->label ?? $item->title }}
                            </a>
                        </div>
                        @endforeach
                    </div>
                </template>

            </div>
        </div>
    </div>
    @endif



    {{-- 2. MAIN NAVIGATION --}}
    <nav class="p-3 backdrop-blur-xl bg-gradient-to-r from-purple-600 via-pink-500 to-red-500 border-b border-white/10 shadow-md">
        <div class="max-w-[1400px] mx-auto px-4 flex items-center justify-between h-16">

            {{-- LOGO --}}
            <livewire:navigation-logo-header-component />

            {{-- DESKTOP NAV (Hidden on Mobile) --}}
            <div class="hidden md:flex items-center gap-8 text-sm font-medium text-white/90">
                @foreach ($menus as $menu)
                @foreach ($menu->items as $index => $item)
                <div class="relative group" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                    <button class="px-1 py-2 hover:text-white transition">
                        {{ $item->title }}
                    </button>

                    @if ($item->children->count())
                    <div
                        x-show="open"
                        x-transition.opacity.duration.150ms x-cloak
                        class="absolute left-0 top-full mt-2 w-64 bg-white text-gray-800 rounded-xl shadow-2xl p-4 grid gap-2">
                        @foreach ($item->children = collect($payload['children'] ?? [])->where('is_active', true) as $child)
                        <a href="{{ $child->url ?? url($child->slug) }}" class="block p-2 rounded-lg hover:bg-gray-50 text-sm font-semibold">
                            {{ $child->title }}
                        </a>
                        @endforeach
                    </div>
                    @endif
                </div>
                @endforeach
                @endforeach
            </div>

            {{-- RIGHT SECTION --}}
            <div class="flex items-center gap-4">
                {{-- Search (Desktop) --}}
                <div class="hidden md:block">
                    <input type="text" placeholder="Search..." class="px-4 py-2 text-sm rounded-full bg-white/20 text-white placeholder-white/70 border-none focus:ring-2 focus:ring-white/50">
                </div>

                @auth
                @else
                <button @click="$dispatch('login-modal')" class="px-5 py-2 bg-white text-gray-900 rounded-full text-sm font-bold hover:bg-gray-100 transition shadow-lg">
                    Sign In
                </button>
                @endauth

                {{-- MOBILE HAMBURGER --}}
                <button x-data="{ mobileOpen: false }" class="md:hidden p-2 text-white text-2xl">
                    <span x-show="!mobileOpen">☰</span>
                    <span x-show="mobileOpen">✕</span>
                </button>
            </div>
        </div>
    </nav>

    {{-- 3. UNIFIED MOBILE MENU (THE FIX) --}}
    <div x-show="mobileOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-cloak
        class="md:hidden absolute top-full left-0 w-full bg-white shadow-2xl border-t border-gray-100 max-h-[80vh] overflow-y-auto">

        <div class="p-4 space-y-2">
            {{-- Mobile Search --}}
            <div class="pb-4">
                <input type="text" placeholder="Search news..." class="w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50">
            </div>

            {{-- Menu Items --}}
            @foreach ($menus as $menu)
            @foreach ($menu->items as $item)
            <div x-data="{ expanded: false }" class="border-b border-gray-50 last:border-none">
                <button @click="expanded = !expanded"
                    class="w-full flex justify-between items-center py-3 text-gray-800 font-bold">
                    {{ $item->title }}
                    <span :class="expanded ? 'rotate-180' : ''" class="transition-transform duration-200 text-gray-400">⌄</span>
                </button>

                @if ($item->children->count())
                <div x-show="expanded" x-collapse x-cloak class="pl-4 pb-3 space-y-1">
                    @foreach ($item->children->where('is_active', true) as $child)
                    <a href="{{ $child->url ?? url($child->slug) }}"
                        class="block py-2 text-gray-600 text-sm hover:text-red-600 transition">
                        {{ $child->title }}
                    </a>
                    @endforeach
                </div>
                @endif
            </div>
            @endforeach
            @endforeach
        </div>
    </div>

    {{-- 4. CATEGORY BAR (Desktop Only) --}}
    <livewire:category-bar-component />


</div>