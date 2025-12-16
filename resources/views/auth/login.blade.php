<x-guest-layout>
    <h2 class="text-center mb-4 fw-bold">
        <i class="bi bi-box-arrow-in-right me-2"></i>{{ __('Log in') }}
    </h2>
    <p class="text-center text-muted mb-4">Влезте в своя акаунт, за да продължите</p>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-3">
            <x-input-label for="email">{{ __('Email') }}</x-input-label>
            <x-text-input id="email" 
                          type="email" 
                          name="email" 
                          class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" 
                          value="{{ old('email') }}" 
                          required 
                          autofocus 
                          autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password -->
        <div class="mb-3">
            <x-input-label for="password">{{ __('Password') }}</x-input-label>
            <x-text-input id="password"
                          type="password"
                          name="password"
                          class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                          required 
                          autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                <label class="form-check-label" for="remember_me">
                    {{ __('Remember me') }}
                </label>
            </div>

            @if (Route::has('password.request'))
                <a class="text-decoration-none" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <div class="d-grid mb-3">
            <x-primary-button>
                <i class="bi bi-box-arrow-in-right me-1"></i>{{ __('Log in') }}
            </x-primary-button>
        </div>

        <div class="text-center">
            <a class="text-decoration-none" href="{{ route('register') }}">
                <i class="bi bi-person-plus me-1"></i>Нямаш акаунт? Регистрирай се
            </a>
        </div>
    </form>
</x-guest-layout>
