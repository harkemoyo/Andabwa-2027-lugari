{{-- LATEST POSTS SECTION --}}
        <section class="relative py-12 overflow-hidden">

            {{-- HEADER --}}
            <div class="flex flex-col max-w-[1400px] mx-auto md:flex-row md:items-end justify-between mb-12 gap-8 px-4 md:px-6">
                <div class="max-w-3xl">
                    <span class="h-px w-8 bg-gradient-to-r from-purple-600 to-pink-500"></span>
                    <h2 class="text-sm md:text-xl  font-bold uppercase tracking-[0.3em] text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-600 italic">
                        {{ $this->pageSettings->latest_title ?? 'Latest Projects.' }}
                    </h2>
                    <p class="text-lg font-medium text-slate-500 mt-2 max-w-2xl">
                        {{ $this->pageSettings->latest_description ?? 'Discover the latest in Dr. GM OGW Andabwa Projects In Lugari Constituency.' }}
                    </p>
                </div>

                <a href="{{ route('blog.all-projects') }}"
                    class="group inline-flex items-center gap-4 px-4 py-2 bg-slate-950 text-white rounded-2xl hover:bg-purple-700 transition-all duration-500 shadow-2xl shadow-slate-950/20 active:scale-95">
                    <span class="text-xs font-black uppercase tracking-[0.3em]">
                        {{ $this->pageSettings->view_all_button ?? 'View All' }}
                    </span>
                    <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            </div>

            {{-- LATEST POSTS INFINITE SCROLLER --}}
            @if($this->latestPosts->isNotEmpty())
            <div

                x-data="insaneInfiniteSlider()"

                x-init="init()"

                class="relative group ">


                {{-- PROGRESS BAR (Netflix style) --}}

                <div class="absolute -top-6 left-1/2 -translate-x-1/2 w-1/3 h-[2px] bg-slate-100 rounded-full overflow-hidden">

                    <div

                        class="h-full bg-gradient-to-r from-purple-600 via-red-500 to-purple-600 bg-[length:200%_100%] animate-gradient-x transition-all duration-300"
                        :style="`width: ${progress}%`"></div>

                </div>
                {{-- EDGE FADES --}}
                <div class="absolute inset-y-0 left-0 w-24 bg-gradient-to-r from-white via-white/80 to-transparent z-10 pointer-events-none"></div>
                <div class="absolute inset-y-0 right-0 w-24 bg-gradient-to-l from-white via-white/80 to-transparent z-10 pointer-events-none"></div>

                {{-- NAV BUTTONS --}}
                <button @click="scroll(-1)"
                    class="hidden lg:flex items-center justify-center absolute left-2 top-1/2 -translate-y-1/2 z-30 
            bg-white/90 backdrop-blur-xl border border-slate-200 shadow-xl rounded-2xl w-12 h-12
            hover:text-purple-600 transition-all duration-300 text-sm  hover:border-red-400 transition-all duration-300">
                    ←
                </button>

                <button @click="scroll(1)"
                    class="hidden lg:flex items-center justify-center absolute right-2 top-1/2 -translate-y-1/2 z-30 
            bg-white/90 backdrop-blur-xl border border-slate-200 shadow-xl rounded-2xl w-12 h-12
             transition-all duration-300 text-sm  hover:text-purple-600 transition-all duration-300   hover:border-red-400 transition-all duration-300">
                    →
                </button>



                {{-- SCROLLER --}}

                <div

                    x-ref="track"

                    @mouseenter="pause()"

                    @mouseleave="play()"

                    class="flex overflow-x-auto gap-5 px-1 lg:px-12 py-5

               snap-x snap-mandatory scroll-smooth

               scrollbar-hide cursor-grab active:cursor-grabbing bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-3">



                    {{-- LEFT CLONE --}}

                    @foreach($this->latestPosts as $post)

                    @include('components.blog.post-card', ['post' => $post])

                    @endforeach



                    {{-- ORIGINAL --}}

                    @foreach($this->latestPosts as $post)

                    @include('components.blog.post-card', ['post' => $post])

                    @endforeach



                    {{-- RIGHT CLONE --}}

                    @foreach($this->latestPosts as $post)

                    @include('components.blog.post-card', ['post' => $post])

                    @endforeach



                </div>



            </div>
            @endif






        </section>