<div class="w-full max-w-7xl mx-auto p-4 sm:p-8">
    <div class=" grid  grid-cols-2 py-2 mb-10 justify-between mx-auto gap-10">
        <div class="hidden md:block max-w-2xl ">
            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('sidebar.rotating-widgets', []);

$__keyOuter = $__key ?? null;

$__key = null;
$__componentSlots = [];

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-2324708769-0', $__key);

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
        <div class="hidden md:block">
            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('left-sidebar', []);

$__keyOuter = $__key ?? null;

$__key = null;
$__componentSlots = [];

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-2324708769-1', $__key);

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

    </div>


    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $liveEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
        <div <?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::$currentLoop['key'] = 'event-'.e($event->id).''; ?>wire:key="event-<?php echo e($event->id); ?>" class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-xl transition-all duration-300 flex flex-col">

            
            <div class="relative h-56 overflow-hidden bg-gray-900">
                
                <div class="absolute inset-0 z-0">
                    <img src="<?php echo e($event->full_cover_image_path ?? asset('images/default-event.jpg')); ?>"
                        alt="<?php echo e($event->title); ?>"
                        class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-500 opacity-80">
                    <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40 to-transparent"></div>
                </div>

                
                <div class="absolute top-4 right-4 z-10 flex gap-2">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->type === 'live'): ?>
                    <span class="flex items-center gap-1.5 bg-red-600/90 backdrop-blur-sm text-white text-[10px] uppercase tracking-wider font-bold px-3 py-1.5 rounded-full animate-pulse shadow-sm">
                        <span class="h-1.5 w-1.5 bg-white rounded-full"></span>
                        Live Now
                    </span>
                    <?php else: ?>
                    <span class="bg-gray-900/80 backdrop-blur-sm text-white text-[10px] uppercase tracking-wider font-bold px-3 py-1.5 rounded-full shadow-sm">
                        Recorded
                    </span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            
            <div class="p-6 flex flex-col flex-1">
                <h3 class="text-xl font-bold text-gray-900 group-hover:text-indigo-600 transition-colors duration-200 line-clamp-2">
                    <?php echo e($event->title); ?>

                </h3>
               <p class="text-gray-500 text-sm mt-3 line-clamp-3 flex-1">
                    <?php echo e($event->description); ?>

                </p>


                
                <div class="mt-6 pt-6 border-t border-gray-100 flex items-center justify-between">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($event->type === 'upload'): ?>
                    <button class="flex items-center gap-2 text-indigo-600 hover:text-indigo-700 font-bold text-sm transition-colors">
                        <svg class="w-8 h-8 text-indigo-100 fill-indigo-600" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                        </svg>
                        <span>Listen (<?php echo e($event->duration_minutes); ?>m)</span>
                    </button>
                    <?php else: ?>
                    <a href="<?php echo e($event->live_url); ?>" target="_blank" rel="noopener noreferrer"
                        class="inline-flex items-center justify-center w-full bg-gray-900 text-white px-4 py-3 rounded-xl text-sm font-bold hover:bg-indigo-600 transition-colors shadow-sm active:scale-[0.98]">
                        Join Live Stream
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

        </div>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
    </div>

    
    <div class="mt-12 w-full">
        <?php echo e($liveEvents->links()); ?>

    </div>
</div><?php /**PATH C:\Users\Rygss\Downloads\andabwa-2027\resources\views/livewire/live-event-list.blade.php ENDPATH**/ ?>