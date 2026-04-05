<div class="min-h-screen ">

    
    <div class="max-w-7xl md:max-w-7xl lg:max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 mt-2 pb-20">

        
        
        <div class="relative max-w-5xl mx-auto text-center pb-10">

            
            
            <div class="absolute inset-0 -z-10 opacity-50 pointer-events-none"
                style="background-image: radial-gradient(circle, #6366f1 1px, transparent 1px);
                       background-size: 38px 38px;">
            </div>

            
            <div class="inline-flex items-center gap-3 px-6 py-2 bg-slate-100 rounded-full shadow-sm mt-2 mb-6">
                <div class="relative h-2 w-2">
                    <span class="animate-ping absolute h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative h-2 w-2 rounded-full bg-emerald-500"></span>
                </div>
                <span class="text-[11px] font-bold tracking-widest uppercase text-slate-800 leading-tight">
                    <?php echo e($this->pageSettings->header_subtitle ?? 'Community Insights'); ?>

                </span>
            </div>

            
            <h1 class="text-2xl md:text-3xl font-bold text-slate-900 leading-tight">
                <span class="bg-gradient-to-br from-slate-900 to-slate-600 bg-clip-text text-transparent">
                    <?php echo e($this->pageSettings->header_title ?? 'Dr. Isaac GM Andabwa for Lugari'); ?>

                </span>
            </h1>

            
            <div class="text-2xl sm:text-3xl text-emerald-500  py-1 animate-pulse">
                <?php echo e($this->pageSettings->header_emoji ?? '✨ ⚡ 🚀'); ?>

            </div>

            
            <p class="text-lg md:text-xl font-medium text-slate-800 max-w-3xl mx-auto ">
                <?php echo e($this->pageSettings->header_description ?? 'Discover your 2027 Lugari MP.'); ?>

            </p>

        </div>

        
        <div class="bg-white p-3 rounded-xl shadow-sm flex flex-col md:flex-row items-center gap-4 max-w-4xl mx-auto">

            
            <div class="relative w-full md:flex-1">
                <input
                    wire:model.live.debounce.300ms="search"
                    type="text"
                    placeholder="Search..."
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
                <option value=""><?php echo e($this->pageSettings->search_title ?? 'All Categories'); ?></option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $this->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </select>



            
            <button
                wire:click="$set('search','');$set('categoryId',null);$set('tagId',null)"
                class="flex items-center justify-center px-6 py-3 bg-slate-100 text-slate-800 font-medium rounded-lg hover:bg-slate-500 transition-colors duration-200 shadow-sm">
                <svg class="w-4 h-4 ml-2 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                Reset
            </button>

        </div>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->featuredPosts->isNotEmpty()): ?>
        <div class="py-10 ">

            <div class=" py-4 px-1 ">
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 ">
                    <?php echo e($this->pageSettings->featured_title ?? 'Featured Projects.'); ?>

                </h2>
                <p class="text-lg font-semibold text-slate-800 py-2">
                    <?php echo e($this->pageSettings->featured_description ?? 'Discover the latest in Andabwa Projects.'); ?>

                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-2 ">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $this->featuredPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $featuredPost): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                <div class="group bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 md:p-0">
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
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>

        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <div class="py-4 flex items-center justify-between">
            <div>
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900">
                    <?php echo e($this->pageSettings->latest_title ?? 'Latest Projects.'); ?>

                </h2>
                <p class="text-lg  font-semibold text-slate-800 py-2">
                    <?php echo e($this->pageSettings->latest_description ?? 'Discover the latest in Dr. GM OGW Andabwa Projects In Lugari Constituency.'); ?>

                </p>
            </div>
            <a href="<?php echo e(route('blog.all-projects')); ?>" class="px-6 py-3 bg-emerald-600 text-white font-semibold rounded-lg hover:bg-emerald-700 transition-colors duration-200 shadow-md whitespace-nowrap">
                View All Projects →
            </a>
        </div>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->latestPosts->isNotEmpty()): ?>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6  py-4">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $this->latestPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <div class="relative group bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 md:p-1">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($post->external_url && \App\Enums\MediaType::isExternal($post->media_type)): ?>
                <a href="<?php echo e(route('blog.external', $post->slug)); ?>" class="block">
                    <?php else: ?>
                    <a href="<?php echo e(route('posts.show', $post->slug)); ?>" class="block">
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <div class="bg-transparent rounded-xl overflow-hidden border border-slate-100">
                            
                            <div class="aspect-video overflow-hidden">
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

                            
                            <div class="p-4">
                                <div class="flex items-center gap-2 mb-2">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($post->category): ?>
                                    <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-full">
                                        <?php echo e($post->category->name); ?>

                                    </span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <span class="text-xs text-slate-500">
                                        <?php echo e($post->created_at->format('M j, Y')); ?>

                                    </span>
                                </div>

                                <h3 class="text-lg font-bold text-slate-900 mb-2 line-clamp-2 group-hover:text-emerald-600 transition-colors">
                                    <?php echo e($post->title); ?>

                                </h3>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($post->meta_description): ?>
                                <p class="text-sm text-slate-600 line-clamp-2 mb-2">
                                    <?php echo e($post->meta_description); ?>

                                </p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                
                                <div class="flex items-center justify-between">
                                    <span class="text-emerald-600 font-semibold text-sm group-hover:text-emerald-700 transition-colors">
                                        Read Article →
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>

            </div>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


    </div>
</div>
</div>
</div><?php /**PATH C:\Users\Rygss\Downloads\andabwa-2027\resources\views/livewire/pages/blog/feed.blade.php ENDPATH**/ ?>