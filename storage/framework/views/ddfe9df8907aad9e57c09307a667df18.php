<footer data-aos="fade-up" data-aos-duration="1000"
    class="relative bg-slate-950 text-slate-200 border-t border-white/5 overflow-hidden">
    
    
    <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/4 w-96 h-96 bg-purple-600/10 blur-[120px] rounded-full"></div>
    <div class="absolute bottom-0 left-0 translate-y-1/4 -translate-x-1/4 w-96 h-96 bg-red-600/10 blur-[120px] rounded-full"></div>

    <div class="relative max-w-[1400px] mx-auto px-6 sm:px-10 lg:px-10 py-16">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-start">
            
            
            <div class="lg:col-span-4 space-y-6">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($footerInfo): ?>
                    <div class="flex flex-col items-start gap-4">
                        <div class="scale-110 origin-left">
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
                        <p class="text-slate-400 leading-relaxed text-sm lg:text-base max-w-sm">
                            <?php echo e($footerInfo->description); ?>

                        </p>
                    </div>

                    <div class="space-y-4 pt-4 border-t border-white/5">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($footerInfo->address): ?>
                        <div class="group flex items-start gap-3">
                            <span class="text-purple-400 font-bold text-sm uppercase tracking-wider">Office</span>
                            <a href="#" class="text-slate-300 hover:text-white transition-colors text-sm leading-tight italic">
                                <?php echo e($footerInfo->address); ?>

                            </a>
                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <div class="flex flex-wrap gap-x-8 gap-y-4">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($footerInfo->phone): ?>
                            <a href="tel:<?php echo e($footerInfo->phone); ?>" class="group flex flex-col gap-1">
                                <span class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 group-hover:text-pink-500 transition-colors">Phone Support</span>
                                <span class="text-sm font-semibold text-slate-200 group-hover:text-white"><?php echo e($footerInfo->phone); ?></span>
                            </a>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($footerInfo->email): ?>
                            <a href="mailto:<?php echo e($footerInfo->email); ?>" class="group flex flex-col gap-1">
                                <span class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-500 group-hover:text-red-500 transition-colors">Email Us</span>
                                <span class="text-sm font-semibold text-slate-200 group-hover:text-white"><?php echo e($footerInfo->email); ?></span>
                            </a>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            
            <div class="lg:col-span-5">
                <div class="relative group overflow-hidden bg-gradient-to-br from-slate-900 to-slate-950 border border-white/10 rounded-3xl p-8 shadow-2xl transition-all duration-500 hover:border-purple-500/30">
                    
                    <div class="absolute -right-10 -top-10 w-32 h-32 bg-purple-500/10 blur-3xl rounded-full group-hover:bg-purple-500/20 transition-all"></div>
                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($footerCta): ?>
                        <div class="relative z-10 flex flex-col items-center text-center">
                            <h3 class="text-2xl font-black text-white mb-3 tracking-tight italic">
                                <?php echo e($footerCta->title); ?>

                            </h3>
                            <p class="text-slate-400 text-sm mb-8 leading-relaxed max-w-xs">
                                <?php echo e($footerCta->subtitle); ?>

                            </p>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($footerCta->button_text && $footerCta->button_link): ?>
                            <button @click="$dispatch('register-modal')"
                                class="relative w-full sm:w-auto px-10 py-4 bg-white text-slate-950 rounded-xl font-black text-xs uppercase tracking-widest
                                              hover:bg-gradient-to-r hover:from-purple-500 hover:to-red-500 hover:text-white
                                              transform hover:-translate-y-1 transition-all duration-300 shadow-[0_10px_40px_-10px_rgba(255,255,255,0.2)]">
                                <?php echo e($footerCta->button_text); ?>

                            </button>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            
            <div class="lg:col-span-3 flex flex-col items-start lg:items-end justify-between h-full py-4">
                <div class="space-y-4 w-full lg:text-right">
                    <h2 class="text-xs font-black uppercase tracking-[0.3em] text-slate-500">Connect with us</h2>
                    <div class="flex lg:justify-end">
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
                
                <div class="hidden lg:block pt-10">
                    <p class="text-[10px] text-slate-600 uppercase tracking-widest font-medium">
                        Standard of Excellence &copy; <?php echo e(date('Y')); ?>

                    </p>
                </div>
            </div>
        </div>

        
        <div class="mt-16 pt-8 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-[11px] font-bold text-slate-500 uppercase tracking-widest">
                <?php echo e($footerInfo->company_name ?? 'Your Company'); ?> — All rights reserved.
            </p>
            <div class="flex gap-6 text-[11px] font-bold text-slate-500 uppercase tracking-widest">
                <a href="#" class="hover:text-white transition-colors">Privacy</a>
                <a href="#" class="hover:text-white transition-colors">Terms</a>
            </div>
        </div>
    </div>
</footer><?php /**PATH C:\Users\Rygss\Downloads\andabwa-2027\resources\views/livewire/footer-section.blade.php ENDPATH**/ ?>