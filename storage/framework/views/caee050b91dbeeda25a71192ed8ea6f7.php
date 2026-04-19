<div class="bg-white min-h-screen antialiased"
    x-data="{ 
        percent: 0, 
        copied: false, 
        copyToClipboard() {
            navigator.clipboard.writeText(window.location.href);
            this.copied = true;
            setTimeout(() => this.copied = false, 2000);
        }
     }"
    x-on:scroll.window="percent = (window.pageYOffset / (document.documentElement.scrollHeight - window.innerHeight)) * 100">

    
    <div class="fixed top-0 left-0 w-full h-[2px] z-[60] pointer-events-none">
        <div class="h-full bg-indigo-600 transition-all duration-150 ease-out will-change-[width]" 
             :style="'width: ' + percent + '%'"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10  pt-10 pb-16">

        
        <div class="mb-6 flex items-center">
            <a href="<?php echo e(route('home')); ?>" wire:navigate
                class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-slate-100 hover:bg-slate-200 text-xs font-semibold tracking-wide uppercase text-slate-800 shadow-sm transition-all duration-200">

                <svg class="w-4 h-4 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>

                <?php echo e($this->pageSettings->editorial_button_text ?? 'Back to Editorial'); ?>

            </a>
        </div>

        
        <article class="max-w-3xl mx-auto">

            
            <header class="mb-8 text-center space-y-4">

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($post->is_featured): ?>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-bold bg-amber-100 text-amber-800 uppercase tracking-widest">
                    <?php echo e($this->pageSettings->featured_insight_text ?? 'Featured Insight'); ?>

                </span>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <h1 class="text-2xl sm:text-3xl md:text-5xl font-extrabold text-gray-900 leading-tight tracking-tight">
                    <?php echo e($post->title); ?>

                </h1>

            </header>

            
            <div class="rounded-2xl overflow-hidden shadow-sm ring-1 ring-gray-100 mb-8 aspect-video">
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

            
            <div class="prose prose-base sm:prose-lg prose-indigo max-w-none text-gray-700 leading-relaxed mb-14">
                <?php echo $post->content; ?>

            </div>

            
            <div class="pt-6 border-t border-gray-200">
                <div class="flex flex-wrap items-center gap-3 sm:gap-4">

                    <span class="text-sm font-semibold text-gray-700">Share</span>

                    
                    <a href="https://twitter.com/intent/tweet?url=<?php echo e(urlencode(url()->current())); ?>&text=<?php echo e(urlencode($post->title)); ?>"
                        target="_blank"
                        class="p-3 rounded-full bg-gray-50 text-gray-600 hover:bg-blue-50 hover:text-black transition-all duration-200 border border-transparent hover:border-blue-100">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M18.901 1.153h3.68l-8.04 9.19L24 22.846h-7.406l-5.8-7.584-6.638 7.584H.474l8.6-9.83L0 1.154h7.594l5.243 6.932ZM17.61 20.644h2.039L6.486 3.24H4.298Z" />
                        </svg>
                    </a>

                    
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo e(urlencode(url()->current())); ?>"
                        target="_blank"
                        class="p-3 rounded-full bg-gray-50 text-gray-600 hover:bg-blue-50 hover:text-blue-700 transition-all duration-200 border border-transparent hover:border-blue-100">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452z"/>
                        </svg>
                    </a>

                    
                    <div class="relative">
                        <button @click="copyToClipboard"
                            class="p-3 rounded-full bg-gray-50 text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition-all duration-200 border border-transparent hover:border-indigo-100">
                            
                            <svg x-show="!copied" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2"/>
                            </svg>

                            <svg x-show="copied" class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-cloak>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </button>

                        <span x-show="copied"
                            x-transition
                            class="absolute -bottom-9 left-1/2 -translate-x-1/2 bg-gray-900 text-white text-[10px] px-2 py-1 rounded shadow">
                            Copied!
                        </span>
                    </div>

                </div>
            </div>

        </article>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->relatedPosts->count() > 0): ?>
    <section class="bg-gray-50 border-t border-gray-100 py-8 sm:py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3 mb-4">
                <div>
                    <h3 class="text-2xl sm:text-3xl font-bold text-gray-900">Related Articles</h3>
                    <div class="h-1 w-16 bg-indigo-600 mt-2 rounded-full"></div>
                </div>

                <a href="<?php echo e(route('home')); ?>"
                    class="text-sm font-semibold text-green-600 hover:underline flex items-center gap-2">
                    View All
                    →
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2 lg:gap-4">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $this->relatedPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relatedPost): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginal6a0bd6cb4c22c12505d523f802edfba3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6a0bd6cb4c22c12505d523f802edfba3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.blog.card','data' => ['post' => $relatedPost]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('blog.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['post' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($relatedPost)]); ?>
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
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>

        </div>
    </section>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

</div><?php /**PATH C:\Users\Rygss\Downloads\andabwa-2027\resources\views/livewire/pages/blog/show.blade.php ENDPATH**/ ?>