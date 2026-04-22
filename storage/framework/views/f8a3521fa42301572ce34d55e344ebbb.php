<div x-data="{ 
        activeModal: null,
        close() { 
            this.activeModal = null;
            document.body.style.overflow = 'auto';
        },
        open(type) {
            this.activeModal = type;
            document.body.style.overflow = 'hidden';
        }
    }"
    @login-modal.window="open('login')"
    @register-modal.window="open('register')"
    @close-auth-modal.window="close()"
    @keydown.escape.window="close()"
    x-show="activeModal"
    class="fixed inset-0 z-[10000] overflow-y-auto"
    x-cloak>

    <div x-show="activeModal"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="close()"
        class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm">
    </div>

    <div class="flex min-h-full items-center justify-center p-4">

        <div x-show="activeModal === 'login'"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="relative bg-gray-100 rounded-2xl shadow-xl max-w-md w-full p-6"
            @click.stop>

            <button @click="close()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div class="text-center">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Sign in to your account</h2>
                <p class="text-sm text-gray-600 mb-6">
                    Or <button @click="activeModal = 'register'" class="font-medium text-indigo-600 hover:text-indigo-500">create a new account</button>
                </p>
            </div>

            <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-4">
                <?php echo csrf_field(); ?>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email address</label>
                    <input name="email" type="email" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="<?php echo e(old('email')); ?>">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Password</label>
                    <input name="password" type="password" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center text-sm text-gray-900">
                        <input name="remember" type="checkbox" class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
                        <span class="ml-2">Remember me</span>
                    </label>
                    <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Forgot password?</a>
                </div>

                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 transition">
                    Sign in
                </button>
            </form>



            

            <div class="mt-6">
                <?php echo $__env->make('partials.social-auth-buttons', ['showDemo' => true], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>


        </div>

        <div x-show="activeModal === 'register'"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="relative bg-gray-100 rounded-2xl shadow-xl max-w-md w-full p-6"
            @click.stop>

            <button @click="close()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div class="text-center">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Create your account</h2>
                <p class="text-sm text-gray-600 mb-6">
                    Or <button @click="activeModal = 'login'" class="font-medium text-indigo-600 hover:text-indigo-500">sign in to existing account</button>
                </p>
            </div>

            <form method="POST" action="<?php echo e(route('register')); ?>" class="space-y-4">
                <?php echo csrf_field(); ?>
                <div>





                    <!-- Modal Content 
            <div class="text-center">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">
                    Create your account
                </h2>
                <p class="text-sm text-gray-600 mb-6">
                    Or 
                    <button @click="$dispatch('login-modal')" 
                            class="font-medium text-indigo-600 hover:text-indigo-500">
                        sign in to your existing account
                    </button>
                </p>
            </div>-->










                    <form method="POST" action="<?php echo e(route('register')); ?>" class="space-y-4">
                        <?php echo csrf_field(); ?>
                        <div>
                            <label for="modal-register-name" class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input id="modal-register-name" name="name" type="text" autocomplete="name" required
                                class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                placeholder="John Doe" value="<?php echo e(old('name')); ?>">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <div>
                            <label for="modal-register-email" class="block text-sm font-medium text-gray-700">Email address</label>
                            <input id="modal-register-email" name="email" type="email" autocomplete="email" required
                                class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                placeholder="you@example.com" value="<?php echo e(old('email')); ?>">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <div>
                            <label for="modal-register-password" class="block text-sm font-medium text-gray-700">Password</label>
                            <input id="modal-register-password" name="password" type="password" autocomplete="new-password" required
                                class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                placeholder="Create a strong password">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <div>
                            <label for="modal-register-password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                            <input id="modal-register-password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required
                                class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                placeholder="Confirm your password">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
                        <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <p><?php echo e($error); ?></p>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <div>
                            <button type="submit"
                                class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                    <svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 0v1h4v-1a6 6 0 00-12 0v1h4z" />
                                    </svg>
                                </span>
                                Create Account
                            </button>
                        </div>

                        <!-- Google OAuth Button -->
                        <div class="mt-6">
                            <div class="relative">
                                <div class="absolute inset-0 flex items-center">
                                    <div class="w-full border-t border-gray-300" />
                                </div>
                            </div>


                            <div class="mt-6">
                                <?php echo $__env->make('partials.social-auth-buttons', ['showDemo' => false], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                            </div>

                        </div>

                        <!-- Terms and Privacy -->
                        <div class="text-center">
                            <p class="text-xs text-gray-500">
                                By creating an account, you agree to our Terms of Service and Privacy Policy
                            </p>
                        </div>
                    </form>

                </div>







            </form>
        </div>

    </div>
</div><?php /**PATH C:\Users\Rygss\Downloads\andabwa-2027\resources\views/components/modals/login-modal.blade.php ENDPATH**/ ?>