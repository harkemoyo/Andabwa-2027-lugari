<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>
        <?php echo e($title ?? config('app.name', 'Dr. Isaac GM Andabwa OGW | Lugari Constituency Empowerment, Scholarships & Community Support')); ?>

    </title>
    <meta name="description"
        content="<?php echo e($description ?? 'The Andabwa Foundation, founded by Dr. Isaac GM Andabwa OGW, is a Kenyan NGO focused on Lugari Constituency empowerment, scholarships, housing projects, Walinzi Sacco development, and community socio-economic transformation.'); ?>">
    <meta name="keywords"
        content="<?php echo e($keywords ?? 'Dr Isaac GM Andabwa OGW, Andabwa Foundation, Lugari Constituency empowerment, Waliniz Sacco, KNPSWU, Scholarships Kenya, NGO in Kakamega, Community empowerment Kenya, Security sector reforms Kenya'); ?>">
    <meta name="author" content="<?php echo e($author ?? config('app.name')); ?>">
    <meta name="robots" content="index, follow">
    
    <link rel="canonical" href="<?php echo e(url()->current()); ?>">
    
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?php echo e($title ?? config('app.name')); ?>">
    <meta property="og:description"
        content="<?php echo e($description ?? 'The Andabwa Foundation is focused on Lugari Constituency empowerment and socio-economic transformation.'); ?>">
    <meta property="og:url" content="<?php echo e(url()->current()); ?>">
    <meta property="og:image" content="<?php echo e($image ?? asset('images/default-og.jpg')); ?>">
    <meta property="og:site_name" content="<?php echo e(config('app.name')); ?>">
    
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo e($title ?? config('app.name')); ?>">
    <meta name="twitter:description"
        content="<?php echo e($description ?? 'The Andabwa Foundation is focused on Lugari Constituency empowerment and socio-economic transformation.'); ?>">
    <meta name="twitter:image" content="<?php echo e($image ?? asset('images/default-og.jpg')); ?>">
    <meta name="referrer" content="no-referrer-when-downgrade">
    
    <link rel="icon" sizes="48x48" href="<?php echo e(asset('favicon.ico')); ?>" type="image/x-icon">
    <link rel="icon" sizes="48x48" type="image/svg+xml" href="<?php echo e(asset('favicon.svg')); ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="48x48" href="/favicon-48x48.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Blog",
            "name": "<?php echo e(config('app.name')); ?>",
            "url": "<?php echo e(url('/')); ?>",
            "description": "<?php echo e($description ?? 'The Andabwa Foundation focuses on community socio-economic transformation.'); ?>"
        }
    </script>
    <!-- alpine persist -->
    <script src="//unpkg.com/@alpinejs/persist" defer></script>
    <?php if (isset($component)) { $__componentOriginal5a71c2c3670795ec464153e22b9d2874 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5a71c2c3670795ec464153e22b9d2874 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => '03db6e0cd5ec767f8e4a0b6db3b1f6cf::google-analytics','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('google-analytics'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5a71c2c3670795ec464153e22b9d2874)): ?>
<?php $attributes = $__attributesOriginal5a71c2c3670795ec464153e22b9d2874; ?>
<?php unset($__attributesOriginal5a71c2c3670795ec464153e22b9d2874); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5a71c2c3670795ec464153e22b9d2874)): ?>
<?php $component = $__componentOriginal5a71c2c3670795ec464153e22b9d2874; ?>
<?php unset($__componentOriginal5a71c2c3670795ec464153e22b9d2874); ?>
<?php endif; ?>
    
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <style>
        /* =========================================
       1. BASE UTILITIES & SCROLLBARS
       ========================================= */
        [x-cloak] {
            display: none !important;
        }

        /* Ensure no visual scrollbars while keeping functionality */
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* =========================================
       2. HARDWARE ACCELERATION (GPU OPTIMIZATION)
       ========================================= */
        img,
        video {
            backface-visibility: hidden;
            transform: translateZ(0);
        }

        /* Ultra-smooth rendering for infinite sliders */
        [x-ref="track"] {
            will-change: scroll-position, transform;
            -webkit-overflow-scrolling: touch;
            backface-visibility: hidden;
            transform: translateZ(0);
        }

        /* =========================================
       3. 3D & ROTATIONS
       ========================================= */
        .perspective {
            perspective: 1000px;
        }

        .backface-hidden {
            backface-visibility: hidden;
            transform-style: preserve-3d;
        }

        .rotateY-0 {
            transform: rotateY(0deg);
        }

        .rotateY-90 {
            transform: rotateY(90deg);
        }

        .-rotateY-90 {
            transform: rotateY(-90deg);
        }

        /* =========================================
       4. TAILWIND CUSTOM COMPONENTS & MODALS
       ========================================= */
        .close-widget-btn {
            @apply absolute top-3 right-3 z-50 p-1.5 rounded-full bg-white/80 backdrop-blur-sm border border-gray-200 text-gray-400 hover:text-gray-600 hover:bg-white transition-all duration-200 shadow-sm;
        }

        dialog[id^="youtube-modal-"] {
            animation: slideIn 0.3s ease-out;
            backdrop-filter: blur(4px);
        }

        dialog[id^="youtube-modal-"]::backdrop {
            background-color: rgba(0, 0, 0, 0.9);
        }

        @media (max-width: 768px) {
            dialog[id^="youtube-modal-"] {
                width: 100% !important;
                height: 100% !important;
                margin: 0 !important;
                border-radius: 0 !important;
            }
        }

        /* =========================================
       5. ANIMATIONS & EFFECTS
       ========================================= */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .visit-source-blink {
            animation: blink-visit-source 2s ease-in-out infinite;
            background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%) !important;
        }

        .visit-source-blink:hover {
            animation: none;
            background: linear-gradient(135deg, #b91c1c 0%, #dc2626 100%) !important;
            transform: scale(1.1) !important;
        }

        @keyframes blink-visit-source {

            0%,
            100% {
                opacity: 1;
                transform: scale(1);
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            }

            50% {
                opacity: 0.8;
                transform: scale(1.05);
                box-shadow: 0 10px 15px -3px rgba(220, 38, 38, 0.3), 0 4px 6px -2px rgba(220, 38, 38, 0.2);
            }
        }

        .animate-ticker {
            display: flex;
            animation: ticker 25s linear infinite;
        }

        @keyframes ticker {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        .social-hover:hover {
            animation: soft-bounce 0.4s ease;
        }

        @keyframes soft-bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-3px);
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .transition-all {
                transition: none !important;
            }
        }

        .animate-gradient-x {
            animation: gradient-x 3s ease infinite;
        }

        @keyframes gradient-x {

            0%,
            100% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }
        }

        .shimmer {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }

        @keyframes shimmer {
            0% {
                background-position: 200% 0;
            }

            100% {
                background-position: -200% 0;
            }
        }
    </style>


    
    <?php echo $__env->yieldContent('meta'); ?>
