<section>
    <div class="alert alert-danger border-danger" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <strong>{{ __('Warning') }}!</strong> {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
    </div>

    <button type="button" 
            class="btn btn-danger px-4"
            id="deleteAccountBtn">
        <i class="bi bi-trash me-2"></i>{{ __('Delete Account') }}
    </button>

    <!-- Modal -->
    <div class="modal" 
         id="confirmUserDeletionModal" 
         tabindex="-1" 
         aria-labelledby="confirmUserDeletionModalLabel" 
         aria-hidden="true">
        <div class="modal-backdrop"></div>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="confirmUserDeletionModalLabel">
                        <i class="bi bi-exclamation-triangle me-2"></i>{{ __('Are you sure you want to delete your account?') }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" id="closeModalBtn" aria-label="Close"></button>
                </div>
                <form method="post" action="{{ route('profile.destroy') }}" id="deleteAccountForm">
                    @csrf
                    @method('delete')
                    
                    <div class="modal-body">
                        @if($errors->userDeletion->isNotEmpty())
                            <div class="alert alert-danger">
                                <i class="bi bi-exclamation-circle me-2"></i>
                                @foreach($errors->userDeletion->all() as $error)
                                    {{ $error }}
                                @endforeach
                            </div>
                        @endif
                        
                        <div class="alert alert-warning mb-3">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                        </div>

                        <div class="mb-3">
                            <label for="delete_password" class="form-label fw-semibold">{{ __('Password') }}</label>
                            <input type="password" 
                                   id="delete_password" 
                                   name="password" 
                                   class="form-control @error('password', 'userDeletion') is-invalid @enderror" 
                                   placeholder="{{ __('Password') }}"
                                   required
                                   autocomplete="current-password">
                            @error('password', 'userDeletion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="cancelBtn">
                            <i class="bi bi-x-circle me-1"></i>{{ __('Cancel') }}
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash me-1"></i>{{ __('Delete Account') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        (function() {
            let modal = document.getElementById('confirmUserDeletionModal');
            const openBtn = document.getElementById('deleteAccountBtn');
            let isInBody = false;
            
            function moveModalToBody() {
                if (!isInBody && modal) {
                    // Clone the modal
                    const modalClone = modal.cloneNode(true);
                    modalClone.id = 'confirmUserDeletionModal';
                    
                    // Remove old modal
                    modal.remove();
                    
                    // Append to body
                    document.body.appendChild(modalClone);
                    
                    // Update reference
                    modal = document.getElementById('confirmUserDeletionModal');
                    isInBody = true;
                    
                    // Reattach event listeners
                    attachEventListeners();
                }
            }
            
            function attachEventListeners() {
                const backdrop = modal.querySelector('.modal-backdrop');
                const closeBtn = document.getElementById('closeModalBtn');
                const cancelBtn = document.getElementById('cancelBtn');
                
                // Remove old listeners by cloning
                const newCloseBtn = modal.querySelector('#closeModalBtn');
                const newCancelBtn = modal.querySelector('#cancelBtn');
                const newBackdrop = modal.querySelector('.modal-backdrop');
                
                if (newCloseBtn) {
                    newCloseBtn.onclick = hideModal;
                }
                
                if (newCancelBtn) {
                    newCancelBtn.onclick = hideModal;
                }
                
                if (newBackdrop) {
                    newBackdrop.onclick = hideModal;
                }
            }
            
            function showModal() {
                moveModalToBody();
                
                const backdrop = modal.querySelector('.modal-backdrop');
                if (backdrop) {
                    backdrop.style.display = 'block';
                }
                
                modal.style.display = 'flex';
                modal.style.position = 'fixed';
                modal.style.top = '0';
                modal.style.left = '0';
                modal.style.width = '100%';
                modal.style.height = '100%';
                modal.style.zIndex = '9999';
                modal.style.alignItems = 'center';
                modal.style.justifyContent = 'center';
                
                document.body.style.overflow = 'hidden';
                modal.setAttribute('aria-hidden', 'false');
            }
            
            function hideModal() {
                const backdrop = modal.querySelector('.modal-backdrop');
                if (backdrop) {
                    backdrop.style.display = 'none';
                }
                
                modal.style.display = 'none';
                document.body.style.overflow = '';
                modal.setAttribute('aria-hidden', 'true');
                
                const form = document.getElementById('deleteAccountForm');
                if (form) {
                    form.reset();
                }
                
                const passwordInput = document.getElementById('delete_password');
                if (passwordInput) {
                    passwordInput.classList.remove('is-invalid');
                }
            }
            
            // Open modal
            if (openBtn) {
                openBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    showModal();
                });
            }
            
            // Close on ESC key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && modal && modal.style.display === 'flex') {
                    hideModal();
                }
            });
            
            // Show modal on page load if there are errors
            @if($errors->userDeletion->isNotEmpty())
                setTimeout(function() {
                    moveModalToBody();
                    showModal();
                }, 100);
            @endif
        })();
    </script>

    <style>
        #confirmUserDeletionModal {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 100% !important;
            display: none;
            z-index: 9999 !important;
            margin: 0 !important;
            padding: 0 !important;
            align-items: center;
            justify-content: center;
        }
        
        #confirmUserDeletionModal .modal-backdrop {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 100% !important;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 9998;
            margin: 0;
            padding: 0;
        }
        
        #confirmUserDeletionModal .modal-dialog {
            position: relative !important;
            z-index: 9999 !important;
            margin: 0 auto !important;
            max-width: 500px;
            width: 90%;
            pointer-events: auto;
        }
        
        #confirmUserDeletionModal .modal-content {
            position: relative;
            pointer-events: auto;
        }
    </style>
</section>
