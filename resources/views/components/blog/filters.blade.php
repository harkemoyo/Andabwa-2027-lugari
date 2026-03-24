@props(['categories', 'search', 'categoryId', 'tagId'])

<div class="flex flex-col md:flex-row items-center gap-4 mb-8">

    {{-- Search --}}
    <div class="relative w-full md:flex-1">
        <input 
            wire:model.live.debounce.300ms="search"
            type="text"
            placeholder="Search articles..."
            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
        >
        <svg class="absolute left-3 top-3 h-5 w-5 text-gray-400"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
    </div>

    {{-- Category --}}
    <div class="w-full md:w-56">
        <select 
            wire:model.live="categoryId"
            class="w-full py-3 px-4 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-indigo-500"
        >
            <option value="">All Categories</option>
            @foreach($this->categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- Clear --}}
    @if($search || $categoryId || $tagId)
        <button 
            wire:click="$set('search','');$set('categoryId',null);$set('tagId',null)"
            class="text-sm font-medium text-red-600 hover:text-red-800 transition"
        >
            Clear Filters
        </button>
    @endif

</div>



