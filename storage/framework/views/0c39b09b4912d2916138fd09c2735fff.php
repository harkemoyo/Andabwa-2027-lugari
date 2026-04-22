<div>
    <div
        x-data="socialDock()"
        x-init="init()"
        @mousemove="onMouseMove($event)"
        @mouseleave="reset()"
        class="relative flex items-end gap-3 justify-center sm:justify-start md:justify-end py-6"
        role="navigation"
        aria-label="Social media links"
    >

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($loading): ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php for($i = 0; $i < 5; $i++): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <div class="w-10 h-10 rounded-xl bg-gray-300 dark:bg-gray-700 animate-pulse"></div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        <?php else: ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $links; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $link): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <a href="<?php echo e($link->url); ?>"
                   target="_blank"
                   tabindex="0"
                   role="link"
                   aria-label="<?php echo e($link->platform_name); ?>"
                   @focus="setFocus(<?php echo e($index); ?>)"
                   @blur="reset()"
                   @mouseenter="startIntent(<?php echo e($index); ?>)"
                   @mouseleave="cancelIntent()"
                   class="relative outline-none"
                >

                    
                    <div
                        :style="getStyle(<?php echo e($index); ?>)"
                        class="flex items-center justify-center rounded-xl transition-all duration-200 ease-out"
                    >
                        <div
                            class="w-10 h-10 flex items-center justify-center rounded-xl shadow-sm transition-all duration-300"
                            style="background-color: <?php echo e($link->brand_color); ?>20;"
                        >
                            <img src="<?php echo e($link->full_image_path); ?>"
                                 alt=""
                                 class="w-6 h-6 object-contain pointer-events-none">
                        </div>
                    </div>

                    
                    <div
                        x-show="activeIndex === <?php echo e($index); ?>"
                        x-transition.opacity.duration.150ms
                        x-cloak
                        class="absolute bottom-full mb-2 left-1/2 -translate-x-1/2 text-xs px-2 py-1 rounded-md bg-black text-white whitespace-nowrap shadow-lg z-50"
                        role="tooltip"
                    >
                        <?php echo e($link->platform_name); ?>

                    </div>

                </a>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>    
</div><?php /**PATH C:\Users\Rygss\Downloads\andabwa-2027\resources\views/livewire/social-links-component.blade.php ENDPATH**/ ?>