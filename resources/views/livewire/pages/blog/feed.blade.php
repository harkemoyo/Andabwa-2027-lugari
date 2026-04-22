<div class="">
    <div class="min-h-screen " style=" rgba(59, 130, 246, .5) !important;">

        <div class="max-w-[1400px] mx-auto px-4 grid grid-cols-12 gap-6">

            {{-- LEFT SIDEBAR --}}
            <div class="hidden lg:block lg:col-span-3 py-6">
                <livewire:left-sidebar />
            </div>

            {{-- MAIN CONTENT --}}
            <div class="col-span-12 lg:col-span-6 space-y-6">
                {{-- Normal --}}
                <x-blog.latest-post-top />
            </div>
            {{-- RIGHT SIDEBAR --}}
            <div class=" lg:col-span-3 py-6 space-y-6">
                <livewire:sidebar.rotating-widgets />
            </div>
            {{-- 🔥 EXPANDED SECTIONS (span across center + partial sides) --}}
            <div class="col-span-12 lg:col-span-10 lg:col-start-2 space-y-6">
                <x-blog.featured-post />
                <x-blog.latest-post-middle />
            </div>
            {{-- 🔥 FULL WIDTH (true container width) --}}
            <div class="col-span-12 space-y-6">
                <x-blog.latest-post-bottom />
            </div>
            {{-- Back to normal center --}}
            <div class="col-span-12 lg:col-span-6 lg:col-start-4">
                <x-blog.browse-more-button />
            </div>

        </div>

    </div>
</div>