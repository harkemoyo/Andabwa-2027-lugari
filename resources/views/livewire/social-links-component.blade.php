<div wire:poll.10s="loadLinks" class="flex justify-center md:justify-start space-x-4 mt-6">
    <div class="flex justify-center md:justify-start space-x-4 mt-6">
        @foreach ($links as $link)
        <a href="{{ $link->url }}"
            target="_blank" class="hover:opacity-80 transition transform hover:scale-110">

            <img src="{{ $link->full_image_path }}"
                class="w-8 h-8 object-contain rounded-md">
        </a>
        @endforeach
    </div>
</div>