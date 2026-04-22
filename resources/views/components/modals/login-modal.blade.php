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

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email address</label>
                    <input name="email" type="email" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" value="{{ old('email') }}">
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



            {{-- @include('partials.social-auth-buttons')--}}

            <div class="mt-6">
                @include('partials.social-auth-buttons', ['showDemo' => true])
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

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf
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










                    <form method="POST" action="{{ route('register') }}" class="space-y-4">
                        @csrf
                        <div>
                            <label for="modal-register-name" class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input id="modal-register-name" name="name" type="text" autocomplete="name" required
                                class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                placeholder="John Doe" value="{{ old('name') }}">
                            @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="modal-register-email" class="block text-sm font-medium text-gray-700">Email address</label>
                            <input id="modal-register-email" name="email" type="email" autocomplete="email" required
                                class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                placeholder="you@example.com" value="{{ old('email') }}">
                            @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="modal-register-password" class="block text-sm font-medium text-gray-700">Password</label>
                            <input id="modal-register-password" name="password" type="password" autocomplete="new-password" required
                                class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                placeholder="Create a strong password">
                            @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="modal-register-password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                            <input id="modal-register-password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required
                                class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                placeholder="Confirm your password">
                            @error('password_confirmation')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        @if ($errors->any())
                        <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded">
                            @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                            @endforeach
                        </div>
                        @endif

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
                                @include('partials.social-auth-buttons', ['showDemo' => false])
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
</div>