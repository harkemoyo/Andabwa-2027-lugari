<div class="flex justify-center items-center p-2">
    @if(count($widgets) > 0)
    <div
        x-data="sidebarManager({ 
            duration: 5000, 
            totalWidgets: {{ $widgets->count() }} 
        })"
        x-show="isOpen"
        x-cloak
        x-on:sidebar-data-updated.window="syncData()"
        class="relative w-full max-w-[260px] aspect-square mx-auto group">
        {{-- Progress Ring Decoration (Static Visual Element) --}}
        <div class="absolute inset-0 rounded-full border-[3px] border-slate-100 ring-1 ring-black/5"></div>

        @foreach($widgets as $index => $widget)
        <div
            x-show="activeIndex === {{ $index }}"
            x-transition:enter="transition cubic-bezier(0.34, 1.56, 0.64, 1) duration-500"
            x-transition:enter-start="opacity-0 scale-90 rotate-3"
            x-transition:enter-end="opacity-100 scale-100 rotate-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-110"
            class="absolute inset-0 bg-white border border-slate-200 rounded-full shadow-[0_8px_30px_rgb(0,0,0,0.12)] p-1 flex flex-col items-center justify-center overflow-hidden">
            <a href="{{ $widget->url ?? '#' }}"
                target="_blank"
                rel="noopener noreferrer"
                class="relative flex flex-col items-center justify-center w-full h-full text-center no-underline">
                {{-- Category/Title Badge --}}
                <div class="absolute top-6 left-0 right-0 z-20 flex justify-center">
                    <span class="px-3 py-1.5 bg-white/90 backdrop-blur-sm border border-slate-200 rounded-full text-[6px] font-black uppercase tracking-[0.15em] text-slate-600 shadow-sm line-clamp-1 max-w-[90%]">
                        {{ $widget->title }}
                    </span>
                </div>

                {{-- Content Area --}}
                <div class="w-full h-full rounded-full overflow-hidden flex items-center justify-center bg-slate-50">
                    @if($widget->full_widget_image_path)
                    <img src="{{ $widget->full_widget_image_path }}"
                        alt="{{ $widget->title }}"
                        class="w-full h-full object-contain transition-transform duration-700 group-hover:scale-110"
                        loading="lazy">

                    {{-- Subtle Inner Shadow for Image --}}
                    <div class="absolute inset-0 rounded-full shadow-[inset_0_0_40px_rgba(0,0,0,0.1)] pointer-events-none"></div>
                    @else
                    <div class="px-8 pt-4">
                        <div class="prose prose-slate text-slate-700 text-[11px] leading-relaxed italic line-clamp-4">
                            {!! $widget->content !!}
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Interaction Overlay --}}
                <div class="absolute inset-0 bg-gradient-to-tr from-blue-500/10 via-transparent to-pink-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-full"></div>
            </a>
        </div>
        @endforeach

        {{-- Bottom Action Indicator (Mobile Cue) --}}
        <div class="absolute -bottom-2 left-1/2 -translate-x-1/2 bg-slate-900 text-white text-[8px] font-bold px-2 py-0.5 rounded-md tracking-tighter uppercase z-30 shadow-lg">
            Tap to view
        </div>
    </div>
    @endif
</div>