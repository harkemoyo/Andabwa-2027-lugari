{{-- <div>



    <div class="min-h-screen bg-white">
        <x-blog.latest-post-top />
        <x-blog.featured-post />
        <x-blog.latest-post-middle />
        <x-blog.latest-post-bottom />
        <x-blog.browse-more-button />
    </div>


</div> --}}




<div class="min-h-screen bg-white">
    
<div class="max-w-[1400px] mx-auto px-4 grid grid-cols-12 gap-6"> 

        {{-- LEFT SIDEBAR --}}
        <div class="hidden lg:block lg:col-span-3">
            <livewire:left-sidebar />
        </div>

        {{-- MAIN CONTENT --}}
        <div class="col-span-12 lg:col-span-6">
            <x-blog.latest-post-top />
            <x-blog.featured-post />
            <x-blog.latest-post-middle />
            <x-blog.latest-post-bottom />
            <x-blog.browse-more-button />
        </div>

        {{-- RIGHT SIDEBAR --}}
        <div class="hidden lg:block lg:col-span-3">
            <livewire:right-sidebar />
        </div>

    </div> 

</div>