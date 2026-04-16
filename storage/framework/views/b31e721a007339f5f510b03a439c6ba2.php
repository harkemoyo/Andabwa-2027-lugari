<div <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'navbar-root'; ?>wire:key="navbar-root"
    x-data
    @keydown.escape="$store.nav.reset()"
    class="sticky top-0 z-50">

    

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->hasBreaking()): ?>
    
    <div
        x-data="{ show: true }"
        x-show="show"
        x-transition:enter="transition ease-out duration-500"
        x-transition:enter-start="opacity-0 -translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        class="bg-red-600 text-white text-sm font-semibold flex items-center overflow-hidden">

        <div class="px-4 py-2 bg-white uppercase tracking-wider shrink-0 shadow-lg z-10">
            <p class="">🔴</p>
            <p class="text-red-600">Breaking</p>
        </div>

        
        <div class="flex-1 px-4 py-2 flex items-center gap-6 overflow-x-auto whitespace-nowrap scrollbar-hide animate-ticker hover:[animation-play-state:paused]">

            
            <div class="flex animate-ticker gap-6">
                <template x-for="i in 3">
                    <div class="flex gap-6">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $breakingItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <div class="flex items-center gap-2">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->is_live): ?>
                            <span class="flex h-3 w-3 relative">
                                <span class="animate-ping absolute h-full w-full rounded-full bg-red-300 opacity-75"></span>
                                <span class="relative h-3 w-3 rounded-full bg-white"></span>
                            </span>
                            <span class="text-[10px] px-2 py-0.5 rounded bg-yellow-400 text-black"
                                x-show="'<?php echo e($item->status); ?>'">
                                <?php echo e($item->status); ?>

                            </span>
                            <span class="text-xs text-red-200 uppercase">Live</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <a href="<?php echo e($item->url); ?>"
                                wire:navigate
                                wire:prefetch @click="$wire.trackClick(<?php echo e($item->id); ?>)"
                                class="hover:underline">
                                <?php echo e($item->label ?? $item->title); ?>

                            </a>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>
                </template>
            </div>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


    
    <div
        x-data="navSystem()"
        x-init="init()"
        @keydown.escape="closeAll()"
        class="sticky top-0 p-3 z-50 backdrop-blur-xl bg-gradient-to-r from-purple-500/90 via-pink-500/90 to-red-500/90 border-b border-white/10 shadow-md">

        <div class="max-w-[1400px]  xl:max-w-[1500px] mx-auto px-4 sm:px-6 lg:px-10 ">
            <div class="flex items-center justify-between h-16">

                
                <div class="flex items-center gap-4">
                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('navigation-logo-header-component', []);

$__keyOuter = $__key ?? null;

$__key = null;
$__componentSlots = [];

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-2566966641-0', $__key);

$__html = app('livewire')->mount($__name, $__params, $__key, $__componentSlots);

echo $__html;

