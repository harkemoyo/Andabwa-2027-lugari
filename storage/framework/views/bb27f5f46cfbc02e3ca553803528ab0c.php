<div class="card w-full shrink-0 
            bg-white rounded-2xl shadow-md hover:shadow-xl 
            transition duration-300 overflow-hidden p-2 border border-size-2 border-blue-300  hover:border-pink-500">

    
    <div class="aspect-[16/10] overflow-hidden p-3">
        <?php if (isset($component)) { $__componentOriginalbab2897d120281e4133c33a80785d679 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbab2897d120281e4133c33a80785d679 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.blog.media','data' => ['post' => $post]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('blog.media'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['post' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($post)]); ?>
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
    </div>

    
    <div class="p-5">

        <div class="flex items-center gap-2 mb-3">
            <span class="text-[11px] font-semibold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">
                <?php echo e($post->category->name); ?>

            </span>
            <span class="text-xs text-slate-500">
                <?php echo e($post->created_at->format('M j, Y')); ?>

            </span>
        </div>

        <h3 class="text-lg font-bold text-slate-900 line-clamp-2 hover:text-emerald-600 transition">
            <?php echo e($post->title); ?>

        </h3>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($post->meta_description): ?>
        <p class="text-sm text-slate-600 line-clamp-2 mt-2">
            <?php echo e($post->meta_description); ?>

        </p>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    </div>
</div><?php /**PATH C:\Users\Rygss\Downloads\andabwa-2027\resources\views/components/blog/post-card-top.blade.php ENDPATH**/ ?>