<div class="bg-white min-h-screen">
    {{-- 1. HERO SECTION --}}
    <section class="relative h-[300px] w-full flex items-center justify-center overflow-hidden bg-gray-900">
        @if($landingPage->full_hero_image_path)
        <div class="absolute inset-0 z-0">
            <img src="{{ $landingPage->full_hero_image_path }}"
                alt="{{ $landingPage->title }}"
                class="h-full w-full object-cover opacity-60">
            <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-black/20 to-black/60"></div>
        </div>
        @endif

        <div class="relative z-10 max-w-4xl px-6 text-center text-white">
            <h1 class="text-4xl font-extrabold tracking-tight sm:text-6xl">{{ $landingPage->title }}</h1>
            @if($landingPage->subtitle)
            <p class="mx-auto mt-6 max-w-2xl text-lg text-gray-200">{{ $landingPage->subtitle }}</p>
            @endif
        </div>
    </section>

    {{-- 2. DYNAMIC CONTENT SECTION --}}
    <section class="py-12 bg-white">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <article class="prose prose-lg prose-indigo font-bold text-center mx-auto mb-16">
                {!! $landingPage->content !!}
            </article>

            {{-- 🔥 ENGINEER STANDARD: Conditional Component Injection --}}
            @if($landingPage->slug === 'podcasts')
            <div class="mt-12 border-t border-gray-100 pt-12">
                <div class="mb-8 flex items-center justify-between">
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900">Latest Episodes</h2>
                    <span class="rounded-full bg-indigo-50 px-3 py-1 text-xs font-semibold text-indigo-600 ring-1 ring-inset ring-indigo-600/20">Updated Weekly</span>
                </div>

                <livewire:podcast-list />
            </div>
            @endif

            {{-- Add other hooks here (e.g., for 'radio' or 'tv') --}}
            @if($landingPage->slug === 'tv')
                 <livewire:tv-list /> 
            @endif
            @if($landingPage->slug === 'radio')
                 <livewire:radio-list /> 
            @endif
            @if($landingPage->slug === 'live-event')
                 <livewire:live-event-list /> 
            @endif
        </div>
    </section>
</div>