</head>

<body class="antialiased bg-gray-50 text-gray-900">
    <div
        wire:loading.delay.long
        class="fixed top-0 left-0 h-[2px] bg-gradient-to-r from-pink-500 to-purple-500 z-[9999] w-full animate-pulse"></div>
    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('dynamic-navbar', []);

$__keyOuter = $__key ?? null;

$__key = null;
$__componentSlots = [];

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-481774853-0', $__key);

$__html = app('livewire')->mount($__name, $__params, $__key, $__componentSlots);

echo $__html;

unset($__html);
unset($__key);
$__key = $__keyOuter;
unset($__keyOuter);
unset($__name);
unset($__params);
unset($__componentSlots);
unset($__split);
?>
    <!-- Auth Modal -->

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($slot)): ?>
    <?php echo e($slot); ?>

    <?php else: ?>
    <?php echo $__env->yieldContent('content'); ?>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('footer-section', []);

$__keyOuter = $__key ?? null;

$__key = null;
$__componentSlots = [];

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-481774853-1', $__key);

$__html = app('livewire')->mount($__name, $__params, $__key, $__componentSlots);

echo $__html;

unset($__html);
unset($__key);
$__key = $__keyOuter;
unset($__keyOuter);
unset($__name);
unset($__params);
unset($__componentSlots);
unset($__split);
?>
    
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>


    <script>
        // =========================================
        // 1. GLOBAL UTILITIES
        // =========================================
        function loadAd(el) {
            if (el.dataset.loaded === 'true') return;
            const content = el.querySelector('[data-ad-content]');
            if (content) content.innerHTML = content.dataset.src;
            el.dataset.loaded = 'true';
        }

        // Custom Event Dispatcher Example (Navbar Trigger)
        window.dispatchEvent(new CustomEvent('menu-updating', {
            detail: {
                id: 1,
                title: 'New Title'
            }
        }));

        // =========================================
        // 2. LIVEWIRE & ECHO LISTENERS
        // =========================================
        document.addEventListener('livewire:initialized', () => {
            let pendingScroll = false;

            Livewire.hook('request', ({
                options
            }) => {
                if (!options?.payload?.updates) return;
                const isPaginationUpdate = options.payload.updates.some(u =>
                    u.type === 'callMethod' && ['gotoPage', 'nextPage', 'previousPage'].includes(u.payload?.method)
                );
                if (isPaginationUpdate) pendingScroll = true;
            });

            Livewire.hook('morph.updated', () => {
                if (!pendingScroll) return;
                pendingScroll = false;
                document.getElementById('posts-section')?.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            });
        });

        window.addEventListener('auth-changed', () => {
            if (window.Alpine) Alpine.store('nav').reset();
        });

        window.addEventListener('storage', (event) => {
            if (event.key === 'menus-sync') {
                Livewire.dispatch('reloadMenus', JSON.parse(event.newValue));
            }
        });

        document.addEventListener('DOMContentLoaded', () => {
            if (!window.Echo) return;
            window.Echo.channel('ui-updates').listen('.MenusUpdated', (e) => {
                localStorage.setItem('menus-sync', JSON.stringify({
                    ...e,
                    time: Date.now()
                }));
            });
            window.Echo.channel('menus').listen('.menu.updated', () => {
                Livewire.dispatch('menuUpdated');
                if (window.Alpine) Alpine.store('nav').closeMobile();
            });
            window.Echo.channel('breaking-news').listen('.breaking.updated', () => {
                Livewire.dispatch('menuUpdated');
                if (window.Alpine) Alpine.store('nav').closeMobile();
            });
        });

        // =========================================
        // 3. ALPINE.JS INIT (Stores, Effects, Data)
        // =========================================
        document.addEventListener('alpine:init', () => {

            // --- STORE: NAV ---
            Alpine.store('nav', {
                mobileOpen: false,
                activeIndex: null,
                openMobile() {
                    this.mobileOpen = true;
                    document.body.classList.add('overflow-hidden');
                },
                closeMobile() {
                    this.mobileOpen = false;
                    this.activeIndex = null;
                    document.body.classList.remove('overflow-hidden');
                },
                toggleMobile() {
                    this.mobileOpen ? this.closeMobile() : this.openMobile();
                },
                setActive(i) {
                    this.activeIndex = this.activeIndex === i ? null : i;
                },
                reset() {
                    this.activeIndex = null;
                }
            });

            // --- GLOBAL EFFECTS ---
            Alpine.effect(() => {
                window.addEventListener('open-external', e => {
                    if (e.detail.url) window.open(e.detail.url, '_blank', 'noopener,noreferrer');
                });
            });

            // --- COMPONENT: Sidebar Manager ---
            Alpine.data('sidebarManager', (config) => ({
                activeIndex: 0,
                isOpen: true,
                timer: null,
                queue: [],
                init() {
                    if (config?.totalWidgets === 0) {
                        this.isOpen = false;
                        return;
                    }
                    this.buildQueue();
                    this.loadAdContent();
                    this.startRotation();
                },
                buildQueue() {
                    this.queue = [];
                    Array.from(this.$el.querySelectorAll('[data-widget-id], [data-id]')).forEach((el, idx) => {
                        const weight = parseInt(el.dataset.weight || 1);
                        for (let i = 0; i < weight; i++) this.queue.push(idx);
                    });
                },
                startRotation() {
                    if (this.queue.length <= 1) return;
                    this.stopRotation();
                    this.timer = setInterval(() => this.rotate(), config?.duration || 5000);
                },
                stopRotation() {
                    clearInterval(this.timer);
                },
                rotate() {
                    this.queue.push(this.queue.shift());
                    this.activeIndex = this.queue[0];
                    this.loadAdContent();
                    this.trackImpression();
                },
                loadAdContent() {
                    this.$nextTick(() => {
                        const current = this.$el.children[this.activeIndex];
                        if (!current) return;
                        const dataTarget = current.querySelector('[data-src], [data-ad-content]');
                        if (dataTarget && !current.dataset.loaded) {
                            dataTarget.innerHTML = dataTarget.dataset.src;
                            current.dataset.loaded = "true";
                        }
                    });
                },

                // 3D ROTATIONS
                trackImpression() {
                    const el = this.$el.children[this.activeIndex];
                    if (!el || !el.dataset.id) return;
                    fetch('/widget/impression', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                        },
                        body: JSON.stringify({
                            widget_id: el.dataset.id
                        })
                    }).catch(() => console.warn('Impression tracking failed'));
                },
                syncData() {
                    this.stopRotation();
                    this.buildQueue();
                    this.startRotation();
                },
                closeSidebar() {
                    this.isOpen = false;
                    this.stopRotation();
                }
            }));
        });

        // =========================================
        // 4. ALPINE COMPONENT FUNCTIONS 
        // =========================================
        function navSystem() {
            return {
                closeAll() {
                    Alpine.store('nav').closeMobile();
                    document.querySelectorAll('[x-data^="dropdown"]').forEach(el => {
                        if (el.__x) el.__x.$data.open = false;
                    });
                }
            };
        }

        function dropdown() {
            return {
                open: false,
                timeout: null,
                handleEnter() {
                    clearTimeout(this.timeout);
                    this.timeout = setTimeout(() => this.open = true, 120);
                },
                handleLeave() {
                    clearTimeout(this.timeout);
                    this.timeout = setTimeout(() => this.open = false, 150);
                },
                toggle() {
                    this.open = !this.open;
                },
                close() {
                    this.open = false;
                },
                openAndFocusFirst() {
                    this.open = true;
                    this.$nextTick(() => this.$el.querySelector('[role="menuitem"]')?.focus());
                }
            };
        }

        function slider() {
            return {
                current: 0,
                total: 0,
                perView: 1,
                init() {
                    this.calculate();
                    window.addEventListener('resize', () => this.calculate());
                    setInterval(() => this.next(), 8000);
                },
                calculate() {
                    const w = window.innerWidth;
                    this.perView = w >= 1024 ? 3 : (w >= 768 ? 2 : 1);
                    this.total = this.$refs.container.children.length;
                },
                next() {
                    this.current = (this.current < this.total - this.perView) ? this.current + 1 : 0;
                    this.scroll();
                },
                prev() {
                    this.current = (this.current > 0) ? this.current - 1 : this.total - this.perView;
                    this.scroll();
                },
                scroll() {
                    const cardWidth = this.$refs.container.children[0].offsetWidth + 24;
                    this.$refs.container.scrollTo({
                        left: this.current * cardWidth,
                        behavior: 'smooth'
                    });
                }
            };
        }

        // Refactored GPU-optimized Infinite Slider
        function insaneInfiniteSlider() {
            return {
                raf: null,
                speed: 0.5,
                isPaused: false,
                progress: 0,
                exactScroll: 0,
                oneSetWidth: 0,
                isManualScrolling: false,

                init() {
                    const el = this.$refs.track;
                    this.$nextTick(() => {
                        this.calculateMetrics();
                        this.exactScroll = this.oneSetWidth;
                        el.scrollLeft = this.exactScroll;
                        this.startSmoothScroll();
                        this.handleScrollEvents();
                    });

                    let resizeTimer;
                    window.addEventListener('resize', () => {
                        clearTimeout(resizeTimer);
                        resizeTimer = setTimeout(() => {
                            this.calculateMetrics();
                            this.exactScroll = this.oneSetWidth;
                            el.scrollLeft = this.exactScroll;
                        }, 150);
                    });
                },

                calculateMetrics() {
                    this.oneSetWidth = this.$refs.track.scrollWidth / 3;
                },

                startSmoothScroll() {
                    const el = this.$refs.track;
                    const step = () => {
                        if (!this.isPaused && !this.isManualScrolling) {
                            this.exactScroll += this.speed;

                            if (this.exactScroll >= this.oneSetWidth * 2) {
                                this.exactScroll -= this.oneSetWidth;
                            } else if (this.exactScroll <= 0) {
                                this.exactScroll += this.oneSetWidth;
                            }

                            el.scrollLeft = this.exactScroll;
                            this.progress = ((this.exactScroll % this.oneSetWidth) / this.oneSetWidth) * 100;
                        }
                        this.raf = requestAnimationFrame(step);
                    };
                    this.raf = requestAnimationFrame(step);
                },

                scroll(dir) {
                    const el = this.$refs.track;
                    const card = el.querySelector('.group');
                    const gap = 20;
                    const amount = ((card ? card.offsetWidth : 300) + gap) * 2;

                    this.isManualScrolling = true;
                    el.scrollBy({
                        left: dir * amount,
                        behavior: 'smooth'
                    });

                    setTimeout(() => {
                        this.exactScroll = el.scrollLeft;
                        this.isManualScrolling = false;
                    }, 600);
                },

                pause() {
                    this.isPaused = true;
                },
                play() {
                    this.exactScroll = this.$refs.track.scrollLeft;
                    this.isPaused = false;
                },

                handleScrollEvents() {
                    const el = this.$refs.track;
                    el.addEventListener('scroll', () => {
                        if (this.isPaused || this.isManualScrolling) {
                            this.exactScroll = el.scrollLeft;

                            if (this.exactScroll >= this.oneSetWidth * 2) {
                                el.style.scrollBehavior = 'auto';
                                this.exactScroll -= this.oneSetWidth;
                                el.scrollLeft = this.exactScroll;
                                el.style.scrollBehavior = '';
                            } else if (this.exactScroll <= 0) {
                                el.style.scrollBehavior = 'auto';
                                this.exactScroll += this.oneSetWidth;
                                el.scrollLeft = this.exactScroll;
                                el.style.scrollBehavior = '';
                            }

                            this.progress = ((this.exactScroll % this.oneSetWidth) / this.oneSetWidth) * 100;
                        }
                    }, {
                        passive: true
                    }); // Passive prevents scroll blocking
                }
            };
        }

        // Top Post Card Slider
        function infiniteSlider(total) {
            return {
                active: 0,
                total: total,
                jumping: false,
                timer: null,

                init() {
                    this.play();
                },
                next() {
                    if (this.active === this.total - 1) {
                        this.jumping = true;
                        this.active = 0;
                        requestAnimationFrame(() => this.jumping = false);
                    } else {
                        this.active++;
                    }
                },
                prev() {
                    if (this.active === 0) {
                        this.jumping = true;
                        this.active = this.total - 1;
                        requestAnimationFrame(() => this.jumping = false);
                    } else {
                        this.active--;
                    }
                },
                go(i) {
                    this.active = i;
                },
                play() {
                    this.timer = setInterval(() => this.next(), 9000);
                }, // Updated to 9s
                pause() {
                    clearInterval(this.timer);
                },
                get progress() {
                    return ((this.active + 1) / this.total) * 100;
                }
            };
        }

        function socialDock() {
            return {
                activeIndex: null,
                intentTimeout: null,
                startIntent(index) {
                    clearTimeout(this.intentTimeout);
                    this.intentTimeout = setTimeout(() => this.activeIndex = index, 120);
                },
                reset() {
                    clearTimeout(this.intentTimeout);
                    this.activeIndex = null;
                },
                getStyle(index) {
                    if (this.activeIndex === null) return 'transform: scale(1)';
                    const distance = Math.abs(index - this.activeIndex);
                    let scale = 1;
                    if (distance === 0) scale = 1.6;
                    else if (distance === 1) scale = 1.3;
                    else if (distance === 2) scale = 1.1;
                    return `transform: scale(${scale}); z-index: ${10 - distance}; transition: transform 0.2s cubic-bezier(0.25, 1, 0.5, 1);`;
                }
            };
        }
    </script>

    
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('socialDock', () => ({
                activeIndex: null,

                init() {
                    // Initialization logic if needed
                },

                onMouseMove(event) {
                    // Placeholder for future proximity scaling logic
                },

                setFocus(index) {
                    this.activeIndex = index;
                },

                startIntent(index) {
                    this.activeIndex = index;
                },

                cancelIntent() {
                    this.activeIndex = null;
                },

                reset() {
                    this.activeIndex = null;
                },

                getStyle(index) {
                    // Return active scaling for the hovered/focused item
                    if (this.activeIndex === index) {
                        return 'transform: scale(1.15); z-index: 10;';
                    }
                    return 'transform: scale(1); z-index: 1;';
                }
            }))
        })
    </script>

    
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('sidebarManager', ({
                duration,
                totalWidgets
            }) => ({
                isOpen: true,
                activeIndex: 0,
                interval: null,

                init() {
                    if (totalWidgets > 1) {
                        this.startRotation();
                    }
                },

                startRotation() {
                    this.interval = setInterval(() => {
                        this.activeIndex = (this.activeIndex + 1) % totalWidgets;
                    }, duration);
                },

                syncData() {
                    // Resets cycle cleanly when Livewire emits an update
                    clearInterval(this.interval);
                    this.activeIndex = 0;
                    if (totalWidgets > 1) {
                        this.startRotation();
                    }
                },

                closeSidebar() {
                    this.isOpen = false;
                    clearInterval(this.interval);
                }
            }));
        });
    </script>
    <?php if (isset($component)) { $__componentOriginalefff21bb4c0b92d5db12000d524d9f07 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalefff21bb4c0b92d5db12000d524d9f07 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modals.login-modal','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modals.login-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalefff21bb4c0b92d5db12000d524d9f07)): ?>
<?php $attributes = $__attributesOriginalefff21bb4c0b92d5db12000d524d9f07; ?>
<?php unset($__attributesOriginalefff21bb4c0b92d5db12000d524d9f07); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalefff21bb4c0b92d5db12000d524d9f07)): ?>
<?php $component = $__componentOriginalefff21bb4c0b92d5db12000d524d9f07; ?>
<?php unset($__componentOriginalefff21bb4c0b92d5db12000d524d9f07); ?>
<?php endif; ?>
</body>

</html><?php /**PATH C:\Users\Rygss\Downloads\andabwa-2027\resources\views\components/layouts/app.blade.php ENDPATH**/ ?>