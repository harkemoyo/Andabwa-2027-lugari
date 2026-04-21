<!-- @livewire('sidebar.rotating-widgets') -->
<div class="">
    <div>
        <div
            x-data="sidebarManager({ 
        duration: 900, 
        totalWidgets: {{ count($widgets) }} 
    })"
            x-init="init()"
            x-show="isOpen"
            x-cloak
            x-on:sidebar-data-updated.window="syncData()"
            wire:ignore
            class="relative w-full mt-10  h-[320px] perspective group">

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
                data-widget-id="{{ $widget['id'] }}"
                data-weight="{{ $widget['weight'] ?? 1 }}"
                x-show="activeIndex === {{ $index }}"
                x-transition:enter="transition duration-500 ease-out"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                class="absolute inset-0 bg-white  border border-size-2 border-blue-300  hover:border-pink-500 rounded-2xl shadow-lg p-4 flex flex-col">


                <a href="{{ $widget->url }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="hover:text-pink-900 transition-colors uppercase tracking-tight decoration-none">
                    <span class="text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-2">
                        {{ $widget['title'] }}
                    </span>

                    <div class="flex-1 flex items-center justify-center ad-content-area">
                        {!! $widget['content'] !!}
                    </div>
                </a>

            </div>
            @endforeach

        </div>

    </div>



    {{-- Persistent Layout Wrapper (Prevents Layout Shift and allows width calculation) --}}
    <div class="w-full mt-10 h-[320px]">

        <div
            x-data="carouselManager({ 
            duration: 5000, 
            totalWidgets: {{ count($widgets) }} 
        })"
            x-init="init()"
            x-show="isOpen"
            x-cloak
            @resize.window.debounce.100ms="calculateGeometry()"
            x-on:sidebar-data-updated.window="syncData()"
            wire:ignore
            class="relative w-full h-full scene-3d group"

            {{-- 1-Second Pop-up Entrance Animation --}}
            x-transition:enter="transition duration-1000 ease-[cubic-bezier(0.34,1.56,0.64,1)]"
            x-transition:enter-start="opacity-0 scale-75 translate-y-12"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition duration-300 ease-in"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90">

            {{-- Close Button --}}
            <button
                @click="closeSidebar()"
                class="absolute hidden top-2 right-2 z-50 p-1.5 rounded-full bg-white/90 border shadow-sm text-gray-400 hover:text-red-500 transition-colors group-hover:block">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            {{-- The 3D Rotating Wrapper --}}
            <div
                class="carousel-container w-full h-full relative"
                :class="{ 'is-dragging': isDragging }"
                :style="`transform: translateZ(${-radius}px) rotateY(${currentRotation}deg)`"
                @pointerdown="dragStart"
                @pointermove="dragMove"
                @pointerup="dragEnd"
                @pointerleave="dragEnd"
                @pointercancel="dragEnd">

                @foreach($widgets as $index => $widget)
                <div
                    data-widget-id="{{ $widget['id'] }}"
                    data-weight="{{ $widget['weight'] ?? 1 }}"
                    class="carousel-face bg-white border border-blue-200 hover:border-pink-500 rounded-2xl shadow-xl p-4 flex flex-col"
                    :style="`transform: rotateY({{ $index }} * theta + 'deg') translateZ(${radius}px)`">

                    <a href="{{ $widget['url'] ?? '#' }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="hover:text-pink-900 transition-colors uppercase tracking-tight decoration-none h-full flex flex-col pointer-events-auto"
                        @dragstart.prevent>

                        <span class="text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-2">
                            {{ $widget['title'] }}
                        </span>

                        <div class="flex-1 flex items-center justify-center ad-content-area" data-src="{!! htmlspecialchars($widget['content'] ?? '') !!}">
                            {{-- Content injected via JS --}}
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>




</div>