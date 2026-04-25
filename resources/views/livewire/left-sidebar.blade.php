<div class="space-y-3 w-full max-w-sm mx-auto px-4 py-2">
    <div class="mb-4">
        <div class="flex items-center gap-3 hover:text-purple-600 transition-colors">
            <span class="h-px w-6 bg-gradient-to-r from-purple-600 to-pink-500"></span>
            <h2 class="text-xs font-bold uppercase tracking-[0.2em] text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-600">
                {{ $this->pageSettings->header_subtitle ?? 'Trending' }}
            </h2>
        </div>
    </div>

    @foreach($widgets as $widget)
    <div class="border border-blue-300 hover:border-pink-500 hover:shadow-md rounded-xl p-4 shadow-sm bg-white transition-all">
        
        <a href="{{ $widget->url }}"
            target="_blank"
            rel="noopener noreferrer"
            class="block hover:text-pink-900 transition-colors tracking-tight no-underline">
            
            <h3 class="text-base font-bold text-gray-900 hover:text-pink-500 transition-colors mb-1">
                {{ $widget->title }}
            </h3>
            
            <div class="hover:underline font-medium text-sm text-gray-700 line-clamp-3">
                {!! $widget->content !!}
            </div>
            
        </a>
        
    </div>
    @endforeach
</div>