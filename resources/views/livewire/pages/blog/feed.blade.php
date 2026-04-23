<div class="lg:h-screen lg:overflow-hidden bg-[#f8fafc] antialiased text-slate-900">
    <div class="max-w-[1600px] mx-auto h-full shadow-2xl shadow-blue-900/5">

        <div class="grid grid-cols-1 lg:grid-cols-12 h-full gap-0 bg-white">

            <aside class="hidden lg:flex lg:col-span-3 border-r border-slate-100 flex-col h-full bg-slate-50/50" aria-label="Navigation Sidebar">
                <div class="p-8 h-full overflow-hidden">
                    <div class="mb-10 px-2">
                        <h1 class="text-xl font-black tracking-[0.1em] font-bold uppercase  text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-600">PORTAL.CORE</h1>
                    </div>
                    <livewire:sidebar.rotating-widgets />
                </div>
            </aside>

            <main class="col-span-1 lg:col-span-6 h-full overflow-y-auto scroll-smooth bg-white" aria-label="Main Feed">

                <div class="px-4 py-8 lg:p-10 space-y-12 max-w-4xl mx-auto">

                    <section>
                        <x-blog.latest-post-bottom />

                    </section>

                    <section class="space-y-8">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                            <h2 class="text-xl font-bold tracking-tight">Featured Projects</h2>
                            <span class="text-xs font-bold text-blue-600 uppercase tracking-widest">Priority Updates</span>
                        </div>

                        @if ($this->featuredPosts->isNotEmpty())
                        <div class="space-y-6">
                            @foreach ($this->featuredPosts as $post)
                            @include('components.blog.post-card-horizontal', ['post' => $post])
                            @endforeach
                        </div>
                        @endif
                    </section>

                    <section class="py-8">
                        <x-blog.latest-post-top />
                    </section>

                    <div class="pt-5 pb-16 flex justify-center">
                        <x-blog.browse-more-button />
                    </div>
                </div>
            </main>

            <aside class="hidden lg:flex lg:col-span-3 border-l border-slate-100 flex-col h-full bg-slate-50/30" aria-label="Secondary Sidebar">
                <div class="p-8 h-full overflow-hidden">
                    <livewire:left-sidebar />
                </div>
            </aside>

        </div>
    </div>
</div>