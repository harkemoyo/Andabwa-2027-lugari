<div>
    <div class="max-w-[1400px] mx-auto px-4 grid grid-cols-2 gap-6">
        {{-- LEFT SIDEBAR--}}
        <div class="hidden lg:block lg:col-span-3 py-6">
            <livewire:left-sidebar />
        </div>

        <div class=" mx-auto py-10">
            <h1 class="text-3xl font-extrabold mb-8">Live Feed</h1>
            <livewire:stream-feed />
        </div>
        {{-- RIGHT SIDEBAR --}}
        <div class=" lg:col-span-8 py-6 space-y-6">
            <livewire:sidebar.rotating-widgets />
        </div>
        {{-- Back to normal center --}}
        <div class="col-span-12 lg:col-span-6 lg:col-start-4">
            <x-blog.browse-more-button />
        </div>
    </div>
</div>