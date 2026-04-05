<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    
    <title>
        <?php echo e($title ?? config('app.name', 'Dr. Isaac GM Andabwa OGW | Lugari Constituency Empowerment, Scholarships & Community Support')); ?>

    </title>
    <meta name="description"
        content="<?php echo e($description ?? 'The Andabwa Foundation, founded by Dr. Isaac GM Andabwa OGW, is a Kenyan NGO focused on Lugari Constituency empowerment, scholarships, housing projects, Walinzi Sacco development, and community socio-economic transformation.'); ?>">
    <meta name="keywords"
        content="<?php echo e($keywords ?? 'Dr Isaac GM Andabwa OGW, Andabwa Foundation, Lugari Constituency empowerment, Waliniz Sacco, KNPSWU, Scholarships Kenya, NGO in Kakamega, Community empowerment Kenya, Security sector reforms Kenya'); ?>">
    <meta name="author" content="<?php echo e($author ?? config('app.name')); ?>">
    <meta name="robots" content="index, follow">

    
    <link rel="canonical" href="<?php echo e(url()->current()); ?>">

    
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?php echo e($title ?? config('app.name')); ?>">
    <meta property="og:description"
        content="<?php echo e($description ?? 'The Andabwa Foundation is focused on Lugari Constituency empowerment and socio-economic transformation.'); ?>">
    <meta property="og:url" content="<?php echo e(url()->current()); ?>">
    <meta property="og:image" content="<?php echo e($image ?? asset('images/default-og.jpg')); ?>">
    <meta property="og:site_name" content="<?php echo e(config('app.name')); ?>">

    
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo e($title ?? config('app.name')); ?>">
    <meta name="twitter:description"
        content="<?php echo e($description ?? 'The Andabwa Foundation is focused on Lugari Constituency empowerment and socio-economic transformation.'); ?>">
    <meta name="twitter:image" content="<?php echo e($image ?? asset('images/default-og.jpg')); ?>">

    
    <link rel="icon" sizes="48x48" href="<?php echo e(asset('favicon.ico')); ?>" type="image/x-icon">
    <link rel="icon" sizes="48x48" type="image/svg+xml" href="<?php echo e(asset('favicon.svg')); ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="48x48" href="/favicon-48x48.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">


    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Blog",
            "name": "<?php echo e(config('app.name')); ?>",
            "url": "<?php echo e(url('/')); ?>",
            "description": "<?php echo e($description ?? 'The Andabwa Foundation focuses on community socio-economic transformation.'); ?>"
        }
    </script>

    <?php if (isset($component)) { $__componentOriginal5a71c2c3670795ec464153e22b9d2874 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5a71c2c3670795ec464153e22b9d2874 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.google-analytics','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('google-analytics'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5a71c2c3670795ec464153e22b9d2874)): ?>
<?php $attributes = $__attributesOriginal5a71c2c3670795ec464153e22b9d2874; ?>
<?php unset($__attributesOriginal5a71c2c3670795ec464153e22b9d2874); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5a71c2c3670795ec464153e22b9d2874)): ?>
<?php $component = $__componentOriginal5a71c2c3670795ec464153e22b9d2874; ?>
<?php unset($__componentOriginal5a71c2c3670795ec464153e22b9d2874); ?>
<?php endif; ?>

    
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    
    <style>
        @keyframes blink-visit-source {
            0%, 100% {
                opacity: 1;
                transform: scale(1);
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            }
            50% {
                opacity: 0.8;
                transform: scale(1.05);
                box-shadow: 0 10px 15px -3px rgba(220, 38, 38, 0.3), 0 4px 6px -2px rgba(220, 38, 38, 0.2);
            }
        }

        .visit-source-blink {
            animation: blink-visit-source 2s ease-in-out infinite;
            background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%) !important;
        }

        .visit-source-blink:hover {
            animation: none;
            background: linear-gradient(135deg, #b91c1c 0%, #dc2626 100%) !important;
            transform: scale(1.1) !important;
        }

        /* YouTube Video Modal Styles */
        dialog[id^="youtube-modal-"] {
            backdrop-filter: blur(4px);
        }

        dialog[id^="youtube-modal-"]::backdrop {
            background-color: rgba(0, 0, 0, 0.9);
        }

        dialog[id^="youtube-modal-"] {
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @media (max-width: 768px) {
            dialog[id^="youtube-modal-"] {
                width: 100% !important;
                height: 100% !important;
                margin: 0 !important;
                border-radius: 0 !important;
            }
        }
    </style>

    
    <?php echo $__env->yieldContent('meta'); ?>
</head>

<body class="antialiased bg-white text-gray-900">

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($slot)): ?>
        <?php echo e($slot); ?>

    <?php else: ?>
        <?php echo $__env->yieldContent('content'); ?>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>


    <script>
        function latestSlider(totalSlides) {
            return {
                current: 0,
                total: totalSlides,
                interval: null,

                init() {
                    this.start()
                },

                start() {
                    this.interval = setInterval(() => {
                        this.next()
                    }, 8000)
                },

                stop() {
                    clearInterval(this.interval)
                },

                next() {
                    this.current = (this.current + 1) % this.total
                },

                go(index) {
                    this.current = index
                    this.stop()
                    this.start()
                }
            }
        }
    </script>


    <script>
        document.addEventListener('livewire:initialized', () => {
            let pendingScroll = false;

            Livewire.hook('request', ({
                options
            }) => {
                if (!options?.payload?.updates) return;

                const isPaginationUpdate = options.payload.updates.some((u) => {
                    return u.type === 'callMethod' && ['gotoPage', 'nextPage', 'previousPage']
                        .includes(u.payload?.method);
                });

                if (isPaginationUpdate) {
                    pendingScroll = true;
                }
            });

            Livewire.hook('morph.updated', () => {
                if (!pendingScroll) return;
                pendingScroll = false;

                const el = document.getElementById('posts-section');
                if (!el) return;

                el.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            });
        });
    </script>



</body>

</html>
<?php /**PATH C:\Users\Rygss\Downloads\andabwa-2027\resources\views/components/layouts/app.blade.php ENDPATH**/ ?>