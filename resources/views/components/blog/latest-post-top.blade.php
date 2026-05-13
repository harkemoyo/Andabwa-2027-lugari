{{-- LATEST POSTS BOTTOM --}}
<div
    x-data="insaneInfiniteSlider()"
    x-init="init()"
    class="relative mx-auto overflow-hidden py-6 group max-w-7xl">

    {{-- SIDEWAYS SCROLL BUTTONS (Engineer Class UI/UX) --}}
    <div class="absolute inset-y-0 left-0 z-10 flex items-center pl-4 pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <button 
            @click="scrollPrev(); play()" 
            class="pointer-events-auto flex items-center justify-center w-12 h-12 rounded-xl 
                   bg-zinc-900/90 dark:bg-white/90 backdrop-blur-md 
                   text-white dark:text-zinc-900 shadow-xl border border-zinc-800/50 dark:border-zinc-200/50
                   hover:scale-105 active:scale-95 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500"
            aria-label="Previous slide">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
    </div>

    <div class="absolute inset-y-0 right-0 z-10 flex items-center pr-4 pointer-events-none opacity-0 group-hover:opacity-100 transition-opacity duration-300">
        <button 
            @click="scrollNext(); play()" 
            class="pointer-events-auto flex items-center justify-center w-12 h-12 rounded-xl 
                   bg-zinc-900/90 dark:bg-white/90 backdrop-blur-md 
                   text-white dark:text-zinc-900 shadow-xl border border-zinc-800/50 dark:border-zinc-200/50
                   hover:scale-105 active:scale-95 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-indigo-500"
            aria-label="Next slide">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
    </div>

    {{-- SCROLL TRACK --}}
    <div
        x-ref="track"
        @scroll="handleInfiniteScroll"
        @mouseenter="pause()"
        @mouseleave="play()"
        @mousedown="startDrag($event)"
        @mousemove="drag($event)"
        @mouseup="stopDrag()"
        @mouseleave="stopDrag()"
        @touchstart="startTouch($event)"
        @touchmove="moveTouch($event)"
        @touchend="stopDrag()"
        class="flex overflow-x-auto gap-6 md:gap-8 px-4 md:px-12 py-4
        snap-x snap-mandatory scrollbar-hide
        cursor-grab active:cursor-grabbing select-none"
        style="
            scroll-behavior:smooth;
            -webkit-overflow-scrolling:touch;
            scrollbar-width:none;
            -ms-overflow-style:none;
        ">

        @foreach($this->latestPosts->merge($this->latestPosts) as $post)
        <div class="snap-center shrink-0 w-[85vw] md:w-[550px] lg:w-[650px] transition-transform duration-300 hover:scale-[1.01]">
            @include('components.blog.post-card-tops-horizontal-content', ['post' => $post])
        </div>
        @endforeach

    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {

        Alpine.data('insaneInfiniteSlider', () => ({

            autoplayInterval: null,
            isJumping: false,

            // drag support
            isDragging: false,
            startX: 0,
            scrollLeft: 0,

            init() {

                this.$nextTick(() => {

                    const track = this.$refs.track;

                    // start from middle
                    track.scrollLeft = track.scrollWidth / 4;

                    // autoplay
                    this.play();

                    // Non-blocking UX Wheel Interaction logic
                    track.addEventListener('wheel', (e) => {
                        // If the user's scrolling movement is predominantly horizontal
                        if (Math.abs(e.deltaX) > Math.abs(e.deltaY)) {
                            e.preventDefault();
                            track.scrollLeft += e.deltaX;
                        }
                        // Vertical scroll moves naturally (deltaY is skipped), allowing pages to slide cleanly past this component.
                    }, {
                        passive: false
                    });

                });
            },

            // =========================
            // AUTO SWIPE EVERY 2 MINUTES (120,000ms)
            // =========================
            play() {

                this.pause();

                this.autoplayInterval = setInterval(() => {

                    this.scrollNext();

                }, 120000); 
            },

            pause() {

                if (this.autoplayInterval) {
                    clearInterval(this.autoplayInterval);
                }
            },

            scrollNext() {

                const track = this.$refs.track;

                const card = track.querySelector('div');

                if (!card) return;

                const amount = card.offsetWidth + 32;

                track.scrollBy({
                    left: amount,
                    behavior: 'smooth'
                });
            },

            scrollPrev() {

                const track = this.$refs.track;

                const card = track.querySelector('div');

                if (!card) return;

                const amount = card.offsetWidth + 32;

                track.scrollBy({
                    left: -amount,
                    behavior: 'smooth'
                });
            },

            // =========================
            // INFINITE LOOP
            // =========================
            handleInfiniteScroll() {

                if (this.isJumping) return;

                const track = this.$refs.track;

                const halfWidth = track.scrollWidth / 2;

                if (track.scrollLeft >= halfWidth) {

                    this.teleport(track.scrollLeft - halfWidth);

                } else if (track.scrollLeft <= 0) {

                    this.teleport(halfWidth);
                }
            },

            teleport(position) {

                this.isJumping = true;

                const track = this.$refs.track;

                track.style.scrollBehavior = 'auto';

                track.scrollLeft = position;

                requestAnimationFrame(() => {

                    track.style.scrollBehavior = 'smooth';

                    this.isJumping = false;
                });
            },

            // =========================
            // DESKTOP DRAG
            // =========================
            startDrag(e) {

                this.isDragging = true;

                this.pause();

                const track = this.$refs.track;

                this.startX = e.pageX;

                this.scrollLeft = track.scrollLeft;
            },

            drag(e) {

                if (!this.isDragging) return;

                e.preventDefault();

                const track = this.$refs.track;

                const walk = (e.pageX - this.startX) * 1.3;

                track.scrollLeft = this.scrollLeft - walk;
            },

            stopDrag() {

                this.isDragging = false;

                this.play();
            },

            // =========================
            // MOBILE TOUCH
            // =========================
            startTouch(e) {

                this.pause();

                const touch = e.touches[0];

                this.startX = touch.pageX;

                this.scrollLeft = this.$refs.track.scrollLeft;
            },

            moveTouch(e) {

                const touch = e.touches[0];

                const walk = (touch.pageX - this.startX) * 1.2;

                this.$refs.track.scrollLeft = this.scrollLeft - walk;
            }

        }));

    });
</script>