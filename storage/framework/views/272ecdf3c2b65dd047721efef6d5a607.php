<?php
    $record = $getRecord();
    $media = $record?->getFirstMedia('featured');
    $mediaType = $record?->media_type?->value ?? 'image';
    $isVideo = str_contains($media?->mime_type ?? '', 'video');
?>

<div class="space-y-4">
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($media): ?>
        <div class="relative group">
            <div class="border-2 border-gray-200 rounded-lg overflow-hidden bg-gray-50">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isVideo): ?>
                    
                    <video 
                        controls 
                        class="w-full max-h-96 object-contain bg-black"
                        preload="metadata">
                        <source src="<?php echo e($media->getUrl()); ?>" type="<?php echo e($media->mime_type); ?>">
                        Your browser does not support the video tag.
                    </video>
                <?php else: ?>
                    
                    <img 
                        src="<?php echo e($media->getUrl()); ?>" 
                        alt="<?php echo e($record->title ?? 'Media preview'); ?>"
                        class="w-full max-h-96 object-contain"
                        loading="lazy">
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            
            
            <div class="absolute top-2 right-2 bg-black/70 text-white px-2 py-1 rounded text-xs">
                <?php echo e($isVideo ? 'Video' : 'Image'); ?>

            </div>
            
            
            <div class="absolute bottom-2 left-2 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($media->getUrl()): ?>
                    <a 
                        href="<?php echo e($media->getUrl()); ?>" 
                        target="_blank"
                        class="bg-blue-600 text-white px-2 py-1 rounded text-xs hover:bg-blue-700 transition-colors">
                        View Full Size
                    </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($media->size): ?>
                    <span class="bg-gray-800 text-white px-2 py-1 rounded text-xs">
                        <?php echo e(number_format($media->size / 1024 / 1024, 2)); ?> MB
                    </span>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
        
        
        <div class="bg-gray-50 p-3 rounded-lg space-y-1">
            <div class="text-sm font-medium text-gray-900">Media Details</div>
            <div class="text-xs text-gray-600 space-y-1">
                <div>File: <?php echo e($media->file_name); ?></div>
                <div>Type: <?php echo e($media->mime_type); ?></div>
                <div>Size: <?php echo e(number_format($media->size / 1024 / 1024, 2)); ?> MB</div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($media->created_at): ?>
                    <div>Uploaded: <?php echo e($media->created_at->format('M j, Y g:i A')); ?></div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    <?php else: ?>
        
        <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <div class="mt-2 text-sm text-gray-600">No media uploaded yet</div>
            <div class="text-xs text-gray-500">Upload media using the field above</div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH C:\Users\Rygss\Downloads\andabwa-2027\resources\views/filament/components/media-preview.blade.php ENDPATH**/ ?>