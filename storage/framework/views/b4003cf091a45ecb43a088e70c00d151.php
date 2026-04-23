<div>
    <div
        x-data="sidebarManager({ 
            duration: 5000, 
            totalWidgets: <?php echo e(count($widgets)); ?> 
        })"
        x-show="isOpen"
        x-cloak
        x-on:sidebar-data-updated.window="syncData()"
        class="relative w-auto mt-10 h-[320px] perspective group">

        
        <button
            @click="closeSidebar()"
            class="absolute hidden top-2 right-2 z-50 p-1.5 rounded-full bg-white/90 border shadow-sm text-gray-400 hover:text-red-500 transition-colors">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $widgets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $widget): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
        <div
            data-widget-id="<?php echo e($widget['id'] ?? ''); ?>"
            data-weight="<?php echo e($widget['weight'] ?? 1); ?>"
            x-show="activeIndex === <?php echo e($index); ?>"
            x-transition:enter="transition duration-500 ease-out"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            class="absolute inset-0 bg-white border border-size-2 border-blue-300 hover:border-pink-500 rounded-2xl shadow-lg p-4 flex flex-col">

            <a href="<?php echo e($widget['url'] ?? '#'); ?>"
                target="_blank"
                rel="noopener noreferrer"
                class="hover:text-pink-900 transition-colors uppercase tracking-tight decoration-none block h-full">

                <span class="text-[10px] font-bold text-gray-600 uppercase tracking-widest mb-2 block">
                    <?php echo e($widget['title'] ?? ''); ?>

                </span>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($widget['full_widget_image_path'])): ?>
                <div class="flex-1 flex items-center objet-contain justify-center ad-content-area overflow-hidden h-[calc(100%-1.5rem)]">
                    <img src="<?php echo e($widget['full_widget_image_path'] ?? ''); ?>" alt="<?php echo e($widget['title'] ?? ''); ?>" class="w-full h-full object-cover rounded">
                </div>
                <?php else: ?>
                <div class="flex-1 flex text-black items-center justify-center ad-content-area overflow-hidden h-[calc(100%-1.5rem)]">
                    <?php echo $widget['content'] ?? ''; ?>

                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </a>
        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
    </div>    
</div><?php /**PATH C:\Users\Rygss\Downloads\andabwa-2027\resources\views/livewire/sidebar/rotating-widgets.blade.php ENDPATH**/ ?>