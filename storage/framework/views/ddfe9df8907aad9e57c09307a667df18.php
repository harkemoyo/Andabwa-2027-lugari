<footer data-aos="fade-up" data-aos-duration="1000"
    class=" bg-gray-800  dark:bg-gray-900 text-white dark:text-gray-100 border-t border-gray-200 dark:border-gray-700 shadow-sm shadow-emerald-100/50 dark:shadow-emerald-900/20">

    
    <div class="max-w-[1400px] xl:max-w-[1500px] mx-auto pb-8 px-6 sm:px-10 lg:px-10 py-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10 md:gap-20">
        
        <div class="space-y-2 justify-start text-left ">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($footerInfo): ?>
            <div class="flex -mt-6 justify-center md:justify-self-start">
                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('navigation-logo-header-component', []);

$__keyOuter = $__key ?? null;

$__key = null;
$__componentSlots = [];

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-1219915795-0', $__key);

$__html = app('livewire')->mount($__name, $__params, $__key, $__componentSlots);

echo $__html;

unset($__html);
unset($__key);
$__key = $__keyOuter;
unset($__keyOuter);
unset($__name);
unset($__params);
unset($__componentSlots);
unset($__split);
?>
            </div>

            <p class="leading-relaxed font-extrabold  text-xl">
                <?php echo e($footerInfo->description); ?>

            </p>

            <div class="space-y-2  text-sm">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($footerInfo->address): ?>
                <p class="italic">
                    <span class="font-extrabold text-xl ">Address:</span>
                    <?php echo e($footerInfo->address); ?>

                </p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($footerInfo->phone): ?>
                <p class="italic">
                    <span class="font-extrabold text-xl">Phone:</span>
                    <?php echo e($footerInfo->phone); ?>

                </p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($footerInfo->email): ?>
                <p class="italic">
                    <span class="font-extrabold text-xl">Email:</span>
                    <?php echo e($footerInfo->email); ?>

                </p>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <?php else: ?>
            <p class="text-gray-500 dark:text-gray-400">Footer info not available.</p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        
        <div
            class="bg-black justfy-center md:-mr-8 text-white rounded-2xl p-4 flex flex-col items-center text-center shadow-inner shadow-emerald-900/30 hover:shadow-emerald-600/40 transition-all duration-300">

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($footerCta): ?>
            <h3 class="text-2xl font-bold py-2 tracking-tight">
                <?php echo e($footerCta->title); ?>

            </h3>

            <p class="mb-6  max-w-sm leading-relaxed">
                <?php echo e($footerCta->subtitle); ?>

            </p>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($footerCta->button_text && $footerCta->button_link): ?>
            <button @click="$dispatch('register-modal')"
                class="bg-white dark:bg-gray-900 text-black dark:text-white px-7 py-3 rounded-lg font-medium
                              hover:shadow-green-50 shadow-lg transition-all duration-300
                              focus:outline-none focus:ring-2 focus:ring-emerald-100">
                <?php echo e($footerCta->button_text); ?>

            </button>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php else: ?>
            <p class="text-gray-400 dark:text-gray-200">CTA not configured.</p>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        
        <div class="space-y-2 justify-end text-left md:text-center sm:text-left ">
            <div class="text-center items-center justify-center ml-4 sm:ml-10 md:ml-16">
                <h2 class="text-xl font-extrabold  tracking-tight ">Follow Us:</h2>
            </div>

            <div class="flex flex-wrap justify-center sm:justify-start md:justify-end gap-4">
                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('social-links-component', []);

$__keyOuter = $__key ?? null;

$__key = null;
$__componentSlots = [];

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-1219915795-1', $__key);

$__html = app('livewire')->mount($__name, $__params, $__key, $__componentSlots);

echo $__html;

unset($__html);
unset($__key);
$__key = $__keyOuter;
unset($__keyOuter);
unset($__name);
unset($__params);
unset($__componentSlots);
unset($__split);
?>
            </div>
        </div>
    </div>

    
    <div class=" text-center py-2  text-sm text-gray-600 dark:text-gray-400 -mt-8 pb-2">
        <p>&copy; <?php echo e(date('Y')); ?> <?php echo e($footerInfo->company_name ?? 'Your Company'); ?> — All rights reserved.</p>
    </div>
</footer><?php /**PATH C:\Users\Rygss\Downloads\andabwa-2027\resources\views/livewire/footer-section.blade.php ENDPATH**/ ?>