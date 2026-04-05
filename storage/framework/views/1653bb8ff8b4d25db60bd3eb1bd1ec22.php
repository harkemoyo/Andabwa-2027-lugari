<div class="external-content-page">
    <div class="min-h-screen bg-slate-50">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-20">

            
            <nav class="flex items-center justify-center mb-8">
                <a href="<?php echo e(route('home')); ?>" wire:navigate class="inline-flex   hover:underline items-center text-sm font-medium text-green-600  mb-6 transition-colors px-4 py-2 bg-slate-100 rounded-lg">
                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <?php echo e($this->pageSettings->editorial_button_text ?? 'Back to Blog'); ?>

                </a>
            </nav>

            
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <?php
                    $isYoutube = $post->media_type?->value === 'youtube';
                    $data = $post->link_preview_data ?? [];
                    $embedUrl = $data['embed_url'] ?? null;
                ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isYoutube && $embedUrl): ?>
                    
                    <div class="relative aspect-video w-full bg-black overflow-hidden">
                        <iframe 
                            src="<?php echo e($embedUrl); ?>?rel=0&modestbranding=1&playsinline=1" 
                            class="w-full h-full" 
                            frameborder="0" 
                            allow=" accelerometer; autoplay;  clipboard-write; encrypted-media;
                            gyroscope; "
                            allowfullscreen
                            loading="lazy"
                            title="<?php echo e($post->title); ?>">
                        </iframe>

                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($post->external_url): ?>
                        <a href="<?php echo e($post->external_url); ?>"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="absolute top-4 right-4 z-50 px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded-lg backdrop-blur-sm transition-all duration-300 hover:bg-red-700 shadow-lg pointer-events-auto"
                            style="background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%) !important;">
                            Watch on YouTube
                            <svg class="w-4 h-4 ml-2 inline" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19.615 3.654c-1.318-.72-3.43-.743-8.614-.743-5.185 0-7.298.023-8.616.743C2.047 4.374.96 5.42.96 8.05v7.9c0 2.678 1.113 3.754 2.425 4.396 1.32.72 3.43.743 8.614.743 5.186 0 7.298-.023 8.616-.743 1.312-.642 2.42-1.718 2.42-4.396V8.05c0-2.678-1.113-3.754-2.425-4.396zM8.5 15.5V8.5l7 3.5-7 3.5z"/>
                            </svg>
                        </a>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php else: ?>
                    
                    <div class="relative aspect-video w-full">
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

                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($post->external_url): ?>
                        <a href="<?php echo e($post->external_url); ?>"
                            target="_blank"
                            rel="noopener noreferrer"
                            onclick="window.open(this.href, '_blank'); return false;"
                            class="absolute top-4 right-4 z-50 px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded-lg backdrop-blur-sm transition-all duration-300 hover:bg-red-700 shadow-lg pointer-events-auto visit-source-blink"
                            style="animation: blink-visit-source 2s ease-in-out infinite; background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%) !important;">
                            Visit Source
                            <svg class="w-4 h-4 ml-2 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                        </a>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                
                <div class="p-8 bg-white border-t">
                    <div class="max-w-4xl mx-auto">
                        <h2 class="text-2xl font-bold text-slate-900 mb-4"><?php echo e($post->title); ?></h2>

                        <div class="flex items-center gap-4 mb-6">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($post->category): ?>
                            <span class="text-sm font-semibold text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full">
                                <?php echo e($post->category->name); ?>

                            </span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <span class="text-sm text-slate-500">
                                <?php echo e($post->created_at->format('M j, Y')); ?>

                            </span>
                        </div>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($post->meta_description): ?>
                        <p class="text-slate-600 leading-relaxed mb-6"><?php echo e($post->meta_description); ?></p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($post->external_url): ?>
                        <div class="bg-slate-50 rounded-lg p-4 mb-6">
                            <h3 class="text-sm font-semibold text-slate-700 mb-2">External Source</h3>
                            <a href="<?php echo e($post->external_url); ?>"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="text-emerald-600 hover:text-emerald-700 break-all text-sm">
                                <?php echo e($post->external_url); ?>

                            </a>
                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($relatedPosts && $relatedPosts->isNotEmpty()): ?>
                <div class="bg-white border-t p-8">
                    <div class="max-w-4xl mx-auto">
                        <h3 class="text-xl font-bold text-slate-900 mb-6">Related Articles</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $relatedPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relatedPost): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
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
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>
</div><?php /**PATH C:\Users\Rygss\Downloads\andabwa-2027\resources\views/livewire/pages/blog/external.blade.php ENDPATH**/ ?>