{{-- LATEST POSTS BOTTOM --}}
@if($this->latestPosts->isNotEmpty())
<div 
    x-data="insaneInfiniteSlider()" 
    x-init="init()" 
    class="relative group mx-auto overflow-hidden py-6 md:py-10"
>
    {{-- ENGINEER UI: Navigation Arrows (Visual Cues) --}}
    {{-- Left Arrow --}}
    <button 
        @click="scroll(-1)" 
        class="absolute left-2 md:left-5 top-1/2 -translate-y-1/2 z-40 bg-white/80 backdrop-blur-md p-3 rounded-full shadow-xl border border-slate-200 text-slate-800 opacity-0 group-hover:opacity-100 transition-all duration-300 hover:bg-purple-500/40 hover:text-white hidden md:flex items-center justify-center"
        aria-label="Scroll Left"
    >
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
    </button>

    {{-- Right Arrow --}}
    <button 
        @click="scroll(1)" 
        class="absolute right-2 md:right-5 top-1/2 -translate-y-1/2 z-40 bg-white/80 backdrop-blur-md p-3 rounded-full shadow-xl border border-slate-200 text-slate-800 opacity-0 group-hover:opacity-100 transition-all duration-300 hover:bg-purple-500/40 hover:text-white hidden md:flex items-center justify-center"
        aria-label="Scroll Right"
    >
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
    </button>

    {{-- SCROLL TRACK --}}
    <div 
        x-ref="track" 
        @mouseenter="pause()" 
        @mouseleave="play()" 
        class="flex overflow-x-auto gap-4 md:gap-8 px-4 md:px-12 py-4
               snap-x snap-mandatory scrollbar-hide cursor-grab active:cursor-grabbing"
    >
        @foreach($this->latestPosts->merge($this->latestPosts) as $post)
            <div class="snap-center shrink-0 w-[85vw] md:w-[550px] lg:w-[650px]">
                @include('components.blog.post-card-bottom-horizontal-content', ['post' => $post])
            </div>
        @endforeach
    </div>

    {{-- ENGINEER UI: Subtle Gradient Fade (Indicates more content) --}}
    <div class="absolute inset-y-0 left-0 w-20 bg-gradient-to-r from-white to-transparent pointer-events-none z-10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
    <div class="absolute inset-y-0 right-0 w-20 bg-gradient-to-l from-white to-transparent pointer-events-none z-10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
</div>
@endif