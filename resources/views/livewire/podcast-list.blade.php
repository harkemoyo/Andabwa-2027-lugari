<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8 w-full">
    @foreach($podcasts as $podcast)
    {{-- Semantic <article> wrapper with smooth hover lift and ring border --}}
    <article class="group relative flex flex-col bg-white rounded-2xl shadow-sm ring-1 ring-gray-900/5 overflow-hidden hover:shadow-lg hover:-translate-y-1 transition-all duration-300 ease-out">
        
        {{-- Image Header --}}
        {{-- Replaced fixed h-48 with aspect ratio to prevent stretching/squishing --}}
        <div class="relative w-full aspect-[16/9] sm:aspect-[4/3] lg:aspect-[16/9] bg-gray-100 overflow-hidden">
            
            {{-- Background Image --}}
            <div class="absolute inset-0 z-0">
                <img src="{{ $podcast->full_cover_image_path }}"
                    alt="{{ $podcast->title }}"
                    loading="lazy"
                    class="h-full w-full object-cover transform group-hover:scale-105 transition-transform duration-700 ease-in-out">
                
                {{-- Refined Gradient: Only visible on hover or at the top to make the LIVE badge pop --}}
                <div class="absolute inset-0 bg-gradient-to-t from-gray-900/60 via-transparent to-gray-900/30 opacity-60 group-hover:opacity-90 transition-opacity duration-300"></div>
            </div>

            {{-- Status Badge --}}
            @if($podcast->type === 'live')
            <div class="absolute top-4 right-4 z-10 flex gap-2">
                <span class="inline-flex items-center gap-2 bg-red-600/95 backdrop-blur-md text-white text-[10px] sm:text-xs font-semibold tracking-wide uppercase px-3 py-1.5 rounded-full shadow-sm ring-1 ring-white/20">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span>
                    </span>
                    Live
                </span>
            </div>
            @endif
        </div>

        {{-- Content Body --}}
        <div class="flex flex-col flex-1 p-5 lg:p-6">
            <h3 class="text-lg sm:text-xl font-bold text-gray-900 group-hover:text-indigo-600 transition-colors duration-200 line-clamp-2 leading-snug">
                {{ $podcast->title }}
            </h3>
            
            <p class="mt-3 text-sm text-gray-600 leading-relaxed line-clamp-2 flex-1">
                {{ $podcast->description }}
            </p>

            {{-- Footer / Call to Action --}}
            <div class="mt-6 pt-5 border-t border-gray-100/80 flex items-center justify-between mt-auto">
                @if($podcast->type === 'upload')
                <button class="group/btn inline-flex items-center gap-2.5 text-indigo-600 hover:text-indigo-700 font-semibold text-sm transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 rounded-lg p-1 -ml-1">
                    <div class="bg-indigo-50 rounded-full p-1.5 group-hover/btn:bg-indigo-100 transition-colors">
                        <svg class="w-5 h-5 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <span>Listen Now <span class="text-indigo-400 font-normal">({{ $podcast->duration_minutes }}m)</span></span>
                </button>
                @else
                <a href="{{ $podcast->live_url }}" target="_blank" rel="noopener noreferrer"
                    class="group/link inline-flex items-center justify-center w-full bg-gray-900 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-gray-800 transition-all shadow-sm hover:shadow active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2">
                    Join Live Stream
                    <svg class="w-4 h-4 ml-2 transform group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
                @endif
            </div>
        </div>
    </article>
    @endforeach

    {{-- Pagination --}}
    <div class="col-span-full mt-8 border-t border-gray-100 pt-8">
        {{ $podcasts->links() }}
    </div>
</div>