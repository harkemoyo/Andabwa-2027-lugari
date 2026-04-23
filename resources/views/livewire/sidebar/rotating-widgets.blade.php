<div>
    <div
        x-data="sidebarManager({ 
            duration: 5000, {{-- Note: Changed from 900 to 5000ms (5s). 900ms is a bit fast for a rotator, adjust as needed. --}}
            totalWidgets: {{ count($widgets) }} 
        })"
        x-show="isOpen"
        x-cloak
        x-on:sidebar-data-updated.window="syncData()"
        class="relative w-auto mt-10 h-[320px] perspective group">

        {{-- Close Button --}}
        <button
            @click="closeSidebar()"
            class="absolute hidden top-2 right-2 z-50 p-1.5 rounded-full bg-white/90 border shadow-sm text-gray-400 hover:text-red-500 transition-colors">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        @foreach($widgets as $index => $widget)
        <div
            data-widget-id="{{ $widget['id'] ?? '' }}"
            data-weight="{{ $widget['weight'] ?? 1 }}"
            x-show="activeIndex === {{ $index }}"
            x-transition:enter="transition duration-500 ease-out"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            class="absolute inset-0 bg-white border border-size-2 border-blue-300 hover:border-pink-500 rounded-2xl shadow-lg p-4 flex flex-col">

            <a href="{{ $widget['url'] ?? '#' }}"
                target="_blank"
                rel="noopener noreferrer"
                class="hover:text-pink-900 transition-colors uppercase tracking-tight decoration-none block h-full">

                <span class="text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-2 block">
                    {{ $widget['title'] ?? '' }}
                </span>

                @if(!empty($widget['full_widget_image_path']))
                <div class="flex-1 flex items-center objet-contain justify-center ad-content-area overflow-hidden h-[calc(100%-1.5rem)]">
                    <img src="{{ $widget['full_widget_image_path'] ?? '' }}" alt="{{ $widget['title'] ?? '' }}" class="w-full h-full object-cover rounded">
                </div>
                @else
                <div class="flex-1 flex text-black items-center justify-center ad-content-area overflow-hidden h-[calc(100%-1.5rem)]">
                    {!! $widget['content'] ?? '' !!}
                </div>
                @endif
            </a>
        </div>
        @endforeach
    </div>    
</div>