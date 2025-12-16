<section>
    <p class="text-muted mb-4">
        {{ __("Update your account's profile information and email address.") }}
    </p>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <!-- Name Field -->
        <div class="mb-4">
            <label for="name" class="form-label fw-semibold">{{ __('Name') }}</label>
            <input type="text" 
                   id="name" 
                   name="name" 
                   class="form-control @error('name') is-invalid @enderror" 
                   value="{{ old('name', $user->name) }}" 
                   required 
                   autofocus 
                   autocomplete="name">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email Field -->
        <div class="mb-4">
            <label for="email" class="form-label fw-semibold">{{ __('Email') }}</label>
            <input type="email" 
                   id="email" 
                   name="email" 
                   class="form-control @error('email') is-invalid @enderror" 
                   value="{{ old('email', $user->email) }}" 
                   required 
                   autocomplete="username">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="alert alert-warning mt-3">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>{{ __('Your email address is unverified.') }}</strong>
                    <button form="send-verification" class="btn btn-link p-0 ms-2 text-decoration-none">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>

                    @if (session('status') === 'verification-link-sent')
                        <div class="alert alert-success mt-2 mb-0">
                            <i class="bi bi-check-circle me-2"></i>
                            {{ __('A new verification link has been sent to your email address.') }}
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <!-- Save Button -->
        <div class="d-flex align-items-center gap-3 mt-4 pt-3 border-top">
            <button type="submit" class="btn btn-primary px-4">
                <i class="bi bi-check-circle me-2"></i>{{ __('Save') }}
            </button>

            @if (session('status') === 'profile-updated')
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-success fw-semibold"
                >
                    <i class="bi bi-check-circle-fill me-1"></i>{{ __('Saved.') }}
                </div>
            @endif
        </div>
    </form>
</section>
