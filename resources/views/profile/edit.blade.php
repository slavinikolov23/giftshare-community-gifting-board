<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <i class="bi bi-person-circle me-2"></i>{{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Profile Information Card -->
                <div class="card shadow-sm mb-4 border-0" style="border-radius: 15px;">
                    <div class="card-header bg-primary text-white border-0" style="border-radius: 15px 15px 0 0;">
                        <h4 class="mb-0">
                            <i class="bi bi-person-circle me-2"></i>{{ __('Profile Information') }}
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <!-- Update Password Card -->
                <div class="card shadow-sm mb-4 border-0" style="border-radius: 15px;">
                    <div class="card-header bg-info text-white border-0" style="border-radius: 15px 15px 0 0;">
                        <h4 class="mb-0">
                            <i class="bi bi-shield-lock me-2"></i>{{ __('Update Password') }}
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <!-- Delete Account Card -->
                <div class="card shadow-sm mb-4 border-0 border-danger" style="border-radius: 15px; border-width: 2px !important;">
                    <div class="card-header bg-danger text-white border-0" style="border-radius: 15px 15px 0 0;">
                        <h4 class="mb-0">
                            <i class="bi bi-exclamation-triangle me-2"></i>{{ __('Delete Account') }}
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
