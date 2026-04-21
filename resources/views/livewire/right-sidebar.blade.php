<div
    x-data="sidebarManager({ 
        duration: 500, 
        totalWidgets: {{ count($widgets) }} 
    })"
    x-init="init()"
    x-show="isOpen"
    x-cloak
    x-on:sidebar-data-updated.window="syncData()"
    wire:ignore
    class="relative w-full h-[320px] perspective group">

    <style>
        .perspective {
            perspective: 1200px;
        }

        .backface-hidden {
            backface-visibility: hidden;
            transform-style: preserve-3d;
        }

        .shimmer {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }

        @keyframes shimmer {
            0% {
                background-position: 200% 0;
            }

            100% {
                background-position: -200% 0;
            }
        }

        /* Custom Close Button Style */
        .close-widget-btn {
            @apply absolute top-3 right-3 z-50 p-1.5 rounded-full bg-white/80 backdrop-blur-sm border border-gray-200 text-gray-400 hover:text-gray-600 hover:bg-white transition-all duration-200 shadow-sm;
        }



        .rotateY-0 {
            transform: rotateY(0deg);
        }

        .rotateY-90 {
            transform: rotateY(90deg);
        }

        .-rotateY-90 {
            transform: rotateY(-90deg);
        }

        .backface-hidden {
            backface-visibility: hidden;
            transform-style: preserve-3d;
        }
    </style>


    {{-- Close Button --}}
    <button
        @click="closeSidebar()"
        class="absolute top-2 right-2 z-50 p-1.5 rounded-full bg-white/90 border shadow-sm text-gray-400 hover:text-red-500 transition-colors">
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>



    @foreach($widgets as $index => $widget)
    <div
        data-widget-id="{{ $widget['id'] }}"
        data-weight="{{ $widget['weight'] ?? 1 }}"
        x-show="true"
        x-transition:enter="transition duration-500 ease-out"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        class="absolute inset-0 bg-white border border-size-2 border-blue-300  hover:border-pink-500 rounded-2xl shadow-lg p-4 flex flex-col">

        {{--
<a href="{{ $widget->url }}"
        target="_blank"
        rel="noopener noreferrer"
        class="hover:text-pink-900 transition-colors uppercase tracking-tight decoration-none">
        <span class="text-[10px] font-bold text-gray-300 uppercase tracking-widest mb-2">
            {{ $widget['title'] }}
        </span>

        <div class="flex-1 flex items-center justify-center ad-content-area">
            {!! $widget['content'] !!}
        </div>
        </a>
        --}}




        <div
            wire:click="$dispatch('open-external', { url: '{{ $widget->url }}' })"
            class="cursor-pointer hover:text-pink-900 transition-colors uppercase tracking-tight">
            <span class="text-[10px] font-bold text-gray-300 uppercase tracking-widest mb-2">
                {{ $widget['title'] }}
            </span>

            <div class="flex-1 flex items-center justify-center ad-content-area">
                {!! $widget['content'] !!}
            </div>
        </div>

    </div>
    @endforeach


</div>