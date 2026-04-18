{{-- I have not failed. I've just found 10,000 ways that won't work. - Thomas Edison --}}

<div class="hidden md:block bg-gray-50 border-b border-gray-200">
    <nav class="bg-white border-b border-gray-100 shadow-sm sticky top-0 z-50">

    <div class="max-w-[1400px] mx-auto px-10 flex gap-8 py-3 text-xs font-bold uppercase tracking-widest text-gray-600">

        @forelse($categories as $category)
        {{-- {{ route('categories.show')}} wire:key="cat-{{ $category->id }}" <a href="{{ route('categories.show', $category->slug) }}"--}}
         <a href=""            
            wire:navigate
            class="hover:text-red-600 transition-colors duration-200">
            {{ $category->name }}
        </a>
        @empty
        <span class="text-gray-400 normal-case font-normal">No categories available</span>
        @endforelse

        {{-- Real-time loading indicator (Subtle) --}}
        <div wire:loading class="ml-auto">
            <span class="animate-pulse text-red-500">Updating...</span>
        </div>
    </div>
    </nav>
</div>




