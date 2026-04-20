{{-- FOOTER CALL TO ACTION --}}
<div class="flex justify-center py-2 -mt-6">
    <a
    href="{{ route('blog.all-projects') }}"
    wire:navigate
    class="relative group px-8 py-5 bg-slate-950 rounded-2xl overflow-hidden transition-all duration-300 hover:shadow-[0_20px_50px_rgba(0,0,0,0.1)]"
>
    <div class="absolute inset-0 bg-gradient-to-r from-purple-600 to-red-600 translate-y-[101%] group-hover:translate-y-0 transition-transform duration-300"></div>

    <div class="relative flex items-center gap-3">
        <span class="text-xs font-black tracking-[0.3em] text-white">
            Browse more projects
        </span>

        <svg class="w-4 h-4 text-white transform group-hover:translate-x-1 transition-transform">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
        </svg>
    </div>
</a>
</div>