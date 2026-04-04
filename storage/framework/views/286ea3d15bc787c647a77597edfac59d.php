<div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(config('services.google.analytics_id')): ?>
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo e(config('services.google.analytics_id')); ?>"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            // 1. Initial configuration
            gtag('config', '<?php echo e(config('services.google.analytics_id')); ?>');

            // 2. Listen for Livewire's navigation event
            document.addEventListener('livewire:navigated', () => {
                gtag('config', '<?php echo e(config('services.google.analytics_id')); ?>', {
                    'page_path': window.location.pathname,
                    'page_location': window.location.href,
                    'page_title': document.title
                });
            });
        </script>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH C:\Users\Rygss\Downloads\andabwa-2027\resources\views/components/google-analytics.blade.php ENDPATH**/ ?>