<div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8 w-full">
        @foreach($tvChannels as $tv)
        {{-- Cinematic Article Card --}}
        <article class="group relative flex flex-col bg-white rounded-2xl shadow-sm ring-1 ring-gray-900/5 overflow-hidden hover:shadow-2xl transition-all duration-300">
            
            {{-- Video Preview / Header --}}
            <div class="relative w-full aspect-video overflow-hidden bg-black">
                {{-- Cover Image --}}
                <img src="{{ $tv->full_cover_image_path }}"
                    alt="{{ $tv->title }}"
                    loading="lazy"
                    class="h-full w-full object-cover transform group-hover:scale-105 transition-transform duration-700 ease-out opacity-80 group-hover:opacity-100">
                
                {{-- Play Button Overlay (UX Signal for Video) --}}
                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10">
                    <div class="bg-white/20 backdrop-blur-md p-4 rounded-full ring-1 ring-white/50 shadow-2xl">
                        <svg class="w-8 h-8 text-white fill-current" viewBox="0 0 20 20">
                            <path d="M6.3 2.841A1.5 1.5 0 004 4.11v11.78a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z" />
                        </svg>
                    </div>
                </div>

                {{-- Cinematic Gradient --}}
                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-black/30"></div>

                {{-- Channel Logo Watermark --}}
                <div class="absolute bottom-3 left-3 z-20 flex items-center gap-2">
                    <div class="p-1 bg-white/10 backdrop-blur-md rounded-lg ring-1 ring-white/20">
                        <img src="{{ $tv->full_cover_image_path }}" alt="" class="w-8 h-8 rounded-md object-cover">
                    </div>
                    <span class="text-white text-xs font-medium tracking-wide drop-shadow-md">HD Broadcast</span>
                </div>

                {{-- Live Badge --}}
                @if($tv->type === 'live')
                <div class="absolute top-4 right-4 z-20">
                    <span class="inline-flex items-center gap-1.5 bg-red-600 px-3 py-1 rounded-full text-[10px] font-bold text-white shadow-lg animate-pulse">
                        <span class="h-1.5 w-1.5 bg-white rounded-full"></span>
                        LIVE TV
                    </span>
                </div>
                @endif
            </div>

            {{-- Content Body --}}
            <div class="flex flex-col flex-1 p-6">
                <h3 class="text-xl font-bold text-gray-900 group-hover:text-indigo-600 transition-colors line-clamp-1">
                    {{ $tv->title }}
                </h3>
                
                <p class="mt-2 text-sm text-gray-500 leading-relaxed line-clamp-2 flex-1">
                    {{ $tv->description }}
                </p>

                {{-- Action Footer --}}
                <div class="mt-6">
                    @if($tv->type === 'upload')
                    <button class="group/btn flex items-center justify-center gap-2 w-full bg-indigo-50 text-indigo-700 px-4 py-3 rounded-xl text-sm font-bold hover:bg-indigo-100 transition-all focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <svg class="w-5 h-5 transition-transform group-hover/btn:scale-110" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" />
                        </svg>
                        Watch Recording ({{ $tv->duration_minutes }}m)
                    </button>
                    @else
                    <a href="{{ $tv->live_url }}" target="_blank" rel="noopener noreferrer"
                        class="group/link inline-flex items-center justify-center w-full bg-gray-900 text-white px-4 py-3.5 rounded-xl text-sm font-bold hover:bg-indigo-600 transition-all shadow-md active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-gray-900">
                        <span>Start Streaming Now</span>
                        <svg class="w-4 h-4 ml-2 transform group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>                    
                    @endif
                </div>
            </div>
        </article>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-12">
        {{ $tvChannels->links() }}
    </div>
</div>