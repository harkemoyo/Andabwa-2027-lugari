{{-- LATEST POSTS BOTTOM --}}
@if($this->latestPosts->isNotEmpty())
<div 
    x-data="insaneInfiniteSliders()" 
    x-init="init()" 
    class="relative group mx-auto overflow-hidden py-6 md:py-10"
>
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
</div>
@endif