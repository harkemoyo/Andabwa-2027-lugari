<div class="space-y-3 ustify-start ">
    <div class="max-w-3xl mx-auto px-6 mb-6">
        <div class="flex items-center gap-3 hover:text-purple-600">
            <span class="h-px w-8 bg-gradient-to-r from-purple-600 to-pink-500"></span>
            <h2 class="text-sm font-bold uppercase tracking-[0.3em] text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-600">
                {{ $this->pageSettings->header_subtitle ?? 'Trending' }}
            </h2>
        </div>
    </div>
    @foreach($widgets as $widget)
    <div class=" border hover:text-pink-800 rounded-xl p-4 shadow-sm border border-size-2 border-blue-300  hover:border-pink-500">

        <a href="{{ $widget->url }}"
            target="_blank"
            rel="noopener noreferrer"
            class="hover:text-pink-900 transition-colors tracking-tight decoration-none">
            <h3 class="text-md md:text-lg font-bold hover:text-pink-500 transition-colors">{{ $widget->title }}</h3>
            <div class="hover:underline font-semibold text-black">
                {!! $widget->content !!}
            </div>
        </a>

    </div>
    @endforeach
</div>