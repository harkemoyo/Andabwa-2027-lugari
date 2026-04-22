{{-- Main Container --}}
<div class="-mt-4 sm:mt-16 md:-mt-16 lg:-mt-8 ">
    {{-- FEATURED POSTS --}}
    @if ($this->featuredPosts->isNotEmpty())
    <section class="mb-6">

        {{-- Section Header --}}
        <div class="mb-6 -mt-0 sm:mt-16 md:mt-16 lg:mt-2">
            <div class="max-w-3xl">
                <span class="h-0.5 w-12 bg-gradient-to-r from-purple-600 to-pink-500 block mb-2"></span>
                <h2 class="text-sm md:text-xl font-bold uppercase tracking-[0.3em] text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-600 italic">
                    {{ $this->pageSettings->featured_title ?? 'Featured Projects.' }}
                </h2>
                <p class="text-sm md:text-lg font-normal text-slate-500 mt-2 max-w-2xl">
                    {{ $this->pageSettings->featured_description ?? 'Highlighted projects for Dr. GM OGW Andabwa Projects In Lugari Constituency.' }}
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 ">
            @foreach ($this->featuredPosts as $featuredPost)
            <div class="group relative bg-white rounded-3xl transition-all duration-500 hover:-translate-y-2 border border-size-2 border-blue-300  hover:border-pink-500">
                {{-- Subtle Card Glow on Hover --}}
                <div class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-red-500/5 opacity-0 group-hover:opacity-100 rounded-3xl transition-opacity duration-500"></div>

                <div class="relative overflow-hidden rounded-3xl border border-slate-100 shadow-sm group-hover:shadow-2xl group-hover:shadow-purple-500/10 transition-all duration-500">
                    <x-blog.card :post="$featuredPost" />
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif
</div>