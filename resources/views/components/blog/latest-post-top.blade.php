{{-- LATEST POSTS INFINITE SCROLLER --}}
@if($this->latestPosts->isNotEmpty())
<div 
    x-data="insaneInfiniteSliders()" 
    x-init="init()" 
    class="relative group mx-auto hidden md:block overflow-hidden py-10"
>
    {{-- SCROLL TRACK --}}
    <div 
        x-ref="track" 
        @mouseenter="pause()" 
        @mouseleave="play()" 
        class="flex overflow-x-auto gap-8 px-6 lg:px-12 py-4
               snap-x snap-mandatory scrollbar-hide cursor-grab active:cursor-grabbing"
    >
        {{-- CLONE & ORIGINAL LOOPS --}}
        @foreach($this->latestPosts->merge($this->latestPosts) as $post)
            {{-- THE 2-COLUMN CARD COMPONENT --}}
            <div class="snap-start shrink-0 w-[90vw] md:w-[550px] lg:w-[650px]">
                @include('components.blog.post-card-horizontal', ['post' => $post])
            </div>
        @endforeach
    </div>
</div>
@endif