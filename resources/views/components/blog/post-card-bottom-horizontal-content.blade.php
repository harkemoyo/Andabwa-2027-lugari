{{-- components/blog/post-card-horizontal.blade.php --}}
<article class="group relative bg-white rounded-[2rem] border border-blue-100 shadow-sm hover:shadow-2xl hover:border-pink-500/50 transition-all duration-500 overflow-hidden h-full">
    {{-- Interactive Link Wrapper --}}
    <a href="{{ route('posts.show', $post->slug) }}" class="absolute inset-0 z-20" aria-label="{{ $post->title }}"></a>
    <div class="grid grid-cols-1 md:grid-cols-12 h-full">
        {{-- LEFT COLUMN: MEDIA (5 out of 12 columns) --}}
        <div class="md:col-span-5 relative overflow-hidden bg-slate-100">
            <div class="h-full w-full transform group-hover:scale-105 transition-transform duration-700 ease-out">
                <x-blog.media :post="$post" class="object-cover w-full h-full" />
            </div>
            {{-- Subtle Gradient Overlay on Media --}}
            <div class="absolute inset-0 bg-gradient-to-r from-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
        </div>
        {{-- RIGHT COLUMN: CONTENT (7 out of 12 columns) --}}
        <div class="md:col-span-7 p-6 lg:p-8 flex flex-col justify-center bg-white relative z-10">
            {{-- META --}}
            <div class="flex items-center gap-3 mb-4">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest bg-emerald-50 text-emerald-600 border border-emerald-100">
                    {{ $post->category->name }}
                </span>
                <span class="text-[11px] font-medium text-slate-400 flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    {{ $post->created_at->format('M j, Y') }}
                </span>
            </div>
            {{-- TITLE --}}
            <h3 class="text-xl lg:text-2xl font-extrabold text-slate-900 leading-tight mb-3 group-hover:text-emerald-600 transition-colors duration-300 line-clamp-2">
                {{ $post->title }}
            </h3>
            {{-- DESCRIPTION --}}
            @if($post->meta_description || $post->content)
            <p class="text-sm lg:text-base text-slate-500 line-clamp-2 mb-6 leading-relaxed">
                {{ $post->meta_description ?? strip_tags($post->content) }}
            </p>
            @endif
            {{-- FOOTER / CTA --}}
            <div class="flex items-center text-emerald-600 text-sm font-bold tracking-tight group-hover:gap-2 transition-all duration-300">
                <span>View Details</span>
                <svg class="w-4 h-4 ml-1 opacity-0 group-hover:opacity-100 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </div>
        </div>
    </div>
</article>