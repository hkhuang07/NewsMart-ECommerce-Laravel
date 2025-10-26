<div class="modal fade" id="deleteConfigurationModal" tabindex="-1" aria-labelledby="deleteConfigurationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content delete-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="deleteConfigurationModalLabel">
                    <i class="fas fa-exclamation-triangle text-warning"></i>
                    Confirm Delete Configuration
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <div class="delete-confirmation text-center">
                    <div class="delete-icon-container mb-3">
                        <i class="fas fa-trash-alt delete-icon"></i>
                    </div>
                    
                    <h4 class="delete-title mb-3">Are you sure?</h4>
                    
                    <div class="delete-message mb-4">
                        <p class="mb-2">
                            Do you really want to delete the configuration 
                            <strong id="deleteConfigKeyToDelete" class="text-danger"></strong>?
                        </p>
                        
                        <div class="item-info-preview bg-light p-3 rounded mb-3" id="deleteConfigPreview">
                            <div class="text-start">
                                <div class="preview-item mb-2">
                                    <small class="text-muted">Value:</small>
                                    <span id="deleteConfigValue"></span>
                                </div>
                                <div class="preview-item mb-2">
                                    <small class="text-muted">Description:</small>
                                    <span id="deleteConfigDescription"></span>
                                </div>
                                <div class="preview-item mb-2">
                                    <small class="text-muted">Created At:</small>
                                    <span id="deleteConfigCreatedAt"></span>
                                </div>
                                <div class="preview-item">
                                    <small class="text-muted">Updated At:</small>
                                    <span id="deleteConfigUpdatedAt"></span>
                                </div>
                            </div>
                        </div>
                        
                        <small class="warning-text text-muted">
                            <i class="fas fa-exclamation-circle"></i>
                            This action cannot be undone and will permanently remove this configuration.
                        </small>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer item-modal-footer">
                <button type="button" class="btn btn-cancel me-3" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i>
                    Cancel
                </button>
                <a href="#" id="deleteConfirmDeleteConfigBtn" class="btn btn-delete">
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
        const deleteConfigModal = document.getElementById('deleteConfigurationModal');
        const deleteConfirmBtn = document.getElementById('deleteConfirmDeleteConfigBtn');
        const btnText = deleteConfirmBtn.querySelector('span:not(.btn-loading)');
        const btnLoading = deleteConfirmBtn.querySelector('.btn-loading');

        // Khi nhấn nút xác nhận xóa
        deleteConfirmBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline';
            deleteConfirmBtn.style.pointerEvents = 'none';
            
            window.location.href = this.href;
        });

        // Reset nút khi đóng modal
        deleteConfigModal.addEventListener('hidden.bs.modal', function() {
            btnText.style.display = 'inline';
            btnLoading.style.display = 'none';
            deleteConfirmBtn.style.pointerEvents = 'auto';
        });
    });

    // Hàm mở modal xóa
    // function openDeleteConfigModal(settingKey, configData) {
    //     document.getElementById('deleteConfigKeyToDelete').textContent = settingKey;
        
    //     // Gán đường dẫn xóa
    //     const deleteBtn = document.getElementById('deleteConfirmDeleteConfigBtn');
    //     deleteBtn.href = `{{ route('configuration.delete', ['settingkey' => '__KEY__']) }}`.replace('__KEY__', settingKey);
        
    //     // Gán thông tin cấu hình
    //     document.getElementById('deleteConfigValue').textContent = configData.settingvalue || 'N/A';
    //     document.getElementById('deleteConfigDescription').textContent = configData.description || 'N/A';
    //     document.getElementById('deleteConfigCreatedAt').textContent = configData.created_at || 'N/A';
    //     document.getElementById('deleteConfigUpdatedAt').textContent = configData.updated_at || 'N/A';
        
    //     // Hiển thị modal
    //     const deleteModal = new bootstrap.Modal(document.getElementById('deleteConfigurationModal'));
    //     deleteModal.show();
    // }
</script>
