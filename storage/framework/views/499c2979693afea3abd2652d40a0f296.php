

<div>
    


    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 p-8 w-full">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $tvChannels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
    <div class="bg-white rounded-2xl shadow-sm border  border-gray-100 overflow-hidden group">
        <div class="relative h-48">

            <div class="absolute inset-0 z-0">
                <img src="<?php echo e($tv->full_cover_image_path); ?>"
                    alt="<?php echo e($tv->title); ?>"
                    class="h-full w-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-black/20 to-black/60"></div>
            </div>
            <div class="ustify-center items-center">
                <img src="<?php echo e($tv->full_cover_image_path); ?>" alt="" class="w-20 h-20 rounded-full object-contain object-center pointer-events-none">
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tv->type === 'live'): ?>
            <span class="absolute top-4 right-4 bg-red-600 text-white text-[10px] font-bold px-2 py-1 rounded-full animate-pulse">
                LIVE
            </span>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        <div class="p-6">
            <h3 class="text-xl font-bold text-gray-900 group-hover:text-indigo-600 transition"><?php echo e($tv->title); ?></h3>
            <p class="text-gray-500 text-sm mt-2 line-clamp-2"><?php echo e($tv->description); ?></p>

            <div class="mt-6 flex items-center justify-between">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($tv->type === 'upload'): ?>
                <button class="flex items-center gap-2 text-indigo-600 font-semibold text-sm">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" />
                    </svg>
                    Listen Now (<?php echo e($tv->duration_minutes); ?>m)
                </button>
                <?php else: ?>
                <a href="<?php echo e($tv->live_url); ?>" target="_blank" class="bg-gray-900 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-800">
                    Join Stream
                </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

    <div class="col-span-full">
        <?php echo e($tvChannels->links()); ?>

    </div>
</div>
</div><?php /**PATH C:\Users\Rygss\Downloads\andabwa-2027\resources\views/livewire/tv-list.blade.php ENDPATH**/ ?>