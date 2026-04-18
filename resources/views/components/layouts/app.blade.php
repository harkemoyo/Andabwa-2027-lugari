<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Primary SEO --}}
    <title>
        {{ $title ?? config('app.name', 'Dr. Isaac GM Andabwa OGW | Lugari Constituency Empowerment, Scholarships & Community Support') }}
    </title>
    <meta name="description"
        content="{{ $description ?? 'The Andabwa Foundation, founded by Dr. Isaac GM Andabwa OGW, is a Kenyan NGO focused on Lugari Constituency empowerment, scholarships, housing projects, Walinzi Sacco development, and community socio-economic transformation.' }}">
    <meta name="keywords"
        content="{{ $keywords ?? 'Dr Isaac GM Andabwa OGW, Andabwa Foundation, Lugari Constituency empowerment, Waliniz Sacco, KNPSWU, Scholarships Kenya, NGO in Kakamega, Community empowerment Kenya, Security sector reforms Kenya' }}">
    <meta name="author" content="{{ $author ?? config('app.name') }}">
    <meta name="robots" content="index, follow">
    {{-- Canonical URL --}}
    <link rel="canonical" href="{{ url()->current() }}">
    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $title ?? config('app.name') }}">
    <meta property="og:description"
        content="{{ $description ?? 'The Andabwa Foundation is focused on Lugari Constituency empowerment and socio-economic transformation.' }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ $image ?? asset('images/default-og.jpg') }}">
    <meta property="og:site_name" content="{{ config('app.name') }}">
    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $title ?? config('app.name') }}">
    <meta name="twitter:description"
        content="{{ $description ?? 'The Andabwa Foundation is focused on Lugari Constituency empowerment and socio-economic transformation.' }}">
    <meta name="twitter:image" content="{{ $image ?? asset('images/default-og.jpg') }}">
    {{-- Favicon --}}
    <link rel="icon" sizes="48x48" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="icon" sizes="48x48" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="48x48" href="/favicon-48x48.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script type="application/ld+json">
        {
            "@@context": "https://schema.org",
            "@@type": "Blog",
            "name": "{{ config('app.name') }}",
            "url": "{{ url('/') }}",
            "description": "{{ $description ?? 'The Andabwa Foundation focuses on community socio-economic transformation.' }}"
        }
    </script>
    <x-google-analytics />
    {{-- Styles --}}
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Custom CSS for external content --}}
    <style>
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

        .visit-source-blink {
            animation: blink-visit-source 2s ease-in-out infinite;
            background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%) !important;
        }

        .visit-source-blink:hover {
            animation: none;
            background: linear-gradient(135deg, #b91c1c 0%, #dc2626 100%) !important;
            transform: scale(1.1) !important;
        }

        /* YouTube Video Modal Styles */
        dialog[id^="youtube-modal-"] {
            backdrop-filter: blur(4px);
        }

        dialog[id^="youtube-modal-"]::backdrop {
            background-color: rgba(0, 0, 0, 0.9);
        }

        dialog[id^="youtube-modal-"] {
            animation: slideIn 0.3s ease-out;
        }

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

        @media (max-width: 768px) {
            dialog[id^="youtube-modal-"] {
                width: 100% !important;
                height: 100% !important;
                margin: 0 !important;
                border-radius: 0 !important;
            }
        }
    </style>
    <!-- Breaking news scroller -->
    <style>
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        @keyframes ticker {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }

            /* Scrolls half the width to loop seamlessly */
        }

        .animate-ticker {
            display: flex;
            animation: ticker 30s linear infinite;
        }
    </style>
    <style>
        img,
        video {
            backface-visibility: hidden;
            transform: translateZ(0);
        }
    </style>
    <!-- top nav marquee -->
    <style>
        @keyframes ticker {
            0% {
                transform: translateX(0%);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        .animate-ticker {
            animation: ticker 25s linear infinite;
        }
    </style>
    <!-- News animations -->
    <style>
        @keyframes ticker {
            0% {
                transform: translateX(0)
            }

            100% {
                transform: translateX(-50%)
            }
        }

        .animate-ticker {
            animation: ticker 25s linear infinite;
        }
    </style>

    <!-- social link css -->
    <style>
        @keyframes soft-bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-3px);
            }
        }

        .social-hover:hover {
            animation: soft-bounce 0.4s ease;
        }

        @media (prefers-reduced-motion: reduce) {
            .transition-all {
                transition: none !important;
            }
        }
    </style>

    {{-- Page-specific meta overrides --}}
    @yield('meta')
</head>

