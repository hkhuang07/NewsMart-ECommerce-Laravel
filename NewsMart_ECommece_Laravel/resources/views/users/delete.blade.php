<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content delete-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="deleteUserModalLabel">
                    <i class="fas fa-exclamation-triangle text-warning"></i>
                    Confirm Delete User
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <div class="delete-confirmation text-center">
                    <div class="delete-icon-container mb-3">
                        <i class="fas fa-user-times delete-icon"></i> 
                    </div>
                    
                    <h4 class="delete-title mb-3">Are you sure?</h4>
                    
                    <div class="delete-message mb-4">
                        <p class="mb-2">
                            Do you really want to delete the user 
                            <strong id="deleteUserNameToDelete" class="text-danger"></strong>?
                        </p>
                        
                        {{-- User Preview Section --}}
                        <div class="item-info-preview bg-light p-3 rounded mb-3" id="deleteUserPreview">
                            <div class="row">
                                <div class="col-4">
                                    <div class="preview-logo" id="deleteAvatarPreview">
                                        <img id="deleteUserAvatar" src="" alt="User Avatar" class="delete-preview-logo">
                                        <div id="deleteNoAvatar" class="no-logo-placeholder">
                                            <i class="fas fa-user"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-8 preview-details">
                                    <div class="preview-item" id="deleteUsernamePreview">
                                        <small class="text-muted">Username:</small>
                                        <span id="deleteUserUsername"></span>
                                    </div>
                                    <div class="preview-item" id="deleteRolePreview">
                                        <small class="text-muted">Role:</small>
                                        <span id="deleteUserRoleName"></span>
                                    </div>
                                    <div class="preview-item" id="deleteEmailPreview">
                                        <small class="text-muted">Email:</small>
                                        <span id="deleteUserEmail"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <small class="warning-text text-muted">
                            <i class="fas fa-exclamation-circle"></i>
                            This action cannot be undone and may affect user access and related records.
                        </small>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer item-modal-footer">
                <button type="button" class="btn btn-cancel me-3" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i>
                    Cancel
                </button>
                <a href="#" id="deleteConfirmDeleteBtn" class="btn btn-delete">
                    <i class="fas fa-trash-alt"></i>
                    <span>Yes, Delete It</span>
                    <span class="btn-loading" style="display: none;">
                        <i class="fas fa-spinner fa-spin"></i>
                        Deleting...
                    </span>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteUserModal = document.getElementById('deleteUserModal');
        const deleteConfirmBtn = document.getElementById('deleteConfirmDeleteBtn');
        const btnText = deleteConfirmBtn.querySelector('span:not(.btn-loading)');
        const btnLoading = deleteConfirmBtn.querySelector('.btn-loading');

        // Handle delete confirmation click
        deleteConfirmBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Show loading state
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline';
            deleteConfirmBtn.style.pointerEvents = 'none';
            
            // Redirect to delete URL
            window.location.href = this.href;
        });

        // Reset button state when modal is hidden
        deleteUserModal.addEventListener('hidden.bs.modal', function() {
            btnText.style.display = 'inline';
            btnLoading.style.display = 'none';
            deleteConfirmBtn.style.pointerEvents = 'auto';
        });
    });

    /**
     * Function to open delete modal with user data (like Brands)
     * @param {string} userId
     * @param {object} userData (must include role relationship)
     */
    function openDeleteModal(userId, userData) {
        // Set user name
        document.getElementById('deleteUserNameToDelete').textContent = userData.name || 'N/A';
        
        // Set delete URL
        const deleteBtn = document.getElementById('deleteConfirmDeleteBtn');
        deleteBtn.href = `{{ route('user.delete', ['id' => '__ID__']) }}`.replace('__ID__', userId);
        
        // Populate user preview
        document.getElementById('deleteUserUsername').textContent = userData.username || 'N/A';
        document.getElementById('deleteUserEmail').textContent = userData.email || 'N/A';
        document.getElementById('deleteUserRoleName').textContent = userData.role?.name || 'N/A';
        
        // Handle Avatar preview
        const avatarImg = document.getElementById('deleteUserAvatar');
        const noAvatarPlaceholder = document.getElementById('deleteNoAvatar');
        
        if (userData.avatar) {
            const avatarUrl = `{{ asset('storage/') }}/${userData.avatar}`;
            avatarImg.src = avatarUrl;
            avatarImg.style.display = 'block';
            noAvatarPlaceholder.style.display = 'none';
        } else {
            avatarImg.style.display = 'none';
            noAvatarPlaceholder.style.display = 'flex';
        }
        
        // Show modal
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteUserModal'));
        deleteModal.show();
    }

    // Export function globally
    window.openDeleteModal = openDeleteModal;
</script>