<x-guest-layout>
    <h2 class="text-center mb-4 fw-bold">
        <i class="bi bi-person-plus me-2"></i>{{ __('Register') }}
    </h2>
    <p class="text-center text-muted mb-4">Създайте своя акаунт, за да започнете да споделяте</p>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mb-3">
            <x-input-label for="name">{{ __('Name') }}</x-input-label>
            <x-text-input id="name" 
                          type="text" 
                          name="name" 
                          class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" 
                          value="{{ old('name') }}" 
                          required 
                          autofocus 
                          autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <!-- Email Address -->
        <div class="mb-3">
            <x-input-label for="email">{{ __('Email') }}</x-input-label>
            <x-text-input id="email" 
                          type="email" 
                          name="email" 
                          class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" 
                          value="{{ old('email') }}" 
                          required 
                          autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <!-- Password -->
        <div class="mb-3">
            <x-input-label for="password">{{ __('Password') }}</x-input-label>
            <x-text-input id="password"
                          type="password"
                          name="password"
                          class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                          required 
                          autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" />
            <small class="form-text text-muted">Минимум 8 символа</small>
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <x-input-label for="password_confirmation">{{ __('Confirm Password') }}</x-input-label>
            <x-text-input id="password_confirmation"
                          type="password"
                          name="password_confirmation" 
                          class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                          required 
                          autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" />
        </div>

        <div class="d-flex justify-content-between align-items-center">
            <a class="text-decoration-none" href="{{ route('login') }}">
                <i class="bi bi-arrow-left me-1"></i>{{ __('Already registered?') }}
            </a>

            <x-primary-button>
                <i class="bi bi-check-circle me-1"></i>{{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
