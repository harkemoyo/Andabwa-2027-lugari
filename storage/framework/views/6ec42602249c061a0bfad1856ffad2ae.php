

<div class="hidden md:block bg-gray-50 border-b border-gray-200">
    <nav class="bg-white border-b border-gray-100 shadow-sm sticky top-0 z-50">

    <div class="max-w-[1400px] mx-auto px-10 flex gap-8 py-3 text-xs font-bold uppercase tracking-widest text-gray-600">

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
        
         <a href=""            
            wire:navigate
            class="hover:text-red-600 transition-colors duration-200">
            <?php echo e($category->name); ?>

        </a>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        <span class="text-gray-400 normal-case font-normal">No categories available</span>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <div wire:loading class="ml-auto">
            <span class="animate-pulse text-red-500">Updating...</span>
        </div>
    </div>
    </nav>
</div>




<?php /**PATH C:\Users\Rygss\Downloads\andabwa-2027\resources\views/livewire/category-bar-component.blade.php ENDPATH**/ ?>