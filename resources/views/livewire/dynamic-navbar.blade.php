<div wire:key="navbar-root"
    x-data="{ mobileOpen: false }"
    @keydown.escape="mobileOpen = false"
    class="sticky top-0 z-[1100] w-full shadow-lg"> 

    {{-- 1. BREAKING NEWS TICKER --}}
    @include('partials.breaking-news', ['showDemo' => false]) 

    {{-- 2. MAIN NAVIGATION --}}
    <nav class="relative z-[1000] backdrop-blur-2xl bg-gradient-to-r from-purple-700 via-pink-600 to-red-500 border-b border-white/20">
        <div class="max-w-[1400px] mx-auto px-6 flex items-center justify-between h-20">

            {{-- LOGO --}}
            <div class="shrink-0 scale-110">
                <livewire:navigation-logo-header-component />
            </div>

            {{-- DESKTOP NAV (Vertical Icon Stack) --}}
            <div class="hidden md:flex items-center gap-2 h-full">

                @foreach ($menus as $menu)
                    @foreach ($menu->items as $item)
                        @php
                            // Pro Engineer Mapping: Sync icons to dynamic titles
                            $icon = match(strtolower($item->title)) {
                                'live' => 'heroicon-o-signal',
                                'podcasts' => 'heroicon-o-microphone',
                                'radio' => 'heroicon-o-radio',
                                'tv' => 'heroicon-o-tv',
                                'news' => 'heroicon-o-newspaper',
                                'projects' => 'heroicon-o-briefcase',
                                default => 'heroicon-o-squares-2x2',
                            };
                            
                            $isActive = request()->url() == $item->url || request()->is(trim($item->slug, '/').'*');
                        @endphp

                        <div
                            wire:key="menu-item-{{ $item->id }}"
                            x-data="{ open: false }"
                            class="relative h-full flex items-center"
                            @mouseenter="open = true"
                            @mouseleave="open = false">
                            
                            <a href="{{ $item->url ?? url($item->slug) }}"
                               wire:navigate.hover
                               class="flex flex-col items-center justify-center px-4 h-full min-w-[80px] transition-all duration-300 group {{ $isActive ? 'text-white' : 'text-white/70 hover:text-white' }}">
                                
                                {{-- Icon Above Title --}}
                                <div class="mb-1 transform group-hover:-translate-y-1 group-hover:scale-110 transition-all duration-300 ease-out">
                                    @svg($icon, 'w-6 h-6 ' . (strtolower($item->title) === 'live' ? 'text-green-400 group-hover:text-green-300' : ''))
                                </div>

                                <span class="text-[11px] uppercase tracking-widest font-bold">{{ $item->title }}</span>
                                
                                {{-- Premium Active Indicator --}}
                                <span class="absolute bottom-0 left-0 h-[3px] bg-white transition-all duration-300 rounded-t-full {{ $isActive ? 'w-full' : 'w-0 group-hover:w-full opacity-50' }}"></span>
                            </a>

                            {{-- DROPDOWN (Enhanced Glassmorphism) --}}
                            @if ($item->children->count())
                            <div
                                x-show="open"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 translate-y-2"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-cloak
                                class="absolute left-0 top-[90%] w-64 bg-white/95 backdrop-blur-xl rounded-2xl shadow-2xl border border-gray-100 p-3 z-[1100]">
                                
                                <div class="grid gap-1">
                                    @foreach ($item->children as $child)
                                        @if($child->is_active)
                                        <a href="{{ $child->url ?? url($child->slug) }}"
                                           wire:navigate.hover
                                           class="flex items-center gap-3 p-3 rounded-xl hover:bg-gradient-to-r hover:from-purple-50 hover:to-pink-50 text-gray-700 hover:text-purple-700 transition-all group/child">
                                            <div class="w-1.5 h-1.5 rounded-full bg-gray-300 group-hover/child:bg-purple-500 transition-colors"></div>
                                            <span class="text-sm font-bold">{{ $child->title }}</span>
                                        </a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                    @endforeach
                @endforeach
            </div>

            {{-- RIGHT SECTION --}}
            <div class="flex items-center gap-4">
                @include('partials.auth-buttons', ['showDemo' => false])
                
                

                {{-- Mobile Toggle --}}
                <button @click="mobileOpen = !mobileOpen" class="md:hidden p-2 text-white">
                    <svg x-show="!mobileOpen" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    <svg x-show="mobileOpen" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>

                <!-- hidden md:block -->


            </div>
        </div>
    </nav>

    {{-- 3. UNIFIED MOBILE MENU (Pro Sliding Panel) --}}
    @include('partials.mobile-menu', ['showDemo' => false])

    {{-- 4. CATEGORIES (Pill Style Sub-nav) --}}
    <x-blog.categories-menu/>
</div>