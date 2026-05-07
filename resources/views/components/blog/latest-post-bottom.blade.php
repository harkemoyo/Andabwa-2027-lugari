{{-- LATEST POSTS BOTTOM --}}
<div
    x-data="insaneInfiniteSlider()"
    x-init="init()"
    class="relative group mx-auto overflow-hidden py-6 md:py-10">
    {{-- Navigation Arrows --}}
    <button @click="scroll(-1)" class="absolute hover-purple-600 left-5 top-1/2 -translate-y-1/2 z-40 bg-white/80 p-3 rounded-full shadow-xl opacity-0 group-hover:opacity-100 transition-all duration-300 hidden md:flex">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
    </button>

    <button @click="scroll(1)" class="absolute hover-purple-600 right-5 top-1/2 -translate-y-1/2 z-40 bg-white/80 p-3 rounded-full shadow-xl opacity-0 group-hover:opacity-100 transition-all duration-300 hidden md:flex">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
    </button>

    {{-- SCROLL TRACK --}}
    <div
        x-ref="track"
        @scroll="handleInfiniteScroll"
        @mouseenter="pause()"
        @mouseleave="play()"
        class="flex overflow-x-auto gap-4 md:gap-8 px-4 md:px-12 py-4 snap-x snap-mandatory scrollbar-hide cursor-grab active:cursor-grabbing"
        style="scroll-behavior: smooth;" {{-- Controlled via JS usually, but kept for manual swipes --}}>
        @foreach($this->latestPosts->merge($this->latestPosts) as $post)
        <div class="snap-center shrink-0 w-[85vw] md:w-[550px] lg:w-[650px]">
            @include('components.blog.post-card-bottom-horizontal-content', ['post' => $post])
        </div>
        @endforeach
    </div>
</div>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('insaneInfiniteSlider', () => ({
            autoplayInterval: null,
            isJumping: false,

            init() {
                this.play();
            },

            handleInfiniteScroll() {
                if (this.isJumping) return;

                const track = this.$refs.track;
                const scrollLeft = track.scrollLeft;
                const scrollWidth = track.scrollWidth;
                const clientWidth = track.clientWidth;

                // The point where the first set ends (half of the total scrollable content)
                const halfWidth = scrollWidth / 2;

                // If we've scrolled past the first set, teleport back to the equivalent spot in set 1
                if (scrollLeft >= halfWidth) {
                    this.teleport(track, scrollLeft - halfWidth);
                }
                // If we've scrolled behind the start (possible on some browsers/bouncy scrolls), jump to set 2
                else if (scrollLeft <= 0) {
                    this.teleport(track, halfWidth);
                }
            },

            teleport(track, position) {
                this.isJumping = true;

                // Remove smooth behavior for the instant jump
                track.style.scrollBehavior = 'auto';

                track.scrollTo({
                    left: position
                });

                // Restore smooth behavior after the jump
                // RequestAnimationFrame ensures the browser processed the jump first
                requestAnimationFrame(() => {
                    track.style.scrollBehavior = 'smooth';
                    this.isJumping = false;
                });
            },

            scroll(direction) {
                const track = this.$refs.track;
                const scrollAmount = track.offsetWidth * 0.8;

                track.scrollBy({
                    left: direction * scrollAmount,
                    behavior: 'smooth'
                });
            },

            play() {
                if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
                this.autoplayInterval = setInterval(() => this.scroll(1), 9000);
            },

            pause() {
                if (this.autoplayInterval) clearInterval(this.autoplayInterval);
            }
        }));
    });
</script>