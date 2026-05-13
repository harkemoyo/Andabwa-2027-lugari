@props(['stream'])

<div {{ $attributes->merge(['class' => 'border rounded-xl p-4 bg-white justify-center shadow-sm transition hover:shadow-md']) }}>

    <!-- HEADER -->
    <div class="flex justify-between items-start">
        <div>
            <h3 class="font-bold text-lg text-gray-900">
                {{ $stream->title }}
            </h3>

            <p class="text-xs text-gray-400">
                Hosted by {{ $stream->user->name }}
            </p>
        </div>

        <!-- LIVE INDICATOR -->
        @if($stream->status === 'live')
            <span class="flex h-2 w-2 mt-2">
                <span class="animate-ping absolute inline-flex h-2 w-2 rounded-full bg-red-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
            </span>
        @endif
    </div>

    <!-- DESCRIPTION -->
    <p class="text-gray-500 text-sm line-clamp-2 mt-2">
        {{ $stream->description ?? 'No description provided.' }}
    </p>

    <!-- STATUS BADGE -->
    <div class="mt-3">
        @if($stream->status === 'live')
            <span class="text-xs px-2 py-1 rounded bg-red-100 text-red-600 font-semibold">
                LIVE NOW
            </span>
        @elseif($stream->status === 'scheduled')
            <span class="text-xs px-2 py-1 rounded bg-yellow-100 text-yellow-600 font-semibold">
                SCHEDULED
            </span>
        @else
            <span class="text-xs px-2 py-1 rounded bg-gray-100 text-gray-600 font-semibold">
                ENDED
            </span>
        @endif
    </div>

    <!-- ACTION -->
    <div class="mt-4 flex justify-between items-center">

        <!-- Host Avatar -->
        <div class="flex items-center space-x-2">
            <div class="w-6 h-6 rounded-full bg-indigo-100 flex items-center justify-center text-[10px] font-bold text-indigo-600">
                {{ strtoupper(substr($stream->user->name, 0, 2)) }}
            </div>
            <span class="text-xs font-medium text-gray-600">
                {{ $stream->user->name }}
            </span>
        </div>

        <!-- ROUTE FIXED -->
        <a href="{{ route('stream.show', $stream->uuid) }}"
           wire:navigate
           class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-indigo-700 transition">

            {{ $stream->status === 'live' ? 'Join Stream' : 'Go Stream' }}
        </a>
    </div>

</div>
<script>

    
    

</script>