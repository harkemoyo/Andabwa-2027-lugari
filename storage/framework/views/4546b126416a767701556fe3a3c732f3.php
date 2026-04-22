<div class="">
    <div class="min-h-screen " style=" rgba(59, 130, 246, .5) !important;">

        <div class="max-w-[1400px] mx-auto px-4 grid grid-cols-12 gap-6">

            
            <div class="hidden lg:block lg:col-span-3 py-6">
                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('left-sidebar', []);

$__keyOuter = $__key ?? null;

$__key = null;
$__componentSlots = [];

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-2762141996-0', $__key);

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

            
            <div class="col-span-12 lg:col-span-6 space-y-6">
                
                <?php if (isset($component)) { $__componentOriginal9293d61b07bbf709922ad4b23b193313 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9293d61b07bbf709922ad4b23b193313 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.blog.latest-post-top','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('blog.latest-post-top'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9293d61b07bbf709922ad4b23b193313)): ?>
<?php $attributes = $__attributesOriginal9293d61b07bbf709922ad4b23b193313; ?>
<?php unset($__attributesOriginal9293d61b07bbf709922ad4b23b193313); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9293d61b07bbf709922ad4b23b193313)): ?>
<?php $component = $__componentOriginal9293d61b07bbf709922ad4b23b193313; ?>
<?php unset($__componentOriginal9293d61b07bbf709922ad4b23b193313); ?>
<?php endif; ?>
            </div>
            
            <div class=" lg:col-span-3 py-6 space-y-6">
                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('sidebar.rotating-widgets', []);

$__keyOuter = $__key ?? null;

$__key = null;
$__componentSlots = [];

$__key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-2762141996-1', $__key);

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
            
            <div class="col-span-12 lg:col-span-10 lg:col-start-2 space-y-6">
                <?php if (isset($component)) { $__componentOriginal25b9b487089b49830677aa135898db04 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal25b9b487089b49830677aa135898db04 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.blog.featured-post','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('blog.featured-post'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal25b9b487089b49830677aa135898db04)): ?>
<?php $attributes = $__attributesOriginal25b9b487089b49830677aa135898db04; ?>
<?php unset($__attributesOriginal25b9b487089b49830677aa135898db04); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal25b9b487089b49830677aa135898db04)): ?>
<?php $component = $__componentOriginal25b9b487089b49830677aa135898db04; ?>
<?php unset($__componentOriginal25b9b487089b49830677aa135898db04); ?>
<?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal85eadd4c8d3bb332750038a6015d9c5d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal85eadd4c8d3bb332750038a6015d9c5d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.blog.latest-post-middle','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('blog.latest-post-middle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal85eadd4c8d3bb332750038a6015d9c5d)): ?>
<?php $attributes = $__attributesOriginal85eadd4c8d3bb332750038a6015d9c5d; ?>
<?php unset($__attributesOriginal85eadd4c8d3bb332750038a6015d9c5d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal85eadd4c8d3bb332750038a6015d9c5d)): ?>
<?php $component = $__componentOriginal85eadd4c8d3bb332750038a6015d9c5d; ?>
<?php unset($__componentOriginal85eadd4c8d3bb332750038a6015d9c5d); ?>
<?php endif; ?>
            </div>
            
            <div class="col-span-12 space-y-6">
                <?php if (isset($component)) { $__componentOriginal1fff98b1f2a60c0db79b5add391610da = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1fff98b1f2a60c0db79b5add391610da = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.blog.latest-post-bottom','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('blog.latest-post-bottom'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1fff98b1f2a60c0db79b5add391610da)): ?>
<?php $attributes = $__attributesOriginal1fff98b1f2a60c0db79b5add391610da; ?>
<?php unset($__attributesOriginal1fff98b1f2a60c0db79b5add391610da); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1fff98b1f2a60c0db79b5add391610da)): ?>
<?php $component = $__componentOriginal1fff98b1f2a60c0db79b5add391610da; ?>
<?php unset($__componentOriginal1fff98b1f2a60c0db79b5add391610da); ?>
<?php endif; ?>
            </div>
            
            <div class="col-span-12 lg:col-span-6 lg:col-start-4">
                <?php if (isset($component)) { $__componentOriginalf0fc67af01ada02eae9d5e213e147786 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf0fc67af01ada02eae9d5e213e147786 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.blog.browse-more-button','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('blog.browse-more-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf0fc67af01ada02eae9d5e213e147786)): ?>
<?php $attributes = $__attributesOriginalf0fc67af01ada02eae9d5e213e147786; ?>
<?php unset($__attributesOriginalf0fc67af01ada02eae9d5e213e147786); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf0fc67af01ada02eae9d5e213e147786)): ?>
<?php $component = $__componentOriginalf0fc67af01ada02eae9d5e213e147786; ?>
<?php unset($__componentOriginalf0fc67af01ada02eae9d5e213e147786); ?>
<?php endif; ?>
            </div>

        </div>

    </div>
</div><?php /**PATH C:\Users\Rygss\Downloads\andabwa-2027\resources\views/livewire/pages/blog/feed.blade.php ENDPATH**/ ?>