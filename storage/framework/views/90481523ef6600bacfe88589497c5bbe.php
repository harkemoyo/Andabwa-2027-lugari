<?php
$data = $getState();
$type = $data['type'] ?? null;
?>

<div class="relative overflow-hidden transition-all duration-200 bg-white border border-gray-200 shadow-sm rounded-xl ring-1 ring-gray-900/5 dark:bg-gray-900 dark:border-gray-700">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($data && $type): ?>
    <div class="flex flex-col">

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(in_array($type, ['youtube', 'video_embed']) && !empty($data['embed_url'])): ?>
        <div class="w-full bg-black aspect-video" wire:ignore>
            <iframe
                src="<?php echo e($data['embed_url']); ?>"
                class="w-full h-full"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                allowfullscreen
                referrerpolicy="strict-origin-when-cross-origin"
                loading="lazy">
            </iframe>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($type === 'video_file' && !empty($data['embed_url'])): ?>
        <div class="w-full bg-black aspect-video">
            <video
                class="w-full h-full"
                controls
                preload="metadata"
                playsinline>
                <source src="<?php echo e($data['embed_url']); ?>" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <div class="flex flex-col sm:flex-row">
            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!in_array($type, ['youtube', 'vimeo']) && ($data['image'] ?? null)): ?>
            <div class="shrink-0 sm:w-1/3">
                <img src="<?php echo e($data['image']); ?>"
                    alt="Preview"
                    class="object-cover w-full h-48 sm:h-full max-h-64">
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            
            <div class="<?php echo \Illuminate\Support\Arr::toCssClasses([ 'flex flex-col justify-between p-4 flex-1' , 'sm:w-2/3'=> !in_array($type, ['youtube', 'vimeo']) && ($data['image'] ?? null)
                ]); ?>">
                <div>
                    
                    <div class="flex items-center gap-2 mb-2">
                        <?php
                        $badgeColor = match($type) {
                        'youtube' => 'bg-red-600',
                        'video', 'vimeo' => 'bg-purple-600',
                        'image' => 'bg-green-600',
                        default => 'bg-blue-600',
                        };
                        ?>
                        <span class="px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-white <?php echo e($badgeColor); ?> rounded">
                            <?php echo e($type); ?>

                        </span>
                    </div>

                    <h4 class="text-base font-semibold leading-tight text-gray-900 dark:text-white line-clamp-2">
                        <?php echo e($data['title'] ?? 'No Title Found'); ?>

                    </h4>

                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400 line-clamp-3">
                        <?php echo e($data['description'] ?? 'No description available for this link.'); ?>

                    </p>
                </div>

                
                <div class="flex items-center gap-2 mt-4 text-xs font-medium text-primary-600 dark:text-primary-400 truncate">
                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-m-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4 shrink-0']); ?>
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
                    <a href="<?php echo e($data['url'] ?? '#'); ?>" target="_blank" class="truncate hover:underline">
                        <?php echo e($data['url'] ?? 'Source Link'); ?>

                    </a>
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
    
    <div class="flex flex-col items-center justify-center p-8 text-center bg-gray-50/50 dark:bg-gray-800/50">
        <div class="p-3 mb-3 border border-gray-200 rounded-full bg-white dark:bg-gray-900 dark:border-gray-700">
            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-o-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-6 h-6 text-gray-400']); ?>
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
        </div>
        <span class="text-sm font-medium text-gray-900 dark:text-white">Preview is empty</span>
        <span class="max-w-[200px] mt-1 text-xs text-gray-500">
            Enter a valid URL and click the sparkle icon to generate a preview.
        </span>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div><?php /**PATH C:\Users\Rygss\Downloads\andabwa-2027\resources\views/filament/components/link-preview.blade.php ENDPATH**/ ?>