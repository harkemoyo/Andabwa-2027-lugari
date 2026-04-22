<div class="space-y-3 ">
    <div class="max-w-3xl mx-auto px-6 mb-6">
        <div class="flex items-center gap-3 hover:text-purple-600">
            <span class="h-px w-8 bg-gradient-to-r from-purple-600 to-pink-500"></span>
            <h2 class="text-sm font-bold uppercase tracking-[0.3em] text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-600">
                Trending
            </h2>
        </div>
    </div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $widgets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $widget): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
    <div class=" border hover:text-pink-800 rounded-xl p-4 shadow-sm border border-size-2 border-blue-300  hover:border-pink-500">

        <a href="<?php echo e($widget->url); ?>"
            target="_blank"
            rel="noopener noreferrer"
            class="hover:text-pink-900 transition-colors tracking-tight decoration-none">
            <h3 class="text-md md:text-lg font-bold hover:text-pink-500 transition-colors"><?php echo e($widget->title); ?></h3>
            <div class="hover:underline font-semibold text-black">
                <?php echo $widget->content; ?>

            </div>
        </a>

    </div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
</div><?php /**PATH C:\Users\Rygss\Downloads\andabwa-2027\resources\views/livewire/left-sidebar.blade.php ENDPATH**/ ?>