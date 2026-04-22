    {{-- Section Header --}}
    <div class="justify-center text-center py-4 max-w-3xl mx-auto">
        <h2 class="text-sm md:text-2xl font-bold uppercase tracking-[0.3em] text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-600">
            {{ $this->pageSettings->header_title ?? 'Featured Projects.' }}
        </h2>
        <p class="text-sm md:text-lg font-normal text text-slate-500">
            {{ $this->pageSettings->header_description ?? 'Highlighted projects for Dr. GM OGW Andabwa Projects In Lugari Constituency.' }}
        </p>
    </div>