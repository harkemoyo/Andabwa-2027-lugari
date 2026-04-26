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
    <meta name="referrer" content="no-referrer-when-downgrade">
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
    <!-- alpine persist -->
    <script src="//unpkg.com/@alpinejs/persist" defer></script>
    <x-google-analytics />
    {{-- Styles --}}
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Page-specific meta overrides --}}
    @yield('meta')
</head>

<body class="antialiased  text-gray-900" >
    <div
        wire:loading.delay.long
        class="fixed top-0 left-0 h-[2px] bg-gradient-to-r from-pink-500 to-purple-500 z-[9999] w-full animate-pulse"></div>
    <livewire:dynamic-navbar />
    <!-- Auth Modal -->

    @if(isset($slot))
    {{ $slot }}
    @else
    @yield('content')
    @endif

    <livewire:footer-section />
    {{-- Authentication Modals --}}
    @livewireScripts


    <script>
        /* =========================================
            GLOBAL UTILITIES
        ========================================= */
        function loadAd(el) {
            if (el.dataset.loaded === 'true') return;
            const content = el.querySelector('[data-ad-content]');
            if (content) content.innerHTML = content.dataset.src;
            el.dataset.loaded = 'true';
        }

        /* =========================================
           LIVEWIRE + EVENTS
        ========================================= */
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
                    behavior: 'smooth'
                });
            });
        });

        /* =========================================
           GLOBAL EVENTS
        ========================================= */
        window.addEventListener('auth-changed', () => {
            if (window.Alpine) Alpine.store('nav').reset();
        });

        window.addEventListener('storage', (event) => {
            if (event.key === 'menus-sync') {
                Livewire.dispatch('reloadMenus', JSON.parse(event.newValue));
            }
        });

        /* =========================================
           ALPINE INIT (SINGLE BLOCK ✅)
        ========================================= */
        document.addEventListener('alpine:init', () => {

            /* ---------- STORE ---------- */
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

            /* ---------- SAFE EVENT LISTENER (FIXED) ---------- */
            window.addEventListener('open-external', e => {
                if (e.detail?.url) {
                    window.open(e.detail.url, '_blank', 'noopener,noreferrer');
                }
            });

            /* ---------- SIDEBAR MANAGER (KEEP ONLY ONE) ---------- */
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
                    this.startRotation();
                },

                buildQueue() {
                    this.queue = [];
                    Array.from(this.$el.children).forEach((el, idx) => {
                        const weight = parseInt(el.dataset.weight || 1);
                        for (let i = 0; i < weight; i++) this.queue.push(idx);
                    });
                },

                startRotation() {
                    if (this.queue.length <= 1) return;

                    this.stopRotation();
                    this.timer = setInterval(() => this.rotate(), config?.duration || 8000);
                },

                stopRotation() {
                    clearInterval(this.timer);
                },

                rotate() {
                    this.queue.push(this.queue.shift());
                    this.activeIndex = this.queue[0];
                    this.trackImpression();
                },

                trackImpression() {
                    const el = this.$el.children[this.activeIndex];
                    if (!el?.dataset.id) return;

                    fetch('/widget/impression', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                        },
                        body: JSON.stringify({
                            widget_id: el.dataset.id
                        })
                    }).catch(() => {});
                },

                closeSidebar() {
                    this.isOpen = false;
                    this.stopRotation();
                }
            }));

            /* ---------- SOCIAL DOCK (SINGLE VERSION) ---------- */
            Alpine.data('socialDock', () => ({
                activeIndex: null,

                setFocus(i) {
                    this.activeIndex = i;
                },

                reset() {
                    this.activeIndex = null;
                },

                getStyle(i) {
                    if (this.activeIndex === null) return '';

                    const d = Math.abs(i - this.activeIndex);
                    let scale = 1;

                    if (d === 0) scale = 1.4;
                    else if (d === 1) scale = 1.2;

                    return `transform: scale(${scale});`;
                }
            }));

        });

        /* =========================================
           COMPONENT HELPERS (GLOBAL)
        ========================================= */

        function dropdown() {
            return {
                open: false,
                toggle() {
                    this.open = !this.open
                },
                close() {
                    this.open = false
                }
            };
        }

        function slider() {
            return {
                current: 0,
                next() {
                    this.current++
                },
                prev() {
                    this.current--
                }
            };
        }
    </script>
    <x-modals.login-modal />
</body>

</html>