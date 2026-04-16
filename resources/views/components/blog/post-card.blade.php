
<div class="card snap-start shrink-0 
            w-[90%] sm:w-[48%] lg:w-[31%] 
            bg-white rounded-2xl shadow-md hover:shadow-xl 
            transition duration-300 overflow-hidden p-2">

    {{-- MEDIA --}}
    <div class="aspect-[16/10] overflow-hidden p-3">
        <x-blog.media :post="$post" />
    </div>

    {{-- CONTENT --}}
    <div class="p-5">

        <div class="flex items-center gap-2 mb-3">
            <span class="text-[11px] font-semibold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">
                {{ $post->category->name }}
            </span>
            <span class="text-xs text-slate-500">
                {{ $post->created_at->format('M j, Y') }}
            </span>
        </div>

        <h3 class="text-lg font-bold text-slate-900 line-clamp-2 hover:text-emerald-600 transition">
            {{ $post->title }}
        </h3>

        @if($post->meta_description)
        <p class="text-sm text-slate-600 line-clamp-2 mt-2">
            {{ $post->meta_description }}
        </p>
        @endif

    </div>
</div>