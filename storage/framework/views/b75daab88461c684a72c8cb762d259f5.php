<div class="p-6 space-y-6">

    
    <div class="bg-white p-4 rounded shadow space-y-3">
        <h2 class="font-bold text-lg">
            <?php echo e($editingId ? 'Edit Widget' : 'Create Widget'); ?>

        </h2>

        <input type="text" wire:model="title" placeholder="Title" class="w-full border p-2 rounded">

        <input type="text" wire:model="position" placeholder="Position (left/right)" class="w-full border p-2 rounded">

        <input type="text" wire:model="type" placeholder="Type (ad/newsletter)" class="w-full border p-2 rounded">

        <textarea wire:model="content" placeholder="HTML Content" class="w-full border p-2 rounded h-32"></textarea>

        <input type="text" wire:model="url" placeholder="URL" class="w-full border p-2 rounded">

        <input type="number" wire:model="weight" placeholder="Weight" class="w-full border p-2 rounded">

        <input type="number" wire:model="order" placeholder="Order" class="w-full border p-2 rounded">

        <label class="flex items-center space-x-2">
            <input type="checkbox" wire:model="is_active">
            <span>Active</span>
        </label>

        <button wire:click="update"
            class="bg-black text-white px-4 py-2 rounded">
            Save
        </button>

        <button wire:click="create"
            class="bg-gray-300 px-4 py-2 rounded">
            New
        </button>
    </div>

    
    <div class="bg-white p-4 rounded shadow">
        <h2 class="font-bold mb-4">Widgets</h2>

        <table class="w-full text-sm">
            <thead>
                <tr class="text-left border-b">
                    <th>Title</th>
                    <th>Type</th>
                    <th>Position</th>
                    <th>Active</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $widgets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $widget): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr class="border-b">
                        <td><?php echo e($widget->title); ?></td>
                        <td><?php echo e($widget->type); ?></td>
                        <td><?php echo e($widget->position); ?></td>
                        <td><?php echo e($widget->is_active ? 'Yes' : 'No'); ?></td>
                        <td class="space-x-2">
                            <button wire:click="edit(<?php echo e($widget->id); ?>)" class="text-blue-500">Edit</button>
                            <button wire:click="delete(<?php echo e($widget->id); ?>)" class="text-red-500">Delete</button>
                        </td>
                    </tr>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </tbody>
        </table>
    </div>

</div><?php /**PATH C:\Users\Rygss\Downloads\andabwa-2027\resources\views/livewire/widget-manager.blade.php ENDPATH**/ ?>