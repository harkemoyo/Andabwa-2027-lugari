<div wire:key="navbar-root"
    x-data="{ mobileOpen: false }"
    @keydown.escape="mobileOpen = false"
    class="sticky top-0 z-[1100] w-full shadow-md"> {{-- 1. BREAKING NEWS TICKER (Optimized) --}}
    


    @include('partials.breaking-news', ['showDemo' => false]) 

    {{-- 2. MAIN NAVIGATION --}}
    <div>
        <nav class="relative z-[1000] p-3 backdrop-blur-xl bg-gradient-to-r from-purple-600 via-pink-500 to-red-500 border-b border-white/10 shadow-md">
            <div class="max-w-[1400px] mx-auto px-4 flex items-center justify-between h-16">

                {{-- LOGO --}}
                <livewire:navigation-logo-header-component />

                {{-- DESKTOP NAV --}}
                <div class="hidden md:flex items-center gap-8 text-sm font-medium text-white/90">

                    @foreach ($menus as $menu)
                    @foreach ($menu->items as $item)

                    <div
                        wire:key="menu-item-{{ $item->id }}"
                        wire:ignore.self
                        x-data="{ open: false }"
                        class="relative group"
                        @mouseenter="open = true"
                        @mouseleave="open = false">
                        <a
                            href="{{ $item->url ?? url($item->slug) }}"
                            wire:navigate.hover
                            class="relative px-1 py-2 text-white/90 hover:text-pink-900 transition-colors duration-300 group">
                            <span>{{ $item->title }}</span>
                            <span class="pointer-events-none absolute left-0 -bottom-0.5 h-[2px] w-0 bg-gradient-to-r from-pink-400 to-purple-500 transition-all duration-300 ease-out group-hover:w-full"></span>
                        </a>

                        {{-- DROPDOWN --}}
                        @if ($item->children->count())
                        <div
                            wire:key="dropdown-{{ $item->id }}"
                            wire:ignore
                            x-show="open"
                            x-transition.opacity.duration.150ms
                            x-cloak
                            class="absolute left-0 top-full mt-2 w-64 bg-white text-gray-800 rounded-xl shadow-2xl p-4 grid gap-2 z-[1100]">

                            @foreach ($item->children as $child)
                            @if($child->is_active)
                            <a
                                href="{{ $child->url ?? url($child->slug) }}"
                                wire:navigate.hover
                                class="block p-2 rounded-lg hover:bg-gray-50 text-sm font-semibold">
                                {{ $child->title }}
                            </a>
                            @endif
                            @endforeach

                        </div>
                        @endif
                    </div>

                    @endforeach
                    @endforeach

                </div>
                {{-- RIGHT SECTION --}}
                @include('partials.auth-buttons', ['showDemo' => false])          

            </div>
        </nav>
    </div>

    {{-- 3. UNIFIED MOBILE MENU --}}
    <div x-show="mobileOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-cloak
        class="md:hidden absolute top-full left-0 w-full bg-white shadow-2xl border-t border-gray-100 max-h-[80vh] overflow-y-auto">

        <div class="p-4 space-y-2">

            {{-- 🐛 BUG FIX: Repaired completely corrupted DOM tag. Formatted valid form and input. --}}
            <div class="pb-4">
                <form action="{{ route('blog.all-projects') }}" method="GET" wire:navigate>
                    <input 
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search..."
                        class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-red-500"
                    />
                </form>
            </div>

            {{-- Menu Items --}}
            @foreach ($menus as $menu)
            @foreach ($menu->items as $item)
            <div x-data="{ expanded: false }" class="border-b border-gray-50 last:border-none">
                <button @click="expanded = !expanded" class="w-full flex justify-between items-center py-3 text-gray-800 font-bold">
                    {{ $item->title }}
                    <span :class="expanded ? 'rotate-180' : ''" class="transition-transform duration-200 text-gray-400">⌄</span>
                </button>

                @if ($item->children->count())
                <div x-show="expanded" x-collapse x-cloak class="pl-4 pb-3 space-y-1">
                    @foreach ($item->children->where('is_active', true) as $child)
                    <a
                        href="{{ $child->url ?? url($child->slug) }}"
                        wire:navigate.hover
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

    {{-- 4. CATEGORIES --}}
    <div class="relative overflow-visible hidden md:block bg-gray-50 border-b border-gray-200">
        {{-- Removed sticky from here, as the parent wrapper is handling the sticky behavior natively --}}
        <nav class="bg-white border-b border-gray-100 shadow-sm z-[100]">
            <div class="max-w-[1400px] mx-auto px-10 flex gap-8 py-3 text-xs font-bold uppercase tracking-widest text-gray-600">

                @forelse($this->categories as $category)
                <a href="{{ route('blog.all-projects', ['categoryId' => $category->id]) }}"
                    wire:navigate.hover
                    class="{{ request('categoryId') == $category->id ? 'text-red-600' : 'hover:text-red-600' }} transition-colors duration-200">
                    {{ $category->name }}
                </a>
                @empty
                <span class="text-gray-400 normal-case font-normal">No categories available</span>
                @endforelse

                {{-- Real-time loading indicator --}}
                <div wire:loading class="ml-auto">
                    <span class="animate-pulse text-red-500">Updating...</span>
                </div>
            </div>
        </nav>
    </div> 

</div> {{-- 🐛 BUG FIX: Correctly close the main navbar-root wrapper at the very end --}}