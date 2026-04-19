
<div class=" max-w-6xl mx-auto px-4 sm:px-6 lg:px-10 py-4">
    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->featuredPosts->isNotEmpty()): ?>
    <section class="mb-10">

    
    
        <div class="mb-10 px-1 border-l-4 border-purple-600 pl-6">
            <span class="h-px w-8 bg-gradient-to-r from-purple-600 to-pink-500"></span>
            <h2 class="text-sm md:text-xl  font-bold uppercase tracking-[0.3em] text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-600 italic">
                <?php echo e($this->pageSettings->featured_title ?? 'Featured Projects.'); ?>

            </h2>
            <p class="text-lg font-medium text-slate-500 mt-2 max-w-2xl">
                <?php echo e($this->pageSettings->featured_description ?? 'Discover the latest in Andabwa Projects.'); ?>

            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $this->featuredPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $featuredPost): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <div class="group relative bg-white rounded-3xl transition-all duration-500 hover:-translate-y-2">
                
                <div class="absolute inset-0 bg-gradient-to-br from-purple-500/5 to-red-500/5 opacity-0 group-hover:opacity-100 rounded-3xl transition-opacity duration-500"></div>

                <div class="relative overflow-hidden rounded-3xl border border-slate-100 shadow-sm group-hover:shadow-2xl group-hover:shadow-purple-500/10 transition-all duration-500">
                    <?php if (isset($component)) { $__componentOriginal6a0bd6cb4c22c12505d523f802edfba3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6a0bd6cb4c22c12505d523f802edfba3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.blog.card','data' => ['post' => $featuredPost]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('blog.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['post' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($featuredPost)]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6a0bd6cb4c22c12505d523f802edfba3)): ?>
<?php $attributes = $__attributesOriginal6a0bd6cb4c22c12505d523f802edfba3; ?>
<?php unset($__attributesOriginal6a0bd6cb4c22c12505d523f802edfba3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6a0bd6cb4c22c12505d523f802edfba3)): ?>
<?php $component = $__componentOriginal6a0bd6cb4c22c12505d523f802edfba3; ?>
<?php unset($__componentOriginal6a0bd6cb4c22c12505d523f802edfba3); ?>
<?php endif; ?>
                </div>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
    </section>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div><?php /**PATH C:\Users\Rygss\Downloads\andabwa-2027\resources\views/components/blog/featured-post.blade.php ENDPATH**/ ?>