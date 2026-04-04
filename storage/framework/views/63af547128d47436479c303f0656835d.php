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

<?php
    // Initialize variables with proper error handling
    $isExternal = \App\Enums\MediaType::isExternal($post->media_type);
    $data = $post->link_preview_data ?? [];
    $type = $data['type'] ?? $post->media_type?->value;
    
    // Get featured media with fallback
    $featuredMedia = $post->getFirstMedia('featured');
    $featuredMediaUrl = null;
    $featuredMediaIsVideo = false;
    
    if ($featuredMedia) {
        // getUrl() returns the full URL already (e.g., http://127.0.0.1:8001/storage/1/filename.jpg)
        $featuredMediaUrl = $featuredMedia->getUrl();
        $featuredMediaIsVideo = str_contains($featuredMedia->mime_type ?? '', 'video');
    }
?>

<div class="relative w-full h-full overflow-hidden group">
    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($featuredMediaUrl && !$isExternal): ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($featuredMediaIsVideo): ?>
            
            <video 
                controls 
                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                preload="metadata"
                poster="<?php echo e($featuredMedia && $featuredMedia->hasGeneratedConversion('preview') ? $featuredMedia->getUrl('preview') : ''); ?>">
                <source src="<?php echo e($featuredMediaUrl); ?>" type="<?php echo e($featuredMedia->mime_type); ?>">
                Your browser does not support the video tag.
            </video>
            
            
            <div class="absolute top-3 left-3 bg-black/70 text-white px-3 py-1.5 rounded-md text-sm font-medium">
                <svg class="w-4 h-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Video
            </div>
        <?php else: ?>
            
            <img 
                src="<?php echo e($featuredMediaUrl); ?>" 
                alt="<?php echo e($post->title); ?>" 
                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105 pointer-events-none"
                loading="lazy">
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        
        <a href="<?php echo e(route('blog.external', $post->slug)); ?>"
           class="absolute top-3 right-3 z-30 px-3 py-1.5 text-xs font-semibold text-white rounded-md backdrop-blur-sm transition-all duration-300 shadow-lg pointer-events-auto visit-source-blink">
            View Details
            <svg class="w-3 h-3 ml-1 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
            </svg>
        </a>

    
    <?php elseif($isExternal && (!empty($data['embed_url']) || ($type === 'youtube' && !empty($post->external_url)))): ?>
        <?php
        // If we have an embed_url in data, use it; otherwise generate one for YouTube
        $embedUrl = $data['embed_url'] ?? null;
        
        if (!$embedUrl && $type === 'youtube' && !empty($post->external_url)) {
            preg_match('/(youtu\.be\/|youtube\.com.*v=|youtube\.com\/shorts\/)([^&\n?#]+)/', $post->external_url, $matches);
            $youtubeId = $matches[2] ?? null;
            $embedUrl = $youtubeId ? "https://www.youtube.com/embed/{$youtubeId}" : null;
        }
        ?>
        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($embedUrl): ?>
        
        <iframe 
            src="<?php echo e($embedUrl); ?>" 
            class="w-full h-full border-0 relative z-20" 
            allowfullscreen 
            loading="lazy"
            title="<?php echo e($post->title); ?>">
        </iframe>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        
        
        <a href="<?php echo e(route('blog.external', $post->slug)); ?>"
           class="absolute top-3 right-3 z-30 px-3 py-1.5 text-xs font-semibold text-white rounded-md backdrop-blur-sm transition-all duration-300 shadow-lg pointer-events-auto visit-source-blink">
            View Details
            <svg class="w-3 h-3 ml-1 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
            </svg>
        </a>

    
    <?php elseif($isExternal && ($type === 'article' || $type === 'external_link')): ?>
        
        <div class="w-full h-full bg-gradient-to-br from-emerald-50 to-slate-100 flex items-center justify-center p-8">
            <div class="text-center max-w-2xl">
                <div class="w-16 h-16 bg-white rounded-lg flex items-center justify-center mb-6 mx-auto shadow-md">
                    <svg class="w-8 h-8 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 005.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 5.656l-1.1 1.1" />
                    </svg>
                </div>
                
                <h1 class="text-2xl font-bold text-slate-900 mb-4 line-clamp-3"><?php echo e($post->title); ?></h1>
                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($data['description'])): ?>
                    <p class="text-sm text-slate-600 mb-6 leading-relaxed line-clamp-3"><?php echo e($data['description']); ?></p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                
                <p class="text-xs text-slate-500">External Article • Click "View Details" to read more</p>
            </div>
        </div>
        
        
        <a href="<?php echo e(route('blog.external', $post->slug)); ?>"
           class="absolute top-3 right-3 z-30 px-3 py-1.5 text-xs font-semibold text-white rounded-md backdrop-blur-sm transition-all duration-300 shadow-lg pointer-events-auto visit-source-blink">
            View Details
            <svg class="w-3 h-3 ml-1 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
            </svg>
        </a>

    
    <?php else: ?>
        <?php
        $imageUrl = $post->getFirstMediaUrl('featured') ?: $post->getFirstMediaUrl();
        // Fallback to link preview image if no local media
        if (!$imageUrl && !empty($data['image'])) {
            $imageUrl = $data['image'];
        }
        ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($imageUrl): ?>
        <img 
            src="<?php echo e($imageUrl); ?>" 
            alt="<?php echo e($post->title); ?>" 
            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
        <?php else: ?>
        <div class="flex items-center justify-center h-full bg-gradient-to-br from-gray-50 to-gray-100 text-gray-400 text-sm font-medium">
            <svg class="w-8 h-8 mb-1 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 005.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 5.656l-1.1 1.1" />
            </svg>
            <p>No Media Available</p>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH C:\Users\Rygss\Downloads\andabwa-2027\resources\views/components/blog/media.blade.php ENDPATH**/ ?>