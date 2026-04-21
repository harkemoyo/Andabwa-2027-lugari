<div class="max-w-5xl mx-auto px-6 py-12">

    <h1 class="text-3xl font-bold capitalize mb-4">
        {{ str_replace('-', ' ', $slug) }}
    </h1>

    <p class="text-gray-600 mb-6">
        Detailed information about {{ $slug }} service.
    </p>

    <a href="{{ route('services') }}" wire:navigate
       class="text-blue-600 font-semibold hover:underline">
        ← Back to Services
    </a>

</div>