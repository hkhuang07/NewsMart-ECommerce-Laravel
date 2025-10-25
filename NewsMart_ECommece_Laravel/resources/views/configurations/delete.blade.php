<!-- Delete Configuration Modal -->
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
                            <strong id="deleteConfigKey" class="text-danger"></strong>?
                        </p>

                        <div class="item-info-preview bg-light p-3 rounded mb-3" id="deleteConfigPreview">
                            <div class="preview-details text-start">
                                <div class="preview-item mb-2">
                                    <small class="text-muted">Setting Key:</small>
                                    <span id="previewSettingKey" class="fw-bold"></span>
                                </div>
                                <div class="preview-item mb-2">
                                    <small class="text-muted">Value:</small>
                                    <span id="previewSettingValue"></span>
                                </div>
                                <div class="preview-item">
                                    <small class="text-muted">Description:</small>
                                    <span id="previewDescription"></span>
                                </div>
                            </div>
                        </div>

                        <small class="warning-text text-muted">
                            <i class="fas fa-exclamation-circle"></i>
                            This action cannot be undone and may affect system settings.
                        </small>
                    </div>
                </div>
            </div>

            <div class="modal-footer item-modal-footer">
                <button type="button" class="btn btn-cancel me-3" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i>
                    Cancel
                </button>

                <a href="#" id="deleteConfirmConfigBtn" class="btn btn-delete">
                    <i class="fas fa-trash-alt"></i>
                    <span class="btn-text">Yes, Delete It</span>
                    <span class="btn-loading" style="display: none;">
                        <i class="fas fa-spinner fa-spin"></i> Deleting...
                    </span>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const deleteConfigModal = document.getElementById("deleteConfigurationModal");
        const deleteConfirmBtn = document.getElementById("deleteConfirmConfigBtn");
        const btnText = deleteConfirmBtn.querySelector(".btn-text");
        const btnLoading = deleteConfirmBtn.querySelector(".btn-loading");

        // Khi nhấn nút xác nhận xóa
        deleteConfirmBtn.addEventListener("click", function(e) {
            e.preventDefault();
            if (!this.href || this.href === "#") return;

            btnText.style.display = "none";
            btnLoading.style.display = "inline";
            deleteConfirmBtn.classList.add("disabled");
            deleteConfirmBtn.style.pointerEvents = "none";

            // Hiệu ứng chờ 500ms rồi chuyển trang
            setTimeout(() => {
                window.location.href = this.href;
            }, 500);
        });

        // Reset lại nút khi modal đóng
        deleteConfigModal.addEventListener("hidden.bs.modal", function() {
            btnText.style.display = "inline";
            btnLoading.style.display = "none";
            deleteConfirmBtn.classList.remove("disabled");
            deleteConfirmBtn.style.pointerEvents = "auto";
        });
    });

    // Hàm mở modal xóa configuration
    function openDeleteConfigModal(settingKey, configData) {
        document.getElementById("deleteConfigKey").textContent = configData.settingkey || settingKey;
        document.getElementById("previewSettingKey").textContent = configData.settingkey || settingKey;
        document.getElementById("previewSettingValue").textContent = configData.settingvalue || "N/A";
        document.getElementById("previewDescription").textContent = configData.description || "N/A";

        // Gán route xóa (Laravel route động)
        const deleteBtn = document.getElementById("deleteConfirmConfigBtn");
        deleteBtn.href = `{{ route('configuration.delete', ['key' => '__KEY__']) }}`.replace('__KEY__', settingKey);

        // Hiển thị modal
        const modal = new bootstrap.Modal(document.getElementById("deleteConfigurationModal"));
        modal.show();
    }
</script>