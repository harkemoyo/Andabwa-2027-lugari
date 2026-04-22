
            <div class="flex items-center gap-4">

                
                <div class="hidden md:block">
                    <form
                        action="<?php echo e(route('blog.all-projects')); ?>"
                        method="GET"
                        class="m-0 p-0">
                        <input
                            type="text"
                            name="search"
                            value="<?php echo e(request('search')); ?>"
                            placeholder="Search..."
                            class="px-4 py-2 text-sm rounded-full bg-white/20 text-white placeholder-white/70 border-none focus:ring-2 focus:ring-white/50">
                    </form>
                </div>

                <div class="flex items-center gap-4">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->guest()): ?>
                    <button
                        @click="$dispatch('login-modal')"
                        class="px-5 py-2 bg-white text-gray-900 rounded-full text-sm  hover:shadow-green-50 shadow-lg transition-all duration-300 group-hover:scale-105">
                        Sign In
                    </button>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                    <div x-data="{ openProfile: false }" class="relative">
                        <button @click="openProfile = !openProfile" @click.away="openProfile = false" class="flex items-center gap-2 text-sm font-medium text-gray-700 hover:text-indigo-600 transition">
                            <span class="bg-indigo-100 text-indigo-700 px-3 py-1.5 rounded-full font-bold">
                                <?php echo e(substr(auth()->user()->name, 0, 1)); ?>

                            </span>
                            <?php echo e(auth()->user()->name); ?>

                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="openProfile" x-transition x-cloak class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 border border-gray-100 ring-1 ring-black ring-opacity-5 z-50">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <p class="text-xs text-gray-500">Signed in as</p>
                                <p class="text-sm font-medium text-gray-900 truncate"><?php echo e(auth()->user()->email); ?></p>
                            </div>

                            <form method="POST" action="<?php echo e(route('logout')); ?>" class="w-full">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition">
                                    Sign out
                                </button>
                            </form>
                        </div>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>






                
                <button @click="mobileOpen = !mobileOpen" class="md:hidden p-2 text-white text-2xl">
                    <span x-show="!mobileOpen">☰</span>
                    <span x-show="mobileOpen">✕</span>
                </button>

            </div><?php /**PATH C:\Users\Rygss\Downloads\andabwa-2027\resources\views/partials/auth-buttons.blade.php ENDPATH**/ ?>