@props(['post'])

{{-- 
    PRO TIP: Added focus-within:ring-2 to make the card accessible for keyboard navigation.
--}}
<article class="relative flex flex-col h-full bg-white rounded-sm border border-gray-100 shadow-sm hover:shadow-xl hover:border-green-100 transition-all duration-500 hover:shadow-2xl hover:-translate-y-1 overflow-hidden group focus-within:ring-2 focus-within:ring-green-500 focus-within:ring-offset-2">
    
    {{-- Media Section --}}
    <x-blog.media :post="$post" class="transition-transform duration-700 group-hover:scale-110  " />

    <div class="p-6 md:p-8 flex flex-col flex-1 relative">
        
        {{-- Meta Information --}}
        <div class="flex items-center justify-between gap-4 mb-2">
            {{-- Category Badge: Given relative z-20 so if you ever change this to an <a> tag, it won't be blocked by the stretched link --}}
            <span class="relative z-20 inline-flex items-center px-3 py-1 rounded-md text-xs font-semibold bg-green-50 text-green-700 tracking-wide border border-green-100/50">
                {{ $post->category->name ?? 'Uncategorized' }}
            </span>
            
            <span class="text-xs font-medium text-gray-400 flex items-center gap-1.5">
                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                {{ $post->read_time ?? '5 min' }}
            </span>
        </div>

        {{-- Title & The Stretched Link --}}
        <h2 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-green-600 transition-colors duration-300 transition-colors">
            @if($post->external_url && \App\Enums\MediaType::isExternal($post->media_type))
            <a href="{{ route('blog.external', $post->slug) }}" class="focus:outline-none">
            @else
            <a href="{{ route('posts.show', $post->slug) }}" class="focus:outline-none">
            @endif
                {{-- MAGIC FIX: Explicit z-10 ensures this sits above the card background but below interactive media --}}
                <span class="absolute inset-0 z-10" aria-hidden="true"></span>
                {{ $post->title }}
            </a>
        </h2>

        {{-- Excerpt --}}
        <div class="flex-1 min-h-0 mb-6">
            <p class="text-gray-600 text-sm line-clamp-3 leading-relaxed flex-grow">
                {!! strip_tags($post->content) !!}
            </p>
        </div>

        {{-- Footer --}}
        <div class="mt-auto pt-4 border-t border-gray-100">
            @if($post->external_url && \App\Enums\MediaType::isExternal($post->media_type))
            <a href="{{ route('blog.external', $post->slug) }}" class="inline-flex items-center text-sm font-semibold text-green-600 group-hover:text-green-700 transition-colors whitespace-nowrap">
                View Details
            @else
            <a href="{{ route('posts.show', $post->slug) }}" class="inline-flex items-center text-sm font-semibold text-green-600 group-hover:text-green-700 transition-colors whitespace-nowrap">
                Read Article
            @endif
                <svg class="w-4 h-4 ml-1 transform transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </a>
        </div>
    </div>
</article>