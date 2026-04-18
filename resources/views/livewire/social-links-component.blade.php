<div
    x-data="socialDock()"
    x-init="init()"
    @mousemove="onMouseMove($event)"
    @mouseleave="reset()"
    class="relative flex items-end gap-3 justify-center sm:justify-start md:justify-end py-6"
    role="navigation"
    aria-label="Social media links"
>

    {{-- 🔄 Skeleton --}}
    @if ($loading)
        @for ($i = 0; $i < 5; $i++)
            <div class="w-10 h-10 rounded-xl bg-gray-300 dark:bg-gray-700 animate-pulse"></div>
        @endfor
    @else

        @foreach ($links as $index => $link)
            <a href="{{ $link->url }}"
               target="_blank"
               tabindex="0"
               role="link"
               aria-label="{{ $link->platform_name }}"
               @focus="setFocus({{ $index }})"
               @blur="reset()"
               @mouseenter="startIntent({{ $index }})"
               @mouseleave="cancelIntent()"
               class="relative outline-none"
            >

                {{-- 🧲 Dock Item --}}
                <div
                    :style="getStyle({{ $index }})"
                    class="flex items-center justify-center rounded-xl
                           transition-all duration-200 ease-out"
                >
                    <div
                        class="w-10 h-10 flex items-center justify-center rounded-xl
                               shadow-sm transition-all duration-300"
                        style="background-color: {{ $link->brand_color }}20;"
                    >
                        <img src="{{ $link->full_image_path }}"
                             alt=""
                             class="w-6 h-6 object-contain pointer-events-none">
                    </div>
                </div>

                {{-- 💬 Tooltip --}}
                <div
                    x-show="activeIndex === {{ $index }}"
                    x-transition.opacity.duration.150ms
                    class="absolute bottom-full mb-2 left-1/2 -translate-x-1/2
                           text-xs px-2 py-1 rounded-md bg-black text-white
                           whitespace-nowrap shadow-lg"
                    role="tooltip"
                >
                    {{ $link->platform_name }}
                </div>

            </a>
        @endforeach

    @endif
</div>