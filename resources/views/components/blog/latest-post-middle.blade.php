{{-- LATEST POSTS INFINITE SCROLLER --}}
        @if($this->latestPosts->isNotEmpty())
        <div

            x-data="insaneInfiniteSliders()"

            x-init="init()"

            class="relative group mx-auto max-w-6xl hidden md:block">

            {{-- SCROLLER --}}

            <div

                x-ref="track"

                @mouseenter="pause()"

                @mouseleave="play()"

                class="flex overflow-x-auto gap-5 px-1 lg:px-12 py-4

               snap-x snap-mandatory scroll-smooth 

               scrollbar-hide cursor-grab active:cursor-grabbing  rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-3">
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