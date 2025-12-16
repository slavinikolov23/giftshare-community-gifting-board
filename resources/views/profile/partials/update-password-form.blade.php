<section>
    <p class="text-muted mb-4">
        {{ __('Ensure your account is using a long, random password to stay secure.') }}
    </p>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <!-- Current Password -->
        <div class="mb-4">
            <label for="update_password_current_password" class="form-label fw-semibold">{{ __('Current Password') }}</label>
            <input type="password" 
                   id="update_password_current_password" 
                   name="current_password" 
                   class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" 
                   autocomplete="current-password">
            @error('current_password', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- New Password -->
        <div class="mb-4">
            <label for="update_password_password" class="form-label fw-semibold">{{ __('New Password') }}</label>
            <input type="password" 
                   id="update_password_password" 
                   name="password" 
                   class="form-control @error('password', 'updatePassword') is-invalid @enderror" 
                   autocomplete="new-password">
            @error('password', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <label for="update_password_password_confirmation" class="form-label fw-semibold">{{ __('Confirm Password') }}</label>
            <input type="password" 
                   id="update_password_password_confirmation" 
                   name="password_confirmation" 
                   class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror" 
                   autocomplete="new-password">
            @error('password_confirmation', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Save Button -->
        <div class="d-flex align-items-center gap-3 mt-4 pt-3 border-top">
            <button type="submit" class="btn btn-info text-white px-4">
                <i class="bi bi-check-circle me-2"></i>{{ __('Save') }}
            </button>

            @if (session('status') === 'password-updated')
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