unset($__html);
unset($__key);
$__key = $__keyOuter;
unset($__keyOuter);
unset($__name);
unset($__params);
unset($__componentSlots);
unset($__split);
?>
                </div>

                
                <nav class="hidden md:flex items-center gap-6 lg:gap-8 text-sm font-medium text-white/90">

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($menu->items && $menu->items->count()): ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $menu->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>

                    <div class="relative"
                        @mouseenter="$store.nav.openMenu(<?php echo e($index); ?>)"
                        @mouseleave="$store.nav.closeMenu()">

                        
                        <button
                            :aria-expanded="open.toString()"
                            @focus="openWithIntent"
                            @keydown.enter.prevent="toggle"
                            @keydown.arrow-down.prevent="openAndFocusFirst"
                            class="relative px-1 py-2 hover:text-gray-700 focus:outline-none">
                            <?php echo e($item->title); ?>


                            <span class="absolute left-0 -bottom-1 w-0 h-[2px] bg-red-600 transition-all duration-300 group-hover:w-full"></span>
                        </button>

                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->children->count()): ?>
                        <div
                            x-show="$store.nav.activeMenu === <?php echo e($index); ?>"
                            x-transition
                            x-cloak
                            @keydown.escape.stop="close"
                            class="absolute left-0 top-full mt-3 w-[90vw] max-w-[640px]
                               bg-white text-gray-800 border border-gray-100
                               rounded-2xl shadow-xl p-5
                               grid grid-cols-1 sm:grid-cols-2 gap-4"
                            role="menu">

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $item->children->where('is_active', true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $childIndex => $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>

                            <a
                                href="<?php echo e($child->url ?? url($child->slug)); ?>"
                                target="_blank"
                                role="menuitem"
                                tabindex="-1"
                                @keydown.arrow-down.prevent="$focus.next()"
                                @keydown.arrow-up.prevent="$focus.previous()"
                                class="block p-3 rounded-lg hover:bg-gray-50 focus:bg-gray-50 transition">
                                <p class="font-semibold text-sm">
                                    <?php echo e($child->title); ?>

                                </p>

                                <p class="text-xs text-gray-500 mt-1">
                                    Explore <?php echo e($child->title); ?> updates
                                </p>
                            </a>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    </div>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                </nav>

                
                <div class="flex items-center gap-3 sm:gap-4">

                    
                    <div class="hidden md:block">
                        <input
                            wire:model.live.debounce.300ms="search"
                            type="text"
                            placeholder="Search news..."
                            class="w-40 lg:w-52 px-4 py-2 text-sm  rounded-full
                               border border-white/20 bg-white/90 text-gray-800
                               focus:outline-none focus:ring-2 focus:ring-white/60 transition">
                    </div>

                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard()->check()): ?>
                    <div class="relative" x-data="{ open: false, rect: null }">

                        <button
                            @click="open = !open; rect = $el.getBoundingClientRect()"
                            class="w-9 h-9 rounded-full bg-white/20 flex items-center justify-center">
                            <span class="text-white text-xs font-semibold">
                                <?php echo e(strtoupper(substr(auth()->user()->name, 0, 1))); ?>

                            </span>
                        </button>

                        <div
                            x-show="$store.nav.activeMenu === <?php echo e($index); ?>"
                            x-transition
                            x-cloak
                            :style="`position: absolute; right: 0; top: calc(100% + 8px);`"
                            class="w-56 bg-white border rounded-xl shadow-2xl z-50">
                            <div class="px-4 py-3 border-b">
                                <p class="text-sm font-semibold"><?php echo e(auth()->user()->name); ?></p>
                                <p class="text-xs text-gray-500"><?php echo e(auth()->user()->email); ?></p>
                            </div>

                            <a href="#" class="block px-4 py-2 hover:bg-gray-50">Dashboard</a>
                            <a href="#" class="block px-4 py-2 hover:bg-gray-50">Profile</a>

                            <div class="border-t mt-2 pt-2">
                                <form method="POST" action="<?php echo e(route('logout')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button class="w-full text-left px-4 py-2 text-red-600 hover:bg-red-50">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                    <?php else: ?>
                    <button  
                        @click="$dispatch('login-modal')"
                        class="px-4 py-2 hover:shadow-green-50 shadow-lg hover:text-gray-800 text-sm rounded-full bg-white text-gray-800 hover:bg-gray-100 transition">
                        Sign In
                    </button>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    
                    <div class="md:hidden">
                        <button
                            @click="mobileOpen = !mobileOpen"
                            class="p-2 rounded-lg bg-white/20">
                            ☰
                        </button>
                    </div>

                </div>

            </div>
        </div>

        
        <div
            x-show="mobileOpen"
            x-transition
            class="md:hidden bg-white text-gray-800 border-t shadow-lg">
            <div class="px-4 py-4 space-y-4">

                
                <input
                    wire:model.live.debounce.300ms="search"
                    type="text"
                    placeholder="Search..."
                    class="w-full px-4 py-2 rounded-full border">

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $menu->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>

                <div x-data="{ open: false }">

                    <button
                        @click="open = !open"
                        class="w-full text-left font-semibold py-2 flex justify-between">
                        <?php echo e($item->title); ?>

                        <span x-text="open ? '-' : '+'"></span>
                    </button>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item->children->count()): ?>
                    <div x-show="$store.nav.activeMenu === <?php echo e($index); ?>"
                        x-transition
                        x-cloak class="pl-4 space-y-2 mt-2">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $item->children->where('is_active', true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                        <a href="<?php echo e($child->url ?? url($child->slug)); ?>"
                            class="block text-sm text-gray-600">
                            <?php echo e($child->title); ?>

                        </a>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

            </div>
        </div>

    </div>

    
    <div class="hidden md:block bg-green-50 border-b">
        <div class="max-w-[1400px]  xl:max-w-[1500px] mx-auto px-4 sm:px-6 lg:px-10 flex gap-6 py-4 items-center text-sm text-gray-900">
            <span class="hover:text-black cursor-pointer">Politics</span>
            <span class="hover:text-black cursor-pointer">Business</span>
            <span class="hover:text-black cursor-pointer">Technology</span>
            <span class="hover:text-black cursor-pointer">Health</span>
            <span class="hover:text-black cursor-pointer">Sports</span>

        </div>
    </div>

    
    <div x-show="mobileOpen"
        x-cloak
        class="md:hidden bg-white border-t p-4 space-y-2">

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $menu->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
        <div x-data="{ open: false }">
            <button
                @focus="$store.nav.openMenu(<?php echo e($index); ?>)"
                @keydown.arrow-down.prevent="$refs.menu<?php echo e($index); ?>.focus()"
                @keydown.escape="$store.nav.closeMenu()"
                :aria-expanded="$store.nav.activeMenu === <?php echo e($index); ?>"
                class="w-full text-left font-semibold py-2 flex justify-between items-center text-gray-800">
                <?php echo e($item->title); ?>

                <span :class="{ 'rotate-180': open }" class="transition-transform duration-200">⌄</span>
            </button>

            <div x-show="$store.nav.activeMenu === <?php echo e($index); ?>"
                x-transition
                x-cloak x-collapse class="pl-4 border-l-2 border-red-50 ml-1">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $item->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <a x-ref="menu<?php echo e($index); ?>"
                    tabindex="-1"
                    @keydown.arrow-down.prevent="$focus.next()"
                    @keydown.arrow-up.prevent="$focus.previous()"> href="<?php echo e($child->url ?? url($child->slug)); ?>" class="block py-2 text-sm text-gray-600 hover:text-red-600">
                    <?php echo e($child->title); ?>

                </a>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

    </div>

</div><?php /**PATH C:\Users\Rygss\Downloads\andabwa-2027\resources\views/livewire/dynamic-navbar.blade.php ENDPATH**/ ?>