<body class="antialiased bg-gray-50 text-gray-900">

    <livewire:dynamic-navbar />
    <!-- Auth Modal -->
    <div x-data
        x-show="$store.nav.authModal"
        x-transition
        x-cloak
        class="fixed inset-0 bg-black/50 z-[999] flex items-center justify-center">
        <div @click.outside="$store.nav.closeAuth()"
            class="bg-white p-6 rounded-xl w-full max-w-md">
            <h2 class="text-lg font-bold mb-4">Login</h2>
            {{-- YOUR LOGIN FORM HERE --}}
            <button @click="$store.nav.closeAuth()"
                class="mt-4 text-sm text-gray-500">
                Close
            </button>
        </div>
    </div>
    @if(isset($slot))
    {{ $slot }}
    @else
    @yield('content')
    @endif

    <livewire:footer-section />
    {{-- Authentication Modals --}}
    @livewireScripts

    <script>
        document.addEventListener('livewire:initialized', () => {
            let pendingScroll = false;

            Livewire.hook('request', ({
                options
            }) => {
                if (!options?.payload?.updates) return;

                const isPaginationUpdate = options.payload.updates.some((u) => {
                    return u.type === 'callMethod' && ['gotoPage', 'nextPage', 'previousPage']
                        .includes(u.payload?.method);
                });

                if (isPaginationUpdate) {
                    pendingScroll = true;
                }
            });

            Livewire.hook('morph.updated', () => {
                if (!pendingScroll) return;
                pendingScroll = false;

                const el = document.getElementById('posts-section');
                if (!el) return;

                el.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            });
        });
    </script>
    <script>
        function slider() {
            return {
                current: 0,
                total: 0,
                perView: 1,

                init() {
                    this.calculate()
                    window.addEventListener('resize', () => this.calculate())

                    // AUTO SLIDE (optional but professional)
                    setInterval(() => {
                        this.next()
                    }, 5000)
                },

                calculate() {
                    const width = window.innerWidth

                    if (width >= 1024) {
                        this.perView = 3
                    } else if (width >= 768) {
                        this.perView = 2
                    } else {
                        this.perView = 1
                    }

                    this.total = this.$refs.container.children.length
                },

                next() {
                    if (this.current < this.total - this.perView) {
                        this.current++
                    } else {
                        this.current = 0 // loop
                    }

                    this.scroll()
                },

                prev() {
                    if (this.current > 0) {
                        this.current--
                    } else {
                        this.current = this.total - this.perView
                    }

                    this.scroll()
                },

                scroll() {
                    const container = this.$refs.container
                    const cardWidth = container.children[0].offsetWidth + 24 // gap

                    container.scrollTo({
                        left: this.current * cardWidth,
                        behavior: 'smooth'
                    })
                }
            }
        }
    </script>
    <script>
        function insaneInfiniteSlider() {
            return {
                interval: null,
                progress: 0,
                maxScroll: 1,

                init() {
                    const el = this.$refs.track;

                    this.$nextTick(() => {
                        const oneSet = el.scrollWidth / 3;
                        this.maxScroll = oneSet;

                        // start middle
                        el.scrollLeft = oneSet;

                        this.loop();
                        this.autoPlay();
                        this.trackProgress();
                        this.handleInfinite();
                    });

                    window.addEventListener('resize', () => {
                        this.recalculate();
                    });
                },

                getStep() {
                    if (window.innerWidth >= 1024) return 3;
                    if (window.innerWidth >= 640) return 2;
                    return 1;
                },

                scroll(dir) {
                    const el = this.$refs.track;
                    const card = el.querySelector('.card');
                    const gap = 20;

                    const step = this.getStep();
                    const amount = (card.offsetWidth + gap) * step;

                    el.scrollBy({
                        left: dir * amount,
                        behavior: 'smooth'
                    });
                },

                handleInfinite() {
                    const el = this.$refs.track;

                    el.addEventListener('scroll', () => {
                        const oneSet = el.scrollWidth / 3;

                        if (el.scrollLeft <= 0) {
                            el.scrollLeft = oneSet;
                        }

                        if (el.scrollLeft >= oneSet * 2) {
                            el.scrollLeft = oneSet;
                        }

                        this.progress = (el.scrollLeft % oneSet) / oneSet * 100;
                    });
                },

                trackProgress() {
                    setInterval(() => {
                        const el = this.$refs.track;
                        const oneSet = el.scrollWidth / 3;
                        this.progress = (el.scrollLeft % oneSet) / oneSet * 100;
                    }, 50);
                },

                autoPlay() {
                    this.interval = setInterval(() => {
                        this.scroll(1);
                    }, 10000);
                },

                pause() {
                    clearInterval(this.interval);
                },

                play() {
                    this.autoPlay();
                },

                recalculate() {
                    const el = this.$refs.track;
                    const oneSet = el.scrollWidth / 3;
                    el.scrollLeft = oneSet;
                },

                loop() {
                    // reserved for future physics upgrades
                }
            }
        }
    </script>
    {{-- 🧠 ALPINE LOGIC --}}
    <script>
        function navSystem() {
            return {
                mobileOpen: false,
                closeAll() {
                    this.mobileOpen = false;
                    document.querySelectorAll('[x-data^="dropdown"]').forEach(el => {
                        if (el.__x) el.__x.$data.open = false;
                    });
                },
                init() {}
            }
        }

        function dropdown(index) {
            return {
                open: false,
                timeout: null,

                handleEnter() {
                    clearTimeout(this.timeout);
                    this.timeout = setTimeout(() => {
                        this.open = true;
                    }, 120); // intent delay
                },

                handleLeave() {
                    clearTimeout(this.timeout);
                    this.timeout = setTimeout(() => {
                        this.open = false;
                    }, 150);
                },

                openWithIntent() {
                    this.open = true;
                },

                toggle() {
                    this.open = !this.open;
                },

                close() {
                    this.open = false;
                },

                openAndFocusFirst() {
                    this.open = true;
                    this.$nextTick(() => {
                        this.$el.querySelector('[role="menuitem"]')?.focus();
                    });
                }
            }
        }
    </script>
    {{-- NavJS --}}
    <script>
        document.addEventListener('alpine:init', () => {
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
        });
    </script>
    <script>
        window.Echo.channel('ui-updates')
            .listen('.MenusUpdated', (e) => {

                // 🔁 Broadcast to other tabs
                localStorage.setItem('menus-sync', JSON.stringify({
                    ...e,
                    time: Date.now()
                }));

            });

        // 👂 Listen from other tabs
        window.addEventListener('storage', (event) => {
            if (event.key === 'menus-sync') {
                const data = JSON.parse(event.newValue);

                Livewire.dispatch('reloadMenus', data);
            }
        });
    </script>
    <!-- Navbar Trigger JS -->
    <script>
        window.dispatchEvent(new CustomEvent('menu-updating', {
            detail: {
                id: 1,
                title: 'New Title'
            }
        }));
    </script>
    <!-- Reverb -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (!window.Echo) return;

            window.Echo.channel('menus')
                .listen('.menu.updated', () => {
                    Livewire.dispatch('menuUpdated')

                    // DO NOT break UI state
                    Alpine.store('nav').closeMenu()
                })
        })
    </script>

    <!-- Frontend Listener -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (!window.Echo) return;

            window.Echo.channel('breaking-news')
                .listen('.breaking.updated', () => {
                    Livewire.dispatch('menuUpdated')

                    // preserve UX
                    Alpine.store('nav').closeMenu()
                })
        })
    </script>

    <!-- AUth JS -->
    <script>
        window.addEventListener('auth-changed', () => {
            Alpine.store('nav').reset()
        })
    </script>

    <!-- Social-link JS -->
    <script>
        function socialDock() {
            return {
                activeIndex: null,
                mouseX: 0,
                intentTimeout: null,

                init() {},

                // 🧠 Intent-based hover (delay to prevent flicker)
                startIntent(index) {
                    this.cancelIntent();
                    this.intentTimeout = setTimeout(() => {
                        this.activeIndex = index;
                    }, 120); // sweet spot (Apple-like)
                },

                cancelIntent() {
                    clearTimeout(this.intentTimeout);
                },

                setFocus(index) {
                    this.activeIndex = index;
                },

                reset() {
                    this.activeIndex = null;
                    this.cancelIntent();
                },

                onMouseMove(e) {
                    this.mouseX = e.clientX;
                },

                // 🧲 macOS Dock scaling physics
                getStyle(index) {
                    if (this.activeIndex === null) {
                        return 'transform: scale(1)';
                    }

                    const distance = Math.abs(index - this.activeIndex);

                    let scale = 1;

                    if (distance === 0) scale = 1.6;
                    else if (distance === 1) scale = 1.3;
                    else if (distance === 2) scale = 1.1;

                    return `
                transform: scale(${scale});
                z-index: ${10 - distance};
            `;
                }
            }
        }
    </script>

    <x-modals.login-modal />
    <x-modals.register-modal />
</body>

</html>