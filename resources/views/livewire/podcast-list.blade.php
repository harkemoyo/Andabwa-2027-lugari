<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 p-4 w-full">
    @foreach($podcasts as $podcast)
    <div class="bg-white rounded-2xl shadow-sm border  border-gray-100 overflow-hidden group p-4 rounded-lg">
        <div class="relative h-48">

            <div class="absolute inset-0 z-0">
                <img src="{{ $podcast->full_cover_image_path }}"
                    alt="{{ $podcast->title }}"
                    class="h-full w-full object-cover rounded-lg">
                <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-black/20 to-black/60"></div>
            </div>
            <!-- <div class="justify-center items-center">
                <img src="{{ $podcast->full_cover_image_path }}" alt="" class="w-20 h-20 rounded-full object-contain object-center pointer-events-none">
            </div> -->
            @if($podcast->type === 'live')
            <span class="absolute top-4 right-4 bg-red-600 text-white text-[10px] font-bold px-2 py-1 rounded-full animate-pulse">
                LIVE
            </span>
            @endif
        </div>

        <div class="pt-2">
            <h3 class="text-xl font-bold text-gray-900 group-hover:text-indigo-600 transition">{{ $podcast->title }}</h3>
            <p class="text-gray-500 text-sm mt-2 line-clamp-2">{{ $podcast->description }}</p>

            <div class="mt-6 flex items-center justify-between">
                @if($podcast->type === 'upload')
                <button class="flex items-center gap-2 text-indigo-600 font-semibold text-sm">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" />
                    </svg>
                    Listen Now ({{ $podcast->duration_minutes }}m)
                </button>
                @else
                <a href="{{ $podcast->live_url }}" target="_blank" rel="noopener noreferrer"
                    class="inline-flex items-center justify-center w-full bg-gray-900 text-white px-4 py-3 rounded-xl text-sm font-bold hover:bg-indigo-600 transition-colors shadow-sm active:scale-[0.98]">
                    Join Live Stream
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
                @endif
            </div>
        </div>
    </div>
    @endforeach

    <div class="col-span-full">
        {{ $podcasts->links() }}
    </div>
</div>