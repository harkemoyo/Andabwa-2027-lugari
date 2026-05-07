<div class="ml-2 mt-1.5 flex items-center" data-aos="fade-up" data-aos-duration="1000">
    @if ($isLoading)
    <div class="h-10 md:h-14 w-10 md:w-14 bg-gray-200 rounded-full animate-pulse"></div>
    @elseif ($hasError)
    <a
        href="{{ $link }}"
        wire:navigate
        target="_self"
        class="inline-flex items-center group"
        aria-label="{{ config('app.name') }}">
        <x-heroicon-o-exclamation-circle class="w-8 h-8 text-red-500" />
    </a>
    @else
    <a
        href="{{ $link }}"
        wire:navigate
        target="_self"
        class="inline-flex items-center group"
        aria-label="{{ config('app.name') }}">
        @if ($logo)
        
        <img
            src="{{ $logo }}"
            alt="{{ config('app.name') }} Logo"
            class="h-10 md:h-14 w-auto rounded-full hover:shadow-green-50 shadow-lg transition-all duration-300 group-hover:scale-105"
            loading="eager"
            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
        <div class="hidden items-center justify-center h-10 md:h-14 w-10 md:w-14 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full">
            <span class="text-white font-bold text-lg">{{ strtoupper(substr(config('app.name'), 0, 1)) }}</span>
        </div>
        @else
        <div class="flex items-center justify-center h-10 md:h-14 w-10 md:w-14 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full hover:shadow-green-50 shadow-lg transition-all duration-300 group-hover:scale-105">
            <span class="text-white font-bold text-lg">{{ strtoupper(substr(config('app.name'), 0, 1)) }}</span>
        </div>
        @endif
    </a>
    @endif
</div>