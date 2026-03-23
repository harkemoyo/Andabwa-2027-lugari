<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3  gap-8">
    @foreach(range(1,3) as $i)
    
    <div class="animate-pulse bg-white rounded-2xl shadow-sm overflow-hidden">
        <div class="h-60 bg-gray-300"></div>
        <div class="p-6 space-y-4">
            <div class="h-4 bg-gray-300 rounded w-3/4"></div>
            <div class="h-4 bg-gray-300 rounded"></div>
            <div class="h-4 bg-gray-300 rounded w-5/6"></div>
        </div>
    </div>
    @endforeach
</div>