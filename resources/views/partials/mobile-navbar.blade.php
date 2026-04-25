<div x-show="mobileOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-cloak
        class="md:hidden absolute top-full left-0 w-full bg-white/98 backdrop-blur-2xl shadow-2xl border-t border-gray-100 max-h-[85vh] overflow-y-auto">

        <div class="p-6 space-y-6">
            {{-- Modern Search Bar --}}
            <form action="{{ route('blog.all-projects') }}" method="GET" class="relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search content..."
                    class="w-full bg-gray-100 border-none rounded-xl px-5 py-3 focus:ring-2 focus:ring-purple-500 transition-all"/>
                <button class="absolute right-4 top-3.5 text-gray-400">@svg('heroicon-o-magnifying-glass', 'w-5 h-5')</button>
            </form>

            <div class="grid gap-2">
                @foreach ($menus as $menu)
                    @foreach ($menu->items as $item)
                        <div x-data="{ expanded: false }">
                            <div class="flex items-center justify-between">
                                <a href="{{ $item->url ?? url($item->slug) }}" class="flex items-center gap-4 py-3 text-gray-900 font-black text-lg uppercase tracking-tight">
                                    <div class="p-2 bg-gray-50 rounded-lg">@svg($icon ?? 'heroicon-o-squares-2x2', 'w-5 h-5 text-purple-600')</div>
                                    {{ $item->title }}
                                </a>
                                @if ($item->children->count())
                                    <button @click="expanded = !expanded" class="p-2 bg-gray-50 rounded-full">
                                        <svg :class="expanded ? 'rotate-180' : ''" class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </button>
                                @endif
                            </div>

                            @if ($item->children->count())
                                <div x-show="expanded" x-collapse class="pl-14 space-y-3 pb-4 border-l-2 border-gray-100 ml-6 mt-1">
                                    @foreach ($item->children->where('is_active', true) as $child)
                                        <a href="{{ $child->url ?? url($child->slug) }}" class="block text-gray-500 font-bold hover:text-purple-600 transition">{{ $child->title }}</a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>

    {{-- Mobile Toggle 
                <button @click="mobileOpen = !mobileOpen" class="md:hidden p-2 text-white">
                    <svg x-show="!mobileOpen" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    <svg x-show="mobileOpen" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>

    <!-- hidden md:block -->--}}