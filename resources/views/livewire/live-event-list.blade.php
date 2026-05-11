<div>
    <div class="max-w-[1400px] mx-auto px-4 grid grid-cols-12 gap-6">

        {{-- Right Sidebar --}}
        <div class="hidden lg:block lg:col-span-3 py-6">
            <livewire:right-sidebar />
        </div>

        {{-- Center --}}
        <div class="col-span-12 lg:col-span-6 py-6">

            @if($activeStream)
                <livewire:stream-room :stream="$activeStream" />

            @elseif($scheduledStream)
                <div class="bg-white border border-slate-200 rounded-3xl p-8 text-center shadow-sm">

                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-yellow-100 text-yellow-700 text-sm font-semibold mb-4">
                        Scheduled Stream
                    </div>

                    <h2 class="text-2xl font-bold text-slate-900 mb-3">
                        {{ $scheduledStream->title }}
                    </h2>

                    @if($scheduledStream->scheduled_at)
                        <p class="text-slate-600 text-lg">
                            Starts
                            {{ $scheduledStream->scheduled_at->format('F j, Y \a\t g:i A') }}
                        </p>
                    @endif

                </div>
            @endif

        </div>

        {{-- Left Sidebar --}}
        <div class="col-span-12 lg:col-span-3 py-6 space-y-6">
            <livewire:sidebar.rotating-widgets />
        </div>

        {{-- Browse --}}
        <div class="col-span-12 flex justify-center">
            <x-blog.browse-more-button />
        </div>

    </div>
</div>