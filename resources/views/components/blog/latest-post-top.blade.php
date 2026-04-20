<section class="relative py-4  m-4  overflow-hidden ">
    @if($this->latestPosts->isNotEmpty())
    <div 
        x-data="infiniteSlider({{ $this->latestPosts->count() }})"
        x-init="init()"
        @mouseenter="pause()" 
        @mouseleave="play()"
        class="relative max-w-3xl mx-auto overflow-hidden py-8"
    >

        {{-- PROGRESS BAR --}}
        <div class="absolute -top-6 left-1/2 -translate-x-1/2 w-1/3 h-[3px] bg-gray-100 rounded-full overflow-hidden z-20">
            <div
                class="h-full bg-gradient-to-r from-purple-600 via-pink-500 to-red-500 transition-all duration-300"
                :style="`width: ${progress}%`">
            </div>
        </div>

        {{-- SLIDER --}}
        <div 
            class="flex"
            :class="{ 'transition-transform duration-500 ease-out': !jumping }"
            :style="`transform: translateX(-${active * 100}%)`"
        >
            @foreach($this->latestPosts as $post)
                <div class="w-full shrink-0 px-4">
                    @include('components.blog.post-card-top', ['post' => $post])
                </div>
            @endforeach
        </div>

        {{-- NAV BUTTONS 
        <button @click="prev()" 
            class="hidden xl:flex absolute -left-16 top-1/2 -translate-y-1/2 z-30 
            w-12 h-12 items-center justify-center rounded-full bg-white shadow-lg">
            ‹
        </button>

        <button @click="next()" 
            class="hidden xl:flex absolute -right-16 top-1/2 -translate-y-1/2 z-30 
            w-12 h-12 items-center justify-center rounded-full bg-white shadow-lg">
            ›
        </button>--}}

        {{-- DOTS --}}
        <div class="py-2 flex justify-center gap-2">
            @foreach($this->latestPosts as $i => $p)
                <button 
                    @click="go({{ $i }})"
                    class="h-2 rounded-full transition-all"
                    :class="active === {{ $i }} ? 'w-8 bg-purple-600' : 'w-2 bg-gray-300'">
                </button>
            @endforeach
        </div>

    </div>
    @endif

</section>