<div>
    <div class="max-w-[1400px] mx-auto px-4 grid grid-cols-2 gap-6">
        {{-- Right SIDEBAR--}}
        <div class="hidden lg:block lg:col-span-3 py-6">
            <livewire:right-sidebar />
        </div>

        {{-- Left SIDEBAR --}}
        <div class=" lg:col-span-8 py-6 space-y-6">
            {{-- Scheduled Stream Section --}}
            <div class="space-y-4">
                <h2 class="text-2xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-600 italic tracking-tight">
                    Live Stream
                </h2>

                @if($scheduledStream)
                    <x-blog.stream-card :stream="$scheduledStream" />
                @else
                    {{-- No Available Livestreams Card --}}
                    <div class="border rounded-xl p-8 bg-white shadow-sm">
                        <div class="text-center space-y-4">
                            <div class="w-20 h-20 mx-auto rounded-full bg-gradient-to-br from-purple-100 to-pink-100 flex items-center justify-center">
                                <svg class="w-10 h-10 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900">No Available Livestreams</h3>
                            <p class="text-sm text-slate-500">Check back later for upcoming live streams.</p>
                        </div>
                    </div>
                @endif
            </div>

            <livewire:sidebar.rotating-widgets />
        </div>
        {{-- Back to normal center --}}
        <div class="col-span-12 lg:col-span-6 lg:col-start-4">
            <x-blog.browse-more-button />
        </div>
    </div>
</div>