
<div class="">
    <section class="relative  overflow-hidden ">

        
        <div class="flex flex-col max-w-[1400px] mx-auto md:flex-row md:items-end justify-between  gap-8 px-4 md:px-6">
            <div class="max-w-3xl ">
                <span class="h-px w-8 bg-gradient-to-r from-purple-600 to-pink-500"></span>
                <h2 class="text-sm md:text-xl  font-bold uppercase tracking-[0.3em] text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-600 italic">
                    <?php echo e($this->pageSettings->latest_title ?? 'Latest Projects.'); ?>

                </h2>
                <p class="text-sm md:text-lg font-normal text-slate-500 mt-2 max-w-2xl">
                    <?php echo e($this->pageSettings->latest_description ?? 'Discover the latest in Dr. GM OGW Andabwa Projects In Lugari Constituency.'); ?>

                </p>
            </div>

            
            <a
                href="<?php echo e(route('blog.all-projects')); ?>"
                wire:navigate
                class="group inline-flex justify-between gap-4 px-2 md:px-4 py-2 bg-slate-950 text-white rounded-2xl hover:bg-purple-700 transition-all duration-500 shadow-2xl shadow-slate-950/20 active:scale-95">
                <span class="text-xs font-black tracking-[0.3em]">
                    <?php echo e($this->pageSettings->view_all_button ?? 'View All'); ?>

                </span>

                <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->latestPosts->isNotEmpty()): ?>
        <div

            x-data="insaneInfiniteSlider()"

            x-init="init()"

            class="relative group mt-8">


            

            <div class="absolute -top-6 left-1/2 -translate-x-1/2 w-1/3 h-[2px] bg-slate-100 rounded-full overflow-hidden">

                <div

                    class="h-full bg-gradient-to-r from-purple-600 via-red-500 to-purple-600 bg-[length:200%_100%] animate-gradient-x transition-all duration-300"
                    :style="`width: ${progress}%`"></div>

            </div>
            
            <div class="hidden md:block absolute inset-y-0 left-0 w-10 bg-gradient-to-r from-white via-white/80 to-transparent z-10 pointer-events-none"></div>
            <div class="hidden md:blockabsolute inset-y-0 right-0 w-10 bg-gradient-to-l from-white via-white/80 to-transparent z-10 pointer-events-none"></div>

            
            <button @click="scroll(-1)"
                class="hidden lg:flex items-center justify-center absolute left-2 top-1/2 -translate-y-1/2 z-30 
            bg-white/90 backdrop-blur-xl border border-slate-200 shadow-xl rounded-2xl w-12 h-12
            hover:text-purple-600 transition-all duration-300 text-sm  hover:border-red-400 transition-all duration-300">
                ←
            </button>

            <button @click="scroll(1)"
                class="hidden lg:flex items-center justify-center absolute right-2 top-1/2 -translate-y-1/2 z-30 
            bg-white/90 backdrop-blur-xl border border-slate-200 shadow-xl rounded-2xl w-12 h-12
             transition-all duration-300 text-sm  hover:text-purple-600 transition-all duration-300   hover:border-red-400 transition-all duration-300">
                →
            </button>



            

            <div

                x-ref="track"

                @mouseenter="pause()"

                @mouseleave="play()"

                class="flex overflow-x-auto gap-5 px-1 lg:px-12 py-5

               snap-x snap-mandatory scroll-smooth

               scrollbar-hide cursor-grab active:cursor-grabbing bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-3">



                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $this->latestPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <?php echo $__env->make('components.blog.post-card', ['post' => $post], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $this->latestPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <?php echo $__env->make('components.blog.post-card', ['post' => $post], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $this->latestPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <?php echo $__env->make('components.blog.post-card', ['post' => $post], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </section>










    
    <section class="relative overflow-hidden">
        
        <div class="flex flex-col max-w-[1400px] mx-auto md:flex-row md:items-end justify-between gap-8 px-4 md:px-6">
            <div class="max-w-3xl">
                <span class="h-px w-8 bg-gradient-to-r from-purple-600 to-pink-500 block mb-2"></span>
                <h2 class="text-sm md:text-xl font-bold uppercase tracking-[0.3em] text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-600 italic">
                    <?php echo e($this->pageSettings->latest_title ?? 'Latest Projects.'); ?>

                </h2>
                <p class="text-sm md:text-lg font-normal text-slate-500 mt-2 max-w-2xl">
                    <?php echo e($this->pageSettings->latest_description ?? 'Discover the latest in Dr. GM OGW Andabwa Projects In Lugari Constituency.'); ?>

                </p>
            </div>

            <a href="<?php echo e(route('blog.all-projects')); ?>"
                wire:navigate
                class="group inline-flex justify-between items-center gap-4 px-3 md:px-5 py-2.5 bg-slate-950 text-white rounded-2xl hover:bg-purple-700 transition-all duration-300 shadow-xl shadow-slate-950/20 active:scale-95 will-change-transform">
                <span class="text-xs font-black tracking-[0.3em]">
                    <?php echo e($this->pageSettings->view_all_button ?? 'View All'); ?>

                </span>
                <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                </svg>
            </a>
        </div>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->latestPosts->isNotEmpty()): ?>
        <div x-data="insaneInfiniteSlider()"
            x-init="init()"
            class="relative group mt-8">

            
            <div class="absolute -top-6 left-1/2 -translate-x-1/2 w-1/3 h-[2px] bg-slate-100 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-purple-600 via-red-500 to-purple-600 bg-[length:200%_100%] animate-gradient-x transition-all duration-75 ease-out"
                    :style="`width: ${progress}%`"></div>
            </div>

            
            <div class="hidden md:block absolute inset-y-0 left-0 w-16 bg-gradient-to-r from-white to-transparent z-10 pointer-events-none transform-gpu"></div>
            <div class="hidden md:block absolute inset-y-0 right-0 w-16 bg-gradient-to-l from-white to-transparent z-10 pointer-events-none transform-gpu"></div>

            
            <button @click="scrollManual(-1)"
                aria-label="Scroll left"
                class="hidden lg:flex items-center justify-center absolute left-4 top-1/2 -translate-y-1/2 z-20 
            bg-white/90 backdrop-blur-xl border border-slate-200 shadow-xl rounded-full w-12 h-12
            hover:text-purple-600 hover:border-purple-400 hover:scale-105 transition-all duration-300 active:scale-95 text-xl">
                ←
            </button>

            <button @click="scrollManual(1)"
                aria-label="Scroll right"
                class="hidden lg:flex items-center justify-center absolute right-4 top-1/2 -translate-y-1/2 z-20 
            bg-white/90 backdrop-blur-xl border border-slate-200 shadow-xl rounded-full w-12 h-12
            hover:text-purple-600 hover:border-purple-400 hover:scale-105 transition-all duration-300 active:scale-95 text-xl">
                →
            </button>

            
            <div x-ref="track"
                @mouseenter="pause()"
                @mouseleave="resume()"
                @mousedown="startDrag($event)"
                @mousemove="onDrag($event)"
                @mouseup="endDrag()"
                @mouseleave="endDrag()"
                class="flex overflow-x-auto gap-5 px-4 lg:px-12 py-5 
                   scrollbar-hide will-change-scroll transform-gpu 
                   cursor-grab active:cursor-grabbing bg-white rounded-2xl 
                   shadow-lg hover:shadow-xl transition-shadow duration-300 select-none">

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $this->latestPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <div class="shrink-0 w-[280px] md:w-[320px]">
                    <?php echo $__env->make('components.blog.post-card', ['post' => $post], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $this->latestPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <div class="shrink-0 w-[280px] md:w-[320px]">
                    <?php echo $__env->make('components.blog.post-card', ['post' => $post], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $this->latestPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <div class="shrink-0 w-[280px] md:w-[320px]">
                    <?php echo $__env->make('components.blog.post-card', ['post' => $post], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </section>
</div>


<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('insaneInfiniteSlider', () => ({
            track: null,
            progress: 0,
            isPaused: false,
            animationId: null,
            speed: 1.5, // Adjust this for faster/slower auto-scroll

            // Dragging state
            isDragging: false,
            startX: 0,
            scrollLeftStart: 0,

            // Cached dimensions to prevent layout thrashing
            sectionWidth: 0,

            init() {
                this.track = this.$refs.track;

                // Wait for DOM to render to calculate widths
                this.$nextTick(() => {
                    this.calculateDimensions();
                    // Jump to the middle "Original" section to allow scrolling both ways
                    this.track.scrollLeft = this.sectionWidth;

                    this.setupIntersectionObserver();
                    this.startAutoScroll();
                });

                // Recalculate on window resize
                window.addEventListener('resize', this.debounce(() => {
                    this.calculateDimensions();
                }, 250));

                // Native scroll event for progress bar (Passive for performance)
                this.track.addEventListener('scroll', () => {
                    this.updateProgress();
                    this.handleInfiniteLoop();
                }, {
                    passive: true
                });
            },

            calculateDimensions() {
                // Total width divided by 3 (since we have 3 identical loops)
                this.sectionWidth = this.track.scrollWidth / 3;
            },

            startAutoScroll() {
                if (this.isPaused || this.isDragging) return;

                // Ensure no CSS smoothing is fighting the JS loop
                this.track.style.scrollBehavior = 'auto';
                this.track.scrollLeft += this.speed;

                this.animationId = requestAnimationFrame(() => this.startAutoScroll());
            },

            pause() {
                this.isPaused = true;
                cancelAnimationFrame(this.animationId);
            },

            resume() {
                this.isPaused = false;
                if (!this.isDragging) {
                    this.startAutoScroll();
                }
            },

            handleInfiniteLoop() {
                // If we scrolled past the right clone, snap back to the center
                if (this.track.scrollLeft >= this.sectionWidth * 2) {
                    this.track.style.scrollBehavior = 'auto';
                    this.track.scrollLeft -= this.sectionWidth;
                }
                // If we scrolled past the left clone, snap forward to the center
                else if (this.track.scrollLeft <= 0) {
                    this.track.style.scrollBehavior = 'auto';
                    this.track.scrollLeft += this.sectionWidth;
                }
            },

            scrollManual(direction) {
                this.pause();

                // Turn on CSS smooth scroll just for the button click
                this.track.style.scrollBehavior = 'smooth';

                // Scroll by 80% of the visible container width
                const scrollAmount = this.track.clientWidth * 0.8;
                this.track.scrollBy({
                    left: scrollAmount * direction
                });

                // Resume auto-scroll after the animation finishes
                setTimeout(() => {
                    this.resume();
                }, 600);
            },

            updateProgress() {
                // Calculate progress based strictly on the middle "original" section
                let currentScroll = this.track.scrollLeft - this.sectionWidth;
                let percent = (currentScroll / this.sectionWidth) * 100;

                // Clamp between 0 and 100
                this.progress = Math.max(0, Math.min(100, percent));
            },

            // --- Dragging Logic ---
            startDrag(e) {
                this.isDragging = true;
                this.pause();
                this.track.style.scrollBehavior = 'auto'; // Prevent rubber-banding
                this.startX = e.pageX - this.track.offsetLeft;
                this.scrollLeftStart = this.track.scrollLeft;
            },

            onDrag(e) {
                if (!this.isDragging) return;
                e.preventDefault(); // Prevent text selection
                const x = e.pageX - this.track.offsetLeft;
                const walk = (x - this.startX) * 1.5; // Drag speed multiplier
                this.track.scrollLeft = this.scrollLeftStart - walk;
            },

            endDrag() {
                if (!this.isDragging) return;
                this.isDragging = false;
                this.resume();
            },

            // --- Performance/Optimization Tools ---
            setupIntersectionObserver() {
                // Only run the animation when the slider is actually on the screen
                const observer = new IntersectionObserver((entries) => {
                    if (entries[0].isIntersecting) {
                        this.resume();
                    } else {
                        this.pause();
                    }
                });
                observer.observe(this.$el);
            },

            debounce(func, wait) {
                let timeout;
                return function executedFunction(...args) {
                    const later = () => {
                        clearTimeout(timeout);
                        func(...args);
                    };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            }
        }));
    });
</script><?php /**PATH C:\Users\Rygss\Downloads\andabwa-2027\resources\views/components/blog/latest-post-bottom.blade.php ENDPATH**/ ?>