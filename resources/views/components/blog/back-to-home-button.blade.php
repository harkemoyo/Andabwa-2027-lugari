{{-- BACK TO HOME BUTTON 
<div class="mb-1justfy-self-center md:justify">
    <a href="{{ route('home') }}" wire:navigate class="inline-flex   hover:underline items-center text-sm font-medium text-green-600  mb-6 transition-colors px-4 py-2 bg-slate-100 rounded-lg">
        <svg class="w-4 h-4 mr-2 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        @if($post->pageSettings->editorial_button_text ?? 'Back to Editorial') @endif
    </a>
</div>--}}