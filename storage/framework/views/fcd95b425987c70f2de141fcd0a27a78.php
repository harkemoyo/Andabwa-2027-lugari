<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['post']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['post']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>




<article class="relative flex flex-col   h-full bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:border-green-100 transition-all duration-500 hover:shadow-2xl hover:-translate-y-1 overflow-hidden group focus-within:ring-2 focus-within:ring-green-500 focus-within:ring-offset-2">
    
    
    <?php if (isset($component)) { $__componentOriginalbab2897d120281e4133c33a80785d679 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbab2897d120281e4133c33a80785d679 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.blog.media','data' => ['post' => $post,'class' => 'transition-transform duration-700 group-hover:scale-110  ']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('blog.media'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['post' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($post),'class' => 'transition-transform duration-700 group-hover:scale-110  ']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbab2897d120281e4133c33a80785d679)): ?>
<?php $attributes = $__attributesOriginalbab2897d120281e4133c33a80785d679; ?>
<?php unset($__attributesOriginalbab2897d120281e4133c33a80785d679); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbab2897d120281e4133c33a80785d679)): ?>
<?php $component = $__componentOriginalbab2897d120281e4133c33a80785d679; ?>
<?php unset($__componentOriginalbab2897d120281e4133c33a80785d679); ?>
<?php endif; ?>

    <div class="p-6 md:p-8 flex flex-col flex-1 relative">
        
        
        <div class="flex items-center justify-between gap-4 mb-2">
            
            <span class="relative z-20 inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-50 text-green-700 tracking-wide border border-green-100/50">
                <?php echo e($post->category->name ?? 'Uncategorized'); ?>

            </span>
            
            <span class="text-xs font-medium text-gray-400 flex items-center gap-1.5">
                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <?php echo e($post->read_time ?? '5 min'); ?>

            </span>
        </div>

        
        <h2 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 group-hover:text-green-600 transition-colors duration-300 transition-colors">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($post->external_url && \App\Enums\MediaType::isExternal($post->media_type)): ?>
            <a href="<?php echo e(route('blog.external', $post->slug)); ?>" class="focus:outline-none">
            <?php else: ?>
            <a href="<?php echo e(route('posts.show', $post->slug)); ?>" class="focus:outline-none">
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                
                <span class="absolute inset-0 z-10" aria-hidden="true"></span>
                <?php echo e($post->title); ?>

            </a>
        </h2>

        
        <div class="flex-1 min-h-0 mb-6">
            <p class="text-gray-600 text-sm line-clamp-3 leading-relaxed flex-grow">
                <?php echo strip_tags($post->content); ?>

            </p>
        </div>

        
        <div class="mt-auto pt-4 border-t border-gray-100">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($post->external_url && \App\Enums\MediaType::isExternal($post->media_type)): ?>
            <a href="<?php echo e(route('blog.external', $post->slug)); ?>" class="inline-flex items-center text-sm font-semibold text-green-600 group-hover:text-green-700 transition-colors whitespace-nowrap">
                View Details
            <?php else: ?>
            <a href="<?php echo e(route('posts.show', $post->slug)); ?>" class="inline-flex items-center text-sm font-semibold text-green-600 group-hover:text-green-700 transition-colors whitespace-nowrap">
                Read Article
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <svg class="w-4 h-4 ml-1 transform transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </a>
        </div>
    </div>
</article><?php /**PATH C:\Users\Rygss\Downloads\andabwa-2027\resources\views/components/blog/card-latest-articles-top.blade.php ENDPATH**/ ?>