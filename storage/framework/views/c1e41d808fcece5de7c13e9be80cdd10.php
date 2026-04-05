<div class="min-h-screen">
    
    <div class="max-w-4xl h-8 md:h-54 mx-auto mb-10 p-3 absolute inset-0 -z-10 opacity-50 pointer-events-none"
        style="background-image: radial-gradient(circle, #6366f1 2px, transparent 2px);
                       background-size: 38px 38px;">
    </div>
    <div class="max-w-7xl md:max-w-7xl lg:max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 mt-2 pb-20">

        
        <div class="relative max-w-5xl mx-auto text-center pb-10">
            <div class="absolute inset-0 -z-10 opacity-10 pointer-events-none"
                style="background-image: radial-gradient(circle, #6366f1 1px, transparent 1px);
                       background-size: 38px 38px;">
            </div>

            <div class="inline-flex items-center gap-3 px-6 py-2 bg-slate-100 rounded-full shadow-sm mt-2 mb-6">
                <div class="relative h-2 w-2">
                    <span class="animate-ping absolute h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative h-2 w-2 rounded-full bg-emerald-500"></span>
                </div>
                <span class="text-[11px] font-bold tracking-widest uppercase text-slate-800 leading-tight">
                    All Projects
                </span>
            </div>

            <h1 class="text-2xl md:text-3xl font-bold text-slate-900 leading-tight mb-4">
                <span class="bg-gradient-to-br from-slate-900 to-slate-600 bg-clip-text text-transparent">
                    <?php echo e($this->pageSettings->posts_title ?? 'All Projects'); ?>

                </span>
            </h1>

            <p class="text-lg md:text-xl font-medium text-slate-800 max-w-3xl mx-auto">
                Explore our complete collection of development initiatives and community projects for Lugari Constituency
            </p>
        </div>

        
        <div class="bg-white p-3 rounded-xl shadow-sm flex flex-col md:flex-row items-center gap-4 max-w-4xl mx-auto mb-10">

            
            <div class="relative w-full md:flex-1">
                <input
                    wire:model.live.debounce.300ms="search"
                    type="text"
                    placeholder="Search projects..."
                    class="w-full pr-12 pl-4 py-3 bg-white border rounded-lg text-sm text-slate-900 placeholder-slate-500
               focus:ring-2 focus:ring-emerald-500 focus:outline-none">

                <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-800">
                    🔍
                </span>
            </div>

            
            <select
                wire:model.live="categoryId"
                class="w-full md:w-56 py-3 px-4 bg-white border rounded-lg text-sm text-slate-800
                       focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                <option value="">All Categories</option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $this->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </select>

            
            <button
                wire:click="resetFilters"
                class="flex items-center justify-center px-6 py-3 bg-slate-100 text-slate-800 font-medium rounded-lg hover:bg-slate-500 transition-colors duration-200 shadow-sm whitespace-nowrap">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Reset
            </button>
        </div>

        
        <div class="mb-6">
            <a href="<?php echo e(route('home')); ?>" class="inline-flex items-center text-emerald-600 hover:text-emerald-700 font-semibold transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Home
            </a>
        </div>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->posts->isNotEmpty()): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $this->posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
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