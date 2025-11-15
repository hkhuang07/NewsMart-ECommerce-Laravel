<div class="modal fade" id="deleteConfigurationModal" tabindex="-1" aria-labelledby="deleteConfigurationModalLabel"
    aria-hidden="true">
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
                            <strong id="deleteSettingKeyToDelete" class="text-danger"></strong>?
                        </p>

                        <div class="item-info-preview bg-light p-3 rounded mb-3" id="deleteConfigurationPreview">
                            <div class="text-start">
                                <div class="preview-item mb-2">
                                    <small class="text-muted">Setting Key:</small>
                                    <span id="deleteConfigurationKey"></span>
                                </div>
                                <div class="preview-item mb-2">
                                    <small class="text-muted">Value:</small>
                                    <span id="deleteConfigurationValue"></span>
                                </div>
                                <div class="preview-item">
                                    <small class="text-muted">Description:</small>
                                    <span id="deleteConfigurationDescription"></span>
                                </div>
                            </div>
                        </div>

                        <small class="warning-text text-muted">
                            <i class="fas fa-exclamation-circle"></i>
                            This action cannot be undone and may affect application settings.
                        </small>
                    </div>
                </div>
            </div>

            <div class="modal-footer item-modal-footer">
                <button type="button" class="btn btn-cancel me-3" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i>
                    Cancel
                </button>
                <a href="#" id="deleteConfirmConfigurationBtn" class="btn btn-delete">
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
    // Định nghĩa template route DELETE an toàn
    const CONFIG_DELETE_ROUTE_TEMPLATE = "{{ route('configuration.delete', ['settingkey' => 'TEMP_KEY']) }}";

    document.addEventListener('DOMContentLoaded', function() {
        const deleteConfigurationModal = document.getElementById('deleteConfigurationModal');
        const deleteConfirmBtn = document.getElementById('deleteConfirmConfigurationBtn');
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
        deleteConfigurationModal.addEventListener('hidden.bs.modal', function() {
            btnText.style.display = 'inline';
            btnLoading.style.display = 'none';
            deleteConfirmBtn.style.pointerEvents = 'auto';
        });
    });

    // Function to open delete modal with configuration data
    function openDeleteConfigurationModal(settingKey, configurationData) {
        // Set configuration key
        document.getElementById('deleteSettingKeyToDelete').textContent = configurationData.settingkey;

        // Set delete URL (FIXED: Sử dụng template route an toàn)
        const deleteBtn = document.getElementById('deleteConfirmConfigurationBtn');
        deleteBtn.href = CONFIG_DELETE_ROUTE_TEMPLATE.replace('TEMP_KEY', settingKey);

        // Populate configuration preview
        document.getElementById('deleteConfigurationKey').textContent = configurationData.settingkey || 'N/A';
        document.getElementById('deleteConfigurationValue').textContent = configurationData.settingvalue || 'N/A';
        document.getElementById('deleteConfigurationDescription').textContent = configurationData.description || 'N/A';

        // Show modal
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteConfigurationModal'));
        deleteModal.show();
    }
</script>