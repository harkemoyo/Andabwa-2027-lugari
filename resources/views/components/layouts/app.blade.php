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
            0%, 100% {
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
    </style>

    {{-- Page-specific meta overrides --}}
    @yield('meta')
</head>

<body class="antialiased bg-slate-50 text-gray-900">

    @if(isset($slot))
        {{ $slot }}
    @else
        @yield('content')
    @endif

    @livewireScripts

    <script>
        function latestSlider(totalSlides) {
            return {
                current: 0,
                total: totalSlides,
                interval: null,

                init() {
                    this.start()
                },

                start() {
                    this.interval = setInterval(() => {
                        this.next()
                    }, 8000)
                },

                stop() {
                    clearInterval(this.interval)
                },

                next() {
                    this.current = (this.current + 1) % this.total
                },

                go(index) {
                    this.current = index
                    this.stop()
                    this.start()
                }
            }
        }
    </script>


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



</body>

</html>
