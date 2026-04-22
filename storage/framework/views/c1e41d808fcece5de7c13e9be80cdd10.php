<div class="min-h-screen">
    
    <div class="relative max-w-5xl mx-auto">
        
        <?php if (isset($component)) { $__componentOriginal66d2eea31bb1d7e8233a46ffea4cf629 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal66d2eea31bb1d7e8233a46ffea4cf629 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.blog.all-projects-header','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('blog.all-projects-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal66d2eea31bb1d7e8233a46ffea4cf629)): ?>
<?php $attributes = $__attributesOriginal66d2eea31bb1d7e8233a46ffea4cf629; ?>
<?php unset($__attributesOriginal66d2eea31bb1d7e8233a46ffea4cf629); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal66d2eea31bb1d7e8233a46ffea4cf629)): ?>
<?php $component = $__componentOriginal66d2eea31bb1d7e8233a46ffea4cf629; ?>
<?php unset($__componentOriginal66d2eea31bb1d7e8233a46ffea4cf629); ?>
<?php endif; ?>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 py-8">

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->posts->isNotEmpty()): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 ">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $this->posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <div class="relative group bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden flex flex-col">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($post->external_url && \App\Enums\MediaType::isExternal($post->media_type)): ?>
                <a href="<?php echo e(route('blog.external', $post->slug)); ?>" class="block flex-1 flex flex-col">
                    <?php else: ?>
                    <a href="<?php echo e(route('posts.show', $post->slug)); ?>" class="block flex-1 flex flex-col">
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <div class="flex flex-col h-full">
                            
                            <div class="aspect-video overflow-hidden bg-slate-100">
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

                            
                            <div class="p-5 flex flex-col flex-1">
                                <div class="flex items-center gap-2 mb-3">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($post->category): ?>
                                    <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full">
                                        <?php echo e($post->category->name); ?>

                                    </span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <span class="text-xs text-slate-500 whitespace-nowrap">
                                        <?php echo e($post->created_at->format('M j, Y')); ?>

                                    </span>
                                </div>

                                <h3 class="text-lg font-bold text-slate-900 mb-2 line-clamp-2 group-hover:text-emerald-600 transition-colors flex-1">
                                    <?php echo e($post->title); ?>

                                </h3>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($post->meta_description): ?>
                                <p class="text-sm text-slate-600 line-clamp-2 mb-4">
                                    <?php echo e($post->meta_description); ?>

                                </p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                <span class="text-emerald-600 font-semibold text-sm group-hover:text-emerald-700 transition-colors mt-auto">
                                    Read More →
                                </span>
                            </div>
                        </div>
                    </a>
            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->posts->hasPages()): ?>
        <div class="flex justify-center mb-8">
            <?php echo e($this->posts->links('pagination::tailwind')); ?>

        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php else: ?>
        <div class="text-center py-20">
            <svg class="w-16 h-16 mx-auto text-slate-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="text-lg text-slate-600 mb-4">No projects found</p>
            <p class="text-slate-500 mb-6">Try adjusting your search or filter criteria</p>
            <button
                wire:click="resetFilters"
                class="px-6 py-2 bg-emerald-600 text-white font-semibold rounded-lg hover:bg-emerald-700 transition-colors">
                Clear Filters
            </button>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    </div>
</div><?php /**PATH C:\Users\Rygss\Downloads\andabwa-2027\resources\views/livewire/pages/blog/all-projects.blade.php ENDPATH**/ ?>