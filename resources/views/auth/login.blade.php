<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}" name="form" onsubmit="return validate(this)">
            @csrf

            <x-input name="textid" type="hidden" />
            <x-input name="typingPattern" type="hidden" />
            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="current-password" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <input id="remember_me" type="checkbox" class="form-checkbox" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
                @endif

                <x-button class="ml-3">
                    {{ __('Login') }}
                </x-button>
            </div>
        </form>

    </x-auth-card>
    <x-slot name="script_h">
        <script src="https://typingdna.com/scripts/typingdna.js"></script>
    </x-slot>

    <x-slot name="script">
        <script>
            const tdna = new TypingDNA();
            tdna.addTarget('email');
            tdna.addTarget('password');
            document.getElementById('email').focus();

            function validate(form) {
                const user = form.email.value.toString().trim();
                const pass = form.password.value.toString().trim();
                const currentQuote = user + pass;
                form.textid.value = TypingDNA.getTextId(currentQuote);
                form.typingPattern.value = tdna.getTypingPattern({
                    type: 1,
                    text: currentQuote
                });
                return true;
                // return false
            }
        </script>
    </x-slot>
</x-guest-layout>