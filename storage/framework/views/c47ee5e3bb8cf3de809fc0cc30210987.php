<div class="ml-2 mt-1.5 flex items-center" data-aos="fade-up" data-aos-duration="1000">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isLoading): ?>
    <div class="h-10 md:h-14 w-10 md:w-14 bg-gray-200 rounded-full animate-pulse"></div>
    <?php elseif($hasError): ?>
    <a
        href="<?php echo e($link); ?>"
        wire:navigate
        target="_self"
        class="inline-flex items-center group"
        aria-label="<?php echo e(config('app.name')); ?>">
        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-o-exclamation-circle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-8 h-8 text-red-500']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
    </a>
    <?php else: ?>
    <a
        href="<?php echo e($link); ?>"
        wire:navigate
        target="_self"
        class="inline-flex items-center group"
        aria-label="<?php echo e(config('app.name')); ?>">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($logo): ?>
        <img
            src="<?php echo e($logo); ?>"
            alt="<?php echo e(config('app.name')); ?> Logo"
            class="h-10 md:h-14 w-auto rounded-full hover:shadow-green-50 shadow-lg transition-all duration-300 group-hover:scale-105"
            loading="eager"
            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
        <div class="hidden items-center justify-center h-10 md:h-14 w-10 md:w-14 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full">
            <span class="text-white font-bold text-lg"><?php echo e(strtoupper(substr(config('app.name'), 0, 1))); ?></span>
        </div>
        <?php else: ?>
        <div class="flex items-center justify-center h-10 md:h-14 w-10 md:w-14 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full hover:shadow-green-50 shadow-lg transition-all duration-300 group-hover:scale-105">
            <span class="text-white font-bold text-lg"><?php echo e(strtoupper(substr(config('app.name'), 0, 1))); ?></span>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </a>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div><?php /**PATH C:\Users\Rygss\Downloads\andabwa-2027\resources\views/livewire/navigation-logo-header-component.blade.php ENDPATH**/ ?>