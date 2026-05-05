<div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
    
    {{-- Top Widget Area --}}
    <div class="flex flex-col md:flex-row items-start justify-between gap-6 md:gap-10 mb-12">
        <div class="hidden md:block w-full max-w-2xl">
            <livewire:sidebar.rotating-widgets position="sidebar" />
        </div>
        <div class="hidden md:block w-full md:w-auto">
            <livewire:left-sidebar />
        </div>      
    </div>

    {{-- Cards Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
        @foreach($liveEvents as $event)
        {{-- Semantic HTML (<article>), refined shadow/ring, and smooth lift on hover --}}
        <article wire:key="event-{{ $event->id }}" class="group relative flex flex-col bg-white rounded-2xl shadow-sm ring-1 ring-gray-900/5 overflow-hidden hover:shadow-lg hover:-translate-y-1 transition-all duration-300 ease-out">

            {{-- Image & Badges Header --}}
            {{-- Replaced fixed height with aspect ratio for consistent framing across all devices --}}
            <div class="relative w-full aspect-[16/9] sm:aspect-[4/3] lg:aspect-[16/9] bg-gray-100 overflow-hidden">
                
                {{-- Background Image with Gradient --}}
                <div class="absolute inset-0 z-0">
                    <img src="{{ $event->full_cover_image_path ?? asset('images/default-event.jpg') }}"
                        alt="{{ $event->title }}"
                        loading="lazy"
                        class="h-full w-full object-cover transform group-hover:scale-105 transition-transform duration-700 ease-in-out">
                    {{-- Deepened the gradient slightly so white text is always readable regardless of image --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900/90 via-gray-900/30 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-300"></div>
                </div>

                {{-- Status Badges --}}
                <div class="absolute top-4 right-4 z-10 flex gap-2">
                    @if($event->type === 'live')
                    <span class="inline-flex items-center gap-2 bg-red-600/95 backdrop-blur-md text-white text-xs font-semibold tracking-wide uppercase px-3 py-1.5 rounded-full shadow-sm ring-1 ring-white/20">
                        {{-- Professional UI ping indicator rather than pulsing the whole button --}}
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span>
                        </span>
                        Live Now
                    </span>
                    @else
                    <span class="inline-flex items-center bg-gray-900/80 backdrop-blur-md text-gray-100 text-xs font-semibold tracking-wide uppercase px-3 py-1.5 rounded-full shadow-sm ring-1 ring-white/10">
                        Recorded
                    </span>
                    @endif
                </div>
            </div>

            {{-- Content Body --}}
            <div class="flex flex-col flex-1 p-6">
                {{-- Improved typography with leading-snug for multi-line titles --}}
                <h3 class="text-lg sm:text-xl font-bold text-gray-900 group-hover:text-indigo-600 transition-colors duration-200 line-clamp-2 leading-snug">
                    {{ $event->title }}
                </h3>
                <p class="mt-3 text-sm text-gray-600 leading-relaxed line-clamp-3 flex-1">
                    {{ $event->description }}
                </p>

                {{-- Footer / Call to Action --}}
                <div class="mt-6 pt-5 border-t border-gray-100/80 flex items-center justify-between mt-auto">
                    @if($event->type === 'upload')
                    {{-- Added proper focus states for keyboard accessibility and grouped the hover effect --}}
                    <button class="group/btn inline-flex items-center gap-2.5 text-indigo-600 hover:text-indigo-700 font-semibold text-sm transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 rounded-lg p-1 -ml-1">
                        <div class="bg-indigo-50 rounded-full p-1.5 group-hover/btn:bg-indigo-100 transition-colors">
                            <svg class="w-5 h-5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <span>Listen <span class="text-indigo-400 font-normal">({{ $event->duration_minutes }}m)</span></span>
                    </button>
                    @else
                    <a href="{{ $event->live_url }}" target="_blank" rel="noopener noreferrer"
                        class="group/link inline-flex items-center justify-center w-full bg-gray-900 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-gray-800 transition-all shadow-sm hover:shadow active:scale-[0.98] focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2">
                        Join Live Stream
                        {{-- Subtle arrow slide animation on hover --}}
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

    {{-- Pagination Engine --}}
    <div class="mt-12 w-full border-t border-gray-100 pt-8">
        {{ $liveEvents->links() }}
    </div>
</div>