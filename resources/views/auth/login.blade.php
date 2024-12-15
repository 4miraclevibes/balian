<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            
            <div class="relative">
                <x-text-input id="password" class="block mt-1 w-full pr-10"
                    type="password"
                    name="password"
                    required autocomplete="current-password" 
                    style="background: #1a1d21; border: 1px solid #2d3339; color: white;" />
                <button type="button" 
                    class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-300" 
                    onclick="togglePassword('password')">
                    <i id="password-icon" class="fa-regular fa-eye"></i>
                </button>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ms-2 text-sm text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-6">
            @if (Route::has('register'))
                <x-secondary-button onclick="window.location.href='{{ route('register') }}'">
                    {{ __('REGISTER') }}
                </x-secondary-button>
            @endif

            <x-primary-button>
                {{ __('LOG IN') }}
            </x-primary-button>
        </div>

        @if (Route::has('password.request'))
            <div class="text-center mt-4">
                <a class="text-sm text-gray-400 hover:text-gray-300" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            </div>
        @endif
    </form>

    <script>
        function togglePassword(inputId) {
            const passwordInput = document.getElementById(inputId);
            const icon = document.getElementById(inputId + '-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</x-guest-layout>