<div class="modal fade" id="deleteRoleModal" tabindex="-1" aria-labelledby="deleteRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content delete-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="deleteRoleModalLabel">
                    <i class="fas fa-exclamation-triangle text-warning"></i>
                    Confirm Delete Role
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <div class="delete-confirmation text-center">
                    <div class="delete-icon-container mb-3">
                        <i class="fas fa-user-shield delete-icon"></i>
                    </div>
                    
                    <h4 class="delete-title mb-3">Are you sure?</h4>
                    
                    <div class="delete-message mb-4">
                        <p class="mb-2">
                            Do you really want to delete the role 
                            <strong id="deleteRoleNameToDelete" class="text-danger"></strong>?
                        </p>
                        
                        <div class="item-info-preview bg-light p-3 rounded mb-3" id="deleteRolePreview">
                            <div class="text-start">
                                <div class="preview-item" id="deleteSlugPreview">
                                    <small class="text-muted">Slug:</small>
                                    <span id="deleteRoleSlug"></span>
                                </div>
                                <div class="preview-item" id="deleteDescriptionPreview">
                                    <small class="text-muted">Description:</small>
                                    <span id="deleteRoleDescription"></span>
                                </div>
                            </div>
                        </div>
                        
                        <small class="warning-text text-muted">
                            <i class="fas fa-exclamation-circle"></i>
                            This action cannot be undone and may affect user permissions.
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
        const deleteRoleModal = document.getElementById('deleteRoleModal');
        const deleteConfirmBtn = document.getElementById('deleteConfirmDeleteBtn');
        const btnText = deleteConfirmBtn.querySelector('span:not(.btn-loading)');
        const btnLoading = deleteConfirmBtn.querySelector('.btn-loading');

        // Khi bấm nút xác nhận xóa
        deleteConfirmBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Hiển thị trạng thái loading
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline';
            deleteConfirmBtn.style.pointerEvents = 'none';
            
            // Điều hướng đến route xóa
            window.location.href = this.href;
        });

        // Reset khi đóng modal
        deleteRoleModal.addEventListener('hidden.bs.modal', function() {
            btnText.style.display = 'inline';
            btnLoading.style.display = 'none';
            deleteConfirmBtn.style.pointerEvents = 'auto';
        });
    });

    // Hàm mở modal và điền dữ liệu role
    function openDeleteModal(roleId, roleData) {
        document.getElementById('deleteRoleNameToDelete').textContent = roleData.name;

        const deleteBtn = document.getElementById('deleteConfirmDeleteBtn');
        deleteBtn.href = `<?php echo e(route('role.delete', ['id' => '__ID__'])); ?>`.replace('__ID__', roleId);

        document.getElementById('deleteRoleSlug').textContent = roleData.slug || 'N/A';
        document.getElementById('deleteRoleDescription').textContent = roleData.description || 'N/A';

        const deleteModal = new bootstrap.Modal(document.getElementById('deleteRoleModal'));
        deleteModal.show();
    }
</script>
<?php /**PATH C:\wamp64\www\Project\NewsMart_ECommece_Laravel\resources\views/roles/delete.blade.php ENDPATH**/ ?>