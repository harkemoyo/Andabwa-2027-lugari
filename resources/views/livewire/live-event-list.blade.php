<div class="w-full max-w-7xl mx-auto p-4 sm:p-8">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($liveEvents as $event)
        <div wire:key="event-{{ $event->id }}" class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-xl transition-all duration-300 flex flex-col">
            
            {{-- Image & Badges Header --}}
            <div class="relative h-56 overflow-hidden bg-gray-900">
                {{-- Background Image with Gradient --}}
                <div class="absolute inset-0 z-0">
                    <img src="{{ $event->full_cover_image_path ?? asset('images/default-event.jpg') }}"
                        alt="{{ $event->title }}"
                        class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-500 opacity-80">
                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40 to-transparent"></div>
                </div>

                {{-- Status Badges --}}
                <div class="absolute top-4 right-4 z-10 flex gap-2">
                    @if($event->type === 'live')
                        <span class="flex items-center gap-1.5 bg-red-600/90 backdrop-blur-sm text-white text-[10px] uppercase tracking-wider font-bold px-3 py-1.5 rounded-full animate-pulse shadow-sm">
                            <span class="h-1.5 w-1.5 bg-white rounded-full"></span>
                            Live Now
                        </span>
                    @else
                        <span class="bg-gray-900/80 backdrop-blur-sm text-white text-[10px] uppercase tracking-wider font-bold px-3 py-1.5 rounded-full shadow-sm">
                            Recorded
                        </span>
                    @endif
                </div>
            </div>

            {{-- Content Body --}}
            <div class="p-6 flex flex-col flex-1">
                <h3 class="text-xl font-bold text-gray-900 group-hover:text-indigo-600 transition-colors duration-200 line-clamp-2">
                    {{ $event->title }}
                </h3>
                
                <p class="text-gray-500 text-sm mt-3 line-clamp-3 flex-1">
                    {{ $event->description }}
                </p>

                {{-- Footer / Call to Action --}}
                <div class="mt-6 pt-6 border-t border-gray-100 flex items-center justify-between">
                    @if($event->type === 'upload')
                        <button class="flex items-center gap-2 text-indigo-600 hover:text-indigo-700 font-bold text-sm transition-colors">
                            <svg class="w-8 h-8 text-indigo-100 fill-indigo-600" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                            </svg>
                            <span>Listen ({{ $event->duration_minutes }}m)</span>
                        </button>
                    @else
                        <a href="{{ $event->live_url }}" target="_blank" rel="noopener noreferrer" 
                           class="inline-flex items-center justify-center w-full bg-gray-900 text-white px-4 py-3 rounded-xl text-sm font-bold hover:bg-indigo-600 transition-colors shadow-sm active:scale-[0.98]">
                            Join Live Stream
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    @endif
                </div>
            </div>

        </div>
        @endforeach
    </div>

    {{-- Pagination Engine --}}
    <div class="mt-12 w-full">
        {{ $liveEvents->links() }}
    </div>
</div>