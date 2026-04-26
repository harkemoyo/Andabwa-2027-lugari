<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8 p-0 w-full">
    @foreach($radioChannels as $radio)
    {{-- Main Station Card --}}
    <article class="group relative flex flex-col bg-white rounded-2xl shadow-sm ring-1 ring-gray-900/5 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
        
        {{-- Station Branding Header --}}
        <div class="relative w-full aspect-[16/9] overflow-hidden bg-gray-900">
            
            {{-- Background Blur/Cover --}}
            <div class="absolute inset-0 z-0">
                <img src="{{ $radio->full_cover_image_path }}"
                    alt=""
                    class="h-full w-full object-cover blur-sm opacity-50 scale-110 transform group-hover:scale-100 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40 to-transparent"></div>
            </div>

            {{-- Floating Station Logo (The UI/UX Upgrade) --}}
            <div class="absolute inset-0 z-10 flex items-center justify-center">
                <div class="relative">
                    <div class="absolute -inset-4 bg-white/10 backdrop-blur-md rounded-full animate-pulse group-hover:bg-indigo-500/20 transition-colors"></div>
                    <img src="{{ $radio->full_cover_image_path }}" 
                         alt="{{ $radio->title }} Logo" 
                         class="relative w-24 h-24 rounded-full border-4 border-white shadow-2xl object-cover z-20 transform group-hover:scale-110 transition-transform duration-500">
                </div>
            </div>
            
            {{-- Status Badge --}}
            @if($radio->type === 'live')
            <div class="absolute top-4 right-4 z-30">
                <span class="inline-flex items-center gap-1.5 bg-red-600 px-2.5 py-1 rounded-md text-[10px] font-black uppercase tracking-tighter text-white shadow-lg ring-1 ring-white/20">
                    <span class="h-1.5 w-1.5 bg-white rounded-full animate-ping"></span>
                    On Air
                </span>
            </div>
            @endif
        </div>

        {{-- Station Info --}}
        <div class="flex flex-col flex-1 p-6">
            <div class="mb-4">
                <h3 class="text-xl font-bold text-gray-900 group-hover:text-indigo-600 transition-colors line-clamp-1">
                    {{ $radio->title }}
                </h3>
                <div class="flex items-center gap-2 mt-1">
                    <span class="w-2 h-2 bg-indigo-500 rounded-full"></span>
                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Digital Broadcast</span>
                </div>
            </div>
            
            <p class="text-sm text-gray-500 leading-relaxed line-clamp-2 flex-1">
                {{ $radio->description }}
            </p>

            {{-- Action Area --}}
            <div class="mt-6 pt-5 border-t border-gray-50">
                @if($radio->type === 'upload')
                <button class="group/btn flex items-center justify-between w-full text-indigo-600 font-bold text-sm bg-indigo-50/50 hover:bg-indigo-50 px-4 py-3 rounded-xl transition-all">
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" />
                        </svg>
                        Listen to Archive
                    </span>
                    <span class="text-[10px] bg-white/80 px-2 py-0.5 rounded shadow-sm text-indigo-400">{{ $radio->duration_minutes }}m</span>
                </button>
                @else
                <a href="{{ $radio->live_url }}" target="_blank" rel="noopener noreferrer"
                    class="group/link inline-flex items-center justify-center w-full bg-gray-900 text-white px-4 py-3.5 rounded-xl text-sm font-bold hover:bg-indigo-600 transition-all shadow-md hover:shadow-indigo-200 active:scale-[0.98]">
                    <svg class="w-5 h-5 mr-2 text-indigo-400 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                    Tune In Live
                </a>
                @endif
            </div>
        </div>
    </article>
    @endforeach

    {{-- Pagination --}}
    <div class="col-span-full mt-10">
        {{ $radioChannels->links() }}
    </div>
</div>