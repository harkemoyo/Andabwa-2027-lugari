{{-- LATEST POSTS TOP --}}
<section class="relative py-6 overflow-hidden bg-white">
    @if($this->latestPosts->isNotEmpty())
    <div
        x-data="smoothInfiniteSlider({{ $this->latestPosts->count() }})"
        x-init="init()"
        @mouseenter="pause()"
        @mouseleave="play()"
        class="relative max-w-5xl mx-auto px-4">
        {{-- 1. REFINED PROGRESS BAR (Top Aligned) --}}
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-48 h-[2px] bg-slate-100 rounded-full overflow-hidden z-20">
            <div
                class="h-full bg-gradient-to-r from-purple-600 to-pink-500 transition-all duration-700 ease-out"
                :style="`width: ${((active + 1) / count) * 100}%`"></div>
        </div>

        {{-- 2. THE SLIDER TRACK --}}
        <div class="relative overflow-hidden py-12">
            <div
                class="flex"
                {{-- UI/UX Engineering: Custom Cubic Bezier for "Soft" movement --}}
                :style="`
                    transform: translateX(-${active * 100}%); 
                    transition: transform 750ms cubic-bezier(0.23, 1, 0.32, 1);
                `">
                @foreach($this->latestPosts as $post)
                <div class="w-full shrink-0 px-4 transition-all duration-700"
                    :class="active === {{ $loop->index }} ? 'scale-100 opacity-100' : 'scale-[0.98] opacity-40 blur-[1px]'">
                    @include('components.blog.post-card-top-content', ['post' => $post])
                </div>
                @endforeach
            </div>
        </div>

        {{-- 3. INTERACTIVE PILL NAVIGATION (Modern UX) --}}
        <div class="flex justify-center items-center gap-3">
            @foreach($this->latestPosts as $i => $p)
            <button
                @click="go({{ $i }})"
                class="group relative h-1.5 rounded-full transition-all duration-500 overflow-hidden"
                :class="active === {{ $i }} ? 'w-10 bg-purple-600' : 'w-3 bg-slate-200 hover:bg-slate-300'"
                aria-label="Go to slide {{ $i + 1 }}">
                {{-- Interactive "Fill" animation on the active pill --}}
                <span
                    class="absolute inset-0 bg-purple-600 transition-all duration-[5000ms] linear"
                    :style="active === {{ $i }} ? 'width: 100%' : 'width: 0%'"></span>
            </button>
            @endforeach
        </div>

    </div>
    @endif
</section>