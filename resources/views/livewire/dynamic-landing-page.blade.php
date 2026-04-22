<div class="bg-white">
    @if($landingPage->full_hero_image_path)
    <div class="relative h-96 w-full overflow-hidden">
        <img src="{{ $landingPage->full_hero_image_path }}"
             alt="{{ $landingPage->title }}"
             class="h-full w-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
    </div>
    @endif
    <div class="px-6 py-24 sm:px-6 sm:py-32 lg:px-8 bg-gray-50 border-b border-gray-200 {{ $landingPage->full_hero_image_path ? '-mt-20 relative z-10' : '' }}">
        <div class="mx-auto max-w-2xl text-center">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl {{ $landingPage->full_hero_image_path ? 'text-white' : '' }}">
                {{ $landingPage->title }}
            </h1>
            
            @if($landingPage->subtitle)
                <p class="mx-auto mt-6 max-w-xl text-lg leading-8 {{ $landingPage->full_hero_image_path ? 'text-white' : 'text-gray-600' }}">
                    {{ $landingPage->subtitle }}
                </p>
            @endif

            @if($landingPage->cta_link && $landingPage->cta_text)
                <div class="mt-10 flex items-center justify-center gap-x-6">
                    <a href="{{ $landingPage->cta_link }}" 
                       class="rounded-md bg-blue-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 transition-all">
                        {{ $landingPage->cta_text }}
                    </a>
                </div>
            @endif
        </div>
    </div>

    <div class="px-6 py-16 lg:px-8">
        <div class="mx-auto max-w-3xl text-base leading-7 text-gray-700 prose prose-blue prose-lg">
            {!! $landingPage->content !!}
        </div>
    </div>
</div>