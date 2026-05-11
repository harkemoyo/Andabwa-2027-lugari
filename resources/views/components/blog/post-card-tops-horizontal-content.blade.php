{{-- components/blog/post-card-horizontal.blade.php --}}
<article class="group/card relative bg-white rounded-xl border  border-purple-500/40 hover:border-purple-500/40 hover:border-2 shadow-sm hover:shadow-2xl transition-all duration-500 overflow-hidden h-full flex flex-col md:grid md:grid-cols-12">
    {{-- Interactive Link Wrapper --}}
    <a href="{{ route('posts.show', $post->slug) }}" class="absolute inset-0 z-30" aria-label="{{ $post->title }}"></a>

    {{-- LEFT COLUMN: MEDIA --}}
    <div class=" relative md:col-span-5 h-52 md:h-full overflow-hidden bg-slate-100">
        <div class="h-full w-full transform group-hover/card:scale-110 transition-transform duration-1000 ease-out">
            <x-blog.media :post="$post" class="object-cover w-full h-full" />
        </div>
        <div class="absolute inset-0 bg-gradient-to-t md:bg-gradient-to-r from-black/40 to-transparent opacity-60 md:opacity-0 group-hover/card:opacity-100 transition-opacity"></div>

        <div class="absolute top-4 left-4 md:hidden z-10">
            <span class="px-3 py-1 rounded-full text-[9px] font-bold uppercase tracking-widest bg-purple-500 text-white shadow-lg">
                {{ $post->category->name }}
            </span>
        </div>
    </div>

    {{-- RIGHT COLUMN: CONTENT --}}
    <div class="md:col-span-7 p-6 lg:p-10 flex flex-col justify-center bg-white relative z-10">
        <div class="hidden md:flex items-center gap-3 mb-4">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest bg-purple-500 text-white border border-purple-100">
                {{ $post->category->name }}
            </span>
            <span class="text-[11px] font-medium text-slate-400 flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                {{ $post->created_at->format('M j, Y') }}
            </span>
        </div>

        <h3 class="text-xl md:text-2xl lg:text-3xl font-extrabold text-slate-900 leading-tight mb-3 group-hover/card:text-purple-600 transition-colors duration-300 line-clamp-2">
            {{ $post->title }}
        </h3>

        @if($post->meta_description || $post->content)
        <p class="text-sm lg:text-base text-slate-500 line-clamp-2 mb-6 leading-relaxed">
            {{ $post->meta_description ?? strip_tags($post->content) }}
        </p>
        @endif


        <x-blog.read-article-button :text="__('blog_page.read_article')" />


    </div>
</article>