<div
    x-show="$store.nav.mobileOpen"
    x-transition.opacity
    class="fixed inset-0 z-50 md:hidden"
>

    {{-- BACKDROP --}}
    <div
        class="absolute inset-0 bg-black/40"
        @click="$store.nav.closeMobile()"
    ></div>

    {{-- DRAWER --}}
    <div
        x-show="$store.nav.mobileOpen"
        x-transition:enter="transition transform duration-300"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition transform duration-200"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        x-data="swipeClose()"
        @touchstart="start($event)"
        @touchmove="move($event)"
        @touchend="end()"
        class="absolute right-0 top-0 h-full w-[85%] max-w-sm bg-white shadow-2xl flex flex-col"
    >

        {{-- HEADER --}}
        <div class="flex items-center justify-between px-4 py-4 border-b">
            <span class="font-semibold">Menu</span>
            <button @click="$store.nav.closeMobile()">✕</button>
        </div>

        {{-- CONTENT --}}
        <div class="flex-1 overflow-y-auto px-4 py-4 space-y-3">

            @foreach ($menus as $menu)
                @foreach ($menu->items as $index => $item)

                    <div class="border-b">

                        <button
                            @click="$store.nav.setActive({{ $index }})"
                            class="w-full flex justify-between py-3 font-medium"
                        >
                            {{ $item->title }}
                            <span :class="{ 'rotate-180': $store.nav.activeIndex === {{ $index }} }"
                                  class="transition">⌄</span>
                        </button>

                        @if ($item->children->count())
                            <div
                                x-show="$store.nav.activeIndex === {{ $index }}"
                                x-transition
                                x-collapse
                                class="pl-4 pb-2 space-y-2"
                            >
                                @foreach ($item->children as $child)
                                    <a href="{{ $child->url ?? url($child->slug) }}"
                                       class="block py-2 text-sm text-gray-600 hover:text-red-600">
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