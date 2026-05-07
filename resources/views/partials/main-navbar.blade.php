{{-- ============================= --}}
{{-- PREMIUM MAIN NAVBAR --}}
{{-- ============================= --}}

<nav
    class="sticky top-0 z-[9999]
    backdrop-blur-2xl
    bg-gradient-to-r from-purple-700 via-pink-600 to-red-500
    border-b border-white/10
    shadow-[0_8px_40px_rgba(0,0,0,0.12)]">

    {{-- TOP LIGHT OVERLAY --}}
    <div class="absolute inset-0 bg-white/5 pointer-events-none"></div>

    <div class="relative max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex items-center justify-between h-20">

            {{-- ============================= --}}
            {{-- LEFT SECTION --}}
            {{-- ============================= --}}
            <div class="flex items-center gap-10 min-w-0">

                {{-- LOGO --}}
                <div class="shrink-0 scale-105">
                    <livewire:navigation-logo-header-component />
                </div>

            </div>

            {{-- ============================= --}}
            {{-- CENTER NAV (FIXED + RESPONSIVE) --}}
            {{-- ============================= --}}
            <div class="hidden md:flex items-center justify-center h-full w-full">

                <div class="flex items-center justify-center gap-1 lg:gap-2 w-full max-w-4xl">

                    @foreach ($menus as $menu)

                        <div class="flex items-center h-full">

                            @foreach ($menu->items as $item)

                                @php
                                    $isActive =
                                        request()->url() == $item->url ||
                                        request()->is(trim($item->slug, '/') . '*');

                                    $icon = match(strtolower($item->title)) {
                                        'live'        => 'heroicon-o-video-camera',
                                        'podcasts'    => 'heroicon-o-microphone',
                                        'radio'       => 'heroicon-o-radio',
                                        'tv'          => 'heroicon-o-tv',
                                        'news'        => 'heroicon-o-newspaper',
                                        'projects'    => 'heroicon-o-briefcase',
                                        'stream live' => 'heroicon-o-video-camera',
                                        default       => 'heroicon-o-squares-2x2',
                                    };
                                @endphp

                                <div
                                    wire:key="menu-item-{{ $item->id }}"
                                    x-data="{ open: false }"
                                    class="relative h-full flex items-center"
                                    @mouseenter="open = true"
                                    @mouseleave="open = false">

                                    {{-- NAV LINK --}}
                                    <a href="{{ $item->url ?? url($item->slug) }}"
                                       wire:navigate.hover
                                       class="group relative flex flex-col items-center justify-center
                                       h-full px-5 lg:px-6 min-w-[82px]
                                       transition-all duration-300">

                                        {{-- ICON --}}
                                        <div class="relative mb-1 transition-all duration-300 group-hover:-translate-y-0.5 group-hover:scale-110">

                                            @svg(
                                                $icon,
                                                'w-5 h-5 transition-all duration-300 ' .
                                                ($isActive ? 'text-white' : 'text-white/75 group-hover:text-white') .
                                                (strtolower($item->title) === 'live' ? ' animate-pulse text-green-300' : '')
                                            )

                                            {{-- LIVE INDICATOR --}}
                                            @if(strtolower($item->title) === 'live')
                                                <span class="absolute -top-1 -right-1 flex h-2.5 w-2.5">
                                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-500 border border-white"></span>
                                                </span>
                                            @endif

                                        </div>

                                        {{-- TITLE --}}
                                        <span class="text-[10px] uppercase tracking-[0.22em] font-black whitespace-nowrap transition-all duration-300
                                        {{ $isActive ? 'text-white' : 'text-white/75 group-hover:text-white' }}">
                                            {{ $item->title }}
                                        </span>

                                        {{-- ACTIVE LINE --}}
                                        <span class="absolute bottom-0 left-1/2 -translate-x-1/2 h-[3px] rounded-full bg-white transition-all duration-300
                                        {{ $isActive ? 'w-10 opacity-100' : 'w-0 opacity-0 group-hover:w-8 group-hover:opacity-60' }}">
                                        </span>

                                    </a>

                                    {{-- DROPDOWN --}}
                                    @if ($item->children->count())

                                        <div
                                            x-show="open"
                                            x-transition:enter="transition ease-out duration-200"
                                            x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                                            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                            x-transition:leave="transition ease-in duration-150"
                                            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                            x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                                            x-cloak
                                            class="absolute left-0 top-[90%] w-72 rounded-3xl overflow-hidden
                                            bg-white/95 backdrop-blur-2xl
                                            border border-white/20
                                            shadow-[0_25px_80px_rgba(0,0,0,0.2)]
                                            z-[10000]">

                                            <div class="px-5 py-4 border-b border-slate-100 bg-gradient-to-r from-purple-50 to-pink-50">
                                                <h3 class="text-[10px] uppercase tracking-[0.25em] font-black text-slate-400">
                                                    {{ $item->title }} Exploration
                                                </h3>
                                            </div>

                                            <div class="p-3">

                                                @foreach ($item->children as $child)

                                                    <a href="{{ $child->url ?? url($child->slug) }}"
                                                       wire:navigate.hover
                                                       class="group/child flex items-center gap-4 px-4 py-3 rounded-2xl transition-all duration-200 hover:bg-gradient-to-r hover:from-purple-50 hover:to-pink-50">

                                                        <div class="w-2 h-2 rounded-full bg-slate-300 group-hover/child:bg-purple-500 transition-colors"></div>

                                                        <span class="text-sm font-bold text-slate-600 group-hover/child:text-purple-700 transition-colors">
                                                            {{ $child->title }}
                                                        </span>

                                                    </a>

                                                @endforeach

                                            </div>
                                        </div>

                                    @endif

                                </div>

                            @endforeach

                        </div>

                    @endforeach

                </div>
            </div>

            {{-- ============================= --}}
            {{-- RIGHT SECTION --}}
            {{-- ============================= --}}
            <div class="flex items-center gap-4 shrink-0">

                @include('partials.auth-buttons', ['showDemo' => false])

            </div>

        </div>

    </div>

</nav>