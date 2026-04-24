{{-- components/blog/post-card-horizontal.blade.php --}}
<article class="group relative bg-white rounded-[1.5rem] md:rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl hover:border-pink-500/40 transition-all duration-500 overflow-hidden h-full flex flex-col md:grid md:grid-cols-12">
    {{-- Interactive Link Wrapper --}}
    <a href="{{ route('posts.show', $post->slug) }}" class="absolute inset-0 z-30" aria-label="{{ $post->title }}"></a>

    {{-- LEFT COLUMN: MEDIA --}}
    <div class="relative md:col-span-5 h-52 md:h-full overflow-hidden bg-slate-100">
        <div class="h-full w-full transform group-hover:scale-105 transition-transform duration-1000 ease-out">
            <x-blog.media :post="$post" class="object-cover w-full h-full" />
        </div>
        {{-- Subtle Gradient Overlay on Media --}}
        <div class="absolute inset-0 bg-gradient-to-t md:bg-gradient-to-r from-black/20 to-transparent opacity-40 md:opacity-0 group-hover:opacity-100 transition-opacity"></div>
        
        {{-- Mobile Badge --}}
        <div class="absolute top-4 left-4 md:hidden z-10">
            <span class="px-3 py-1 rounded-full text-[9px] font-bold uppercase tracking-widest bg-emerald-500 text-white shadow-lg">
                {{ $post->category->name }}
            </span>
        </div>
    </div>

    {{-- RIGHT COLUMN: CONTENT --}}
    <div class="md:col-span-7 p-5 lg:p-8 flex flex-col justify-center bg-white relative z-10">
        {{-- META --}}
        <div class="hidden md:flex items-center gap-3 mb-4">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest bg-emerald-50 text-emerald-600 border border-emerald-100">
                {{ $post->category->name }}
            </span>
            <span class="text-[11px] font-medium text-slate-400 flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                {{ $post->created_at->format('M j, Y') }}
            </span>
        </div>

        {{-- TITLE --}}
        <h3 class="text-lg md:text-xl lg:text-2xl font-extrabold text-slate-900 leading-snug mb-2 md:mb-3 group-hover:text-emerald-600 transition-colors duration-300 line-clamp-2">
            {{ $post->title }}
        </h3>

        {{-- DESCRIPTION --}}
        @if($post->meta_description || $post->content)
        <p class="text-sm lg:text-base text-slate-500 line-clamp-2 mb-4 md:mb-6 leading-relaxed">
            {{ $post->meta_description ?? strip_tags($post->content) }}
        </p>
        @endif

        {{-- FOOTER / CTA --}}
        <div class="flex items-center text-emerald-600 text-xs md:text-sm font-bold tracking-tight group-hover:gap-2 transition-all duration-300">
            <span class="uppercase tracking-widest md:normal-case md:tracking-normal">View Project</span>
            <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
            </svg>
        </div>
    </div>
</article>