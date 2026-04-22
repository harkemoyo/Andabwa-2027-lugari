<div class="bg-white min-h-screen">
    {{-- 1. HERO SECTION: Centered Overlay Standard --}}
    <section class="relative h-[300px] w-full flex items-center justify-center overflow-hidden bg-gray-900">
        @if($landingPage->full_hero_image_path)
            <div class="absolute inset-0 z-0">
                <img src="{{ $landingPage->full_hero_image_path }}" 
                     alt="{{ $landingPage->title }}" 
                     class="h-full w-full object-cover opacity-60">
                {{-- Professional Grade Overlay for Legibility --}}
                <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-black/20 to-black/60"></div>
            </div>
        @endif

        {{-- Centered Hero Content --}}
        <div class="relative z-10 max-w-4xl px-6 text-center text-white">
            <h1 class="text-2xl font-extrabold tracking-tight sm:text-6xl lg:text-7xl">
                {{ $landingPage->title }}
            </h1>
            
            @if($landingPage->subtitle)
                <p class="mx-auto mt-6 max-w-2xl text-lg sm:text-xl text-gray-200">
                    {{ $landingPage->subtitle }}
                </p>
            @endif

            @if($landingPage->cta_link && $landingPage->cta_text)
                <div class="mt-10 flex justify-center">
                    <a href="{{ $landingPage->cta_link }}" 
                       class="rounded-full bg-white px-8 py-4 text-sm font-bold text-gray-900 shadow-xl hover:bg-gray-100 transition-all active:scale-95">
                        {{ $landingPage->cta_text }}
                    </a>
                </div>
            @endif
        </div>
    </section>

    {{-- 2. CONTENT SECTION: Below Hero --}}
    <section class="py-16 sm:py-24 bg-white">
        <div class="mx-auto max-w-3xl px-6 lg:px-8">
            {{-- Pro-standard Typography for RichEditor content --}}
            <article class="prose prose-lg prose-indigo prose-headings:font-bold prose-headings:tracking-tight text-gray-600 max-w-none">
                {!! $landingPage->content !!}
            </article>

            {{-- Secondary Re-engagement CTA --}}
            @if($landingPage->cta_link)
                <div class="mt-16 border-t border-gray-100 pt-10">
                    <div class="rounded-2xl bg-gray-50 p-8 text-center ring-1 ring-inset ring-gray-200">
                        <h2 class="text-2xl font-bold text-gray-900">Get started with {{ $landingPage->title }}</h2>
                        <p class="mt-4 text-gray-600">Take the next step in your journey today.</p>
                        <a href="{{ $landingPage->cta_link }}" class="mt-8 inline-block rounded-md bg-indigo-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 transition-colors">
                            {{ $landingPage->cta_text }}
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </section>
</div>