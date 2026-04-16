<div wire:key="navbar-root"
    x-data
    @keydown.escape="$store.nav.reset()"
    class="sticky top-0 z-50">

    {{-- 🔥 Poll every 5 seconds for breaking news expiry checks 
    <div wire:key="breaking-ticker" wire:ignore.self>
        <div wire:poll.5s.keep-alive></div>
    </div>--}}

    @if($this->hasBreaking())
    {{-- Main Ticker Container --}}
    <div
        x-data="{ show: true }"
        x-show="show"
        x-transition:enter="transition ease-out duration-500"
        x-transition:enter-start="opacity-0 -translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        class="bg-red-600 text-white text-sm font-semibold flex items-center overflow-hidden">

        <div class="px-4 py-2 bg-white uppercase tracking-wider shrink-0 shadow-lg z-10">
            <p class="">🔴</p>
            <p class="text-red-600">Breaking</p>
        </div>

        {{-- Scrolling / Display Area --}}
        <div class="flex-1 px-4 py-2 flex items-center gap-6 overflow-x-auto whitespace-nowrap scrollbar-hide animate-ticker hover:[animation-play-state:paused]">

            {{-- 🔥 Use $this->breakingItems here instead of $this->menus --}}
            <div class="flex animate-ticker gap-6">
                <template x-for="i in 3">
                    <div class="flex gap-6">
                        @foreach ($breakingItems as $item)
                        <div class="flex items-center gap-2">
                            @if($item->is_live)
                            <span class="flex h-3 w-3 relative">
                                <span class="animate-ping absolute h-full w-full rounded-full bg-red-300 opacity-75"></span>
                                <span class="relative h-3 w-3 rounded-full bg-white"></span>
                            </span>
                            <span class="text-[10px] px-2 py-0.5 rounded bg-yellow-400 text-black"
                                x-show="'{{ $item->status }}'">
                                {{ $item->status }}
                            </span>
                            <span class="text-xs text-red-200 uppercase">Live</span>
                            @endif
                            <a href="{{ $item->url }}"
                                wire:navigate
                                wire:prefetch @click="$wire.trackClick({{ $item->id }})"
                                class="hover:underline">
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


    {{-- 🧊 MAIN NAV --}}
    <div
        x-data="navSystem()"
        x-init="init()"
        @keydown.escape="closeAll()"
        class="sticky top-0 p-3 z-50 backdrop-blur-xl bg-gradient-to-r from-purple-500/90 via-pink-500/90 to-red-500/90 border-b border-white/10 shadow-md">

        <div class="max-w-[1400px]  xl:max-w-[1500px] mx-auto px-4 sm:px-6 lg:px-10 ">
            <div class="flex items-center justify-between h-16">

                {{-- LOGO --}}
                <div class="flex items-center gap-4">
                    <livewire:navigation-logo-header-component />
                </div>

                {{-- DESKTOP NAV --}}
                <nav class="hidden md:flex items-center gap-6 lg:gap-8 text-sm font-medium text-white/90">

                    @foreach ($menus as $menu)
                    @if ($menu->items && $menu->items->count())
                    @foreach ($menu->items as $index => $item)

                    <div class="relative"
                        @mouseenter="$store.nav.openMenu({{ $index }})"
                        @mouseleave="$store.nav.closeMenu()">

                        {{-- MAIN ITEM --}}
                        <button
                            :aria-expanded="open.toString()"
                            @focus="openWithIntent"
                            @keydown.enter.prevent="toggle"
                            @keydown.arrow-down.prevent="openAndFocusFirst"
                            class="relative px-1 py-2 hover:text-gray-700 focus:outline-none">
                            {{ $item->title }}

                            <span class="absolute left-0 -bottom-1 w-0 h-[2px] bg-red-600 transition-all duration-300 group-hover:w-full"></span>
                        </button>

                        {{-- MEGA MENU --}}
                        @if ($item->children->count())
                        <div
                            x-show="$store.nav.activeMenu === {{ $index }}"
                            x-transition
                            x-cloak
                            @keydown.escape.stop="close"
                            class="absolute left-0 top-full mt-3 w-[90vw] max-w-[640px]
                               bg-white text-gray-800 border border-gray-100
                               rounded-2xl shadow-xl p-5
                               grid grid-cols-1 sm:grid-cols-2 gap-4"
                            role="menu">

                            @foreach ($item->children->where('is_active', true) as $childIndex => $child)

                            <a
                                href="{{ $child->url ?? url($child->slug) }}"
                                target="_blank"
                                role="menuitem"
                                tabindex="-1"
                                @keydown.arrow-down.prevent="$focus.next()"
                                @keydown.arrow-up.prevent="$focus.previous()"
                                class="block p-3 rounded-lg hover:bg-gray-50 focus:bg-gray-50 transition">
                                <p class="font-semibold text-sm">
                                    {{ $child->title }}
                                </p>

                                <p class="text-xs text-gray-500 mt-1">
                                    Explore {{ $child->title }} updates
                                </p>
                            </a>

                            @endforeach

                        </div>
                        @endif

                    </div>

                    @endforeach
                    @endif
                    @endforeach

                </nav>

                {{-- RIGHT --}}
                <div class="flex items-center gap-3 sm:gap-4">

                    {{-- SEARCH --}}
                    <div class="hidden md:block">
                        <input
                            wire:model.live.debounce.300ms="search"
                            type="text"
                            placeholder="Search news..."
                            class="w-40 lg:w-52 px-4 py-2 text-sm  rounded-full
                               border border-white/20 bg-white/90 text-gray-800
                               focus:outline-none focus:ring-2 focus:ring-white/60 transition">
                    </div>

                    {{-- USER / AUTH --}}
                    @auth
                    <div class="relative" x-data="{ open: false, rect: null }">

                        <button
                            @click="open = !open; rect = $el.getBoundingClientRect()"
                            class="w-9 h-9 rounded-full bg-white/20 flex items-center justify-center">
                            <span class="text-white text-xs font-semibold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </span>
                        </button>

                        <div
                            x-show="$store.nav.activeMenu === {{ $index }}"
                            x-transition
                            x-cloak
                            :style="`position: absolute; right: 0; top: calc(100% + 8px);`"
                            class="w-56 bg-white border rounded-xl shadow-2xl z-50">
                            <div class="px-4 py-3 border-b">
                                <p class="text-sm font-semibold">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                            </div>

                            <a href="#" class="block px-4 py-2 hover:bg-gray-50">Dashboard</a>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-50">Profile</a>

                            <div class="border-t mt-2 pt-2">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                    @else
                    <button  
                        @click="$dispatch('login-modal')"
                        class="px-4 py-2 hover:shadow-green-50 shadow-lg hover:text-gray-800 text-sm rounded-full bg-white text-gray-800 hover:bg-gray-100 transition">
                        Sign In
                    </button>
                    @endauth

                    {{-- MOBILE TOGGLE --}}
                    <div class="md:hidden">
                        <button
                            @click="mobileOpen = !mobileOpen"
                            class="p-2 rounded-lg bg-white/20">
                            ☰
                        </button>
                    </div>

                </div>

            </div>
        </div>

        {{-- 📱 MOBILE MENU --}}
        <div
            x-show="mobileOpen"
            x-transition
            class="md:hidden bg-white text-gray-800 border-t shadow-lg">
            <div class="px-4 py-4 space-y-4">

                {{-- SEARCH --}}
                <input
                    wire:model.live.debounce.300ms="search"
                    type="text"
                    placeholder="Search..."
                    class="w-full px-4 py-2 rounded-full border">

                {{-- MENU --}}
                @foreach ($menus as $menu)
                @foreach ($menu->items as $item)

                <div x-data="{ open: false }">

                    <button
                        @click="open = !open"
                        class="w-full text-left font-semibold py-2 flex justify-between">
                        {{ $item->title }}
                        <span x-text="open ? '-' : '+'"></span>
                    </button>

                    @if ($item->children->count())
                    <div x-show="$store.nav.activeMenu === {{ $index }}"
                        x-transition
                        x-cloak class="pl-4 space-y-2 mt-2">
                        @foreach ($item->children->where('is_active', true) as $child)
                        <a href="{{ $child->url ?? url($child->slug) }}"
                            class="block text-sm text-gray-600">
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

    </div>

    {{-- 🧭 SECONDARY CATEGORY BAR --}}
    <div class="hidden md:block bg-green-50 border-b">
        <div class="max-w-[1400px]  xl:max-w-[1500px] mx-auto px-4 sm:px-6 lg:px-10 flex gap-6 py-4 items-center text-sm text-gray-900">
            <span class="hover:text-black cursor-pointer">Politics</span>
            <span class="hover:text-black cursor-pointer">Business</span>
            <span class="hover:text-black cursor-pointer">Technology</span>
            <span class="hover:text-black cursor-pointer">Health</span>
            <span class="hover:text-black cursor-pointer">Sports</span>

        </div>
    </div>

    {{-- 📱 MOBILE MENU --}}
    <div x-show="mobileOpen"
        x-cloak
        class="md:hidden bg-white border-t p-4 space-y-2">

        @foreach ($menus as $menu)
        @foreach ($menu->items as $item)
        <div x-data="{ open: false }">
            <button
                @focus="$store.nav.openMenu({{ $index }})"
                @keydown.arrow-down.prevent="$refs.menu{{ $index }}.focus()"
                @keydown.escape="$store.nav.closeMenu()"
                :aria-expanded="$store.nav.activeMenu === {{ $index }}"
                class="w-full text-left font-semibold py-2 flex justify-between items-center text-gray-800">
                {{ $item->title }}
                <span :class="{ 'rotate-180': open }" class="transition-transform duration-200">⌄</span>
            </button>

            <div x-show="$store.nav.activeMenu === {{ $index }}"
                x-transition
                x-cloak x-collapse class="pl-4 border-l-2 border-red-50 ml-1">
                @foreach ($item->children as $child)
                <a x-ref="menu{{ $index }}"
                    tabindex="-1"
                    @keydown.arrow-down.prevent="$focus.next()"
                    @keydown.arrow-up.prevent="$focus.previous()"> href="{{ $child->url ?? url($child->slug) }}" class="block py-2 text-sm text-gray-600 hover:text-red-600">
                    {{ $child->title }}
                </a>
                @endforeach
            </div>
        </div>
        @endforeach
        @endforeach

    </div>

</div>