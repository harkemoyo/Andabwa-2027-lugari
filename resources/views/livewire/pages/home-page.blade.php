<div>
    <div class="max-w-[1400px] mx-auto px-4 grid grid-cols-12 gap-6">
        {{-- LEFT SIDEBAR --}}
        <div class="hidden lg:block lg:col-span-3 py-6">
            <livewire:left-sidebar />
        </div>

        <livewire:pages.blog.feed />

        {{-- RIGHT SIDEBAR --}}
        <div class=" lg:col-span-3 py-6 space-y-6">
            <livewire:sidebar.rotating-widgets />
        </div>
        {{-- Back to normal center --}}
        <div class="col-span-12 lg:col-span-6 lg:col-start-4">
            <x-blog.browse-more-button />
        </div>
    </div>
</div>