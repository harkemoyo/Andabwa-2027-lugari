<div class="max-w-7xl mx-auto px-6 py-12 font-semibold text-white">

    <h1 class="text-4xl font-bold mb-6">Our Services</h1>
    <p class="text-gray-600 mb-10 max-w-2xl">
        We provide high-quality digital solutions tailored to your business needs.
    </p>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

        <a href="{{ route('services.show', 'web-development') }}" wire:navigate
           class="p-6 bg-white rounded-xl shadow hover:shadow-lg transition">
            <h2 class="text-xl font-semibold mb-2">Web Development</h2>
            <p class="text-gray-500 text-sm">Modern, scalable web applications.</p>
        </a>

        <a href="{{ route('services.show', 'mobile-apps') }}" wire:navigate
           class="p-6 bg-white rounded-xl shadow hover:shadow-lg transition">
            <h2 class="text-xl font-semibold mb-2">Mobile Apps</h2>
            <p class="text-gray-500 text-sm">iOS & Android apps built for performance.</p>
        </a>

        <a href="{{ route('services.show', 'ui-ux-design') }}" wire:navigate
           class="p-6 bg-white rounded-xl shadow hover:shadow-lg transition">
            <h2 class="text-xl font-semibold mb-2">UI/UX Design</h2>
            <p class="text-gray-500 text-sm">Clean, user-centered interfaces.</p>
        </a>

    </div>
</div>