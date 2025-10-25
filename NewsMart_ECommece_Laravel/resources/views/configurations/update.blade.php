<!-- Update Configuration Modal -->
<div class="modal fade" id="updateConfigurationModal" tabindex="-1" aria-labelledby="updateConfigurationModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content item-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="updateConfigurationModalLabel">
                    <i class="fa-light fa-edit"></i>
                    Edit Configuration
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="updateModalMessages" class="mb-3" style="display: none;">
                    <div id="updateErrorMessage" class="alert alert-danger" style="display: none;"></div>
                    <div id="updateSuccessMessage" class="alert alert-success" style="display: none;"></div>
                </div>

                <form id="updateConfigurationForm" action="" method="post">
                    @csrf
                    {{-- @method('PUT') --}}

                    {{-- Setting Key (primary key, readonly) --}}
                    <div class="form-group mb-4">
                        <label class="form-label" for="updateSettingKey">
                            <i class="fa-light fa-key"></i>
                            Setting Key
                        </label>
                        <input type="text" class="form-control item-input" id="updateSettingKey" name="settingkey"
                            placeholder="Enter setting key" readonly required />
                        <div class="invalid-feedback"></div>
                    </div>

                    {{-- Setting Value --}}
                    <div class="form-group mb-4">
                        <label class="form-label" for="updateSettingValue">
                            <i class="fa-light fa-database"></i>
                            Setting Value
                        </label>
                        <textarea class="form-control item-textarea" id="updateSettingValue" name="settingvalue"
                            rows="3" placeholder="Enter setting value" required></textarea>
                        <div class="invalid-feedback"></div>
                    </div>

                    {{-- Description --}}
                    <div class="form-group mb-4">
                        <label class="form-label" for="updateDescription">
                            <i class="fa-light fa-file-lines"></i>
                            Description
                        </label>
                        <textarea class="form-control item-textarea" id="updateDescription" name="description" rows="3"
                            placeholder="Enter description"></textarea>
                        <div class="invalid-feedback"></div>
                    </div>
                </form>
            </div>

            <div class="modal-footer item-modal-footer">
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">
                    <i class="fa-light fa-times"></i> Cancel
                </button>
                <button type="submit" form="updateConfigurationForm" class="btn btn-action" id="updateSubmitBtn">
                    <i class="fa-light fa-save"></i>
                    <span class="btn-text">Update Configuration</span>
                    <span class="btn-loading" style="display: none;">
                        <i class="fa-light fa-spinner fa-spin"></i> Updating...
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('updateConfigurationModal');
        const form = document.getElementById('updateConfigurationForm');
        const submitBtn = document.getElementById('updateSubmitBtn');
        const btnText = submitBtn.querySelector('.btn-text');
        const btnLoading = submitBtn.querySelector('.btn-loading');

        // Reset modal when hidden
        modal.addEventListener('hidden.bs.modal', function() {
            form.reset();
            form.querySelectorAll('.is-invalid').forEach(i => i.classList.remove('is-invalid'));
            document.querySelectorAll('.invalid-feedback').forEach(fb => fb.textContent = '');
            submitBtn.disabled = false;
            btnText.style.display = 'inline';
            btnLoading.style.display = 'none';
        });

        // Loading effect
        form.addEventListener('submit', function() {
            submitBtn.disabled = true;
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline';
        });
    });

    // Open update modal and fill old data
    function openUpdateModal(settingKey, configData) {
        const form = document.getElementById('updateConfigurationForm');

        // Gán action (route dùng settingkey)
        form.action = `{{ route('configuration.update', ['key' => '__KEY__']) }}`.replace('__KEY__', settingKey);

        // Gán dữ liệu cũ vào form
        document.getElementById('updateSettingKey').value = configData.settingkey || '';
        document.getElementById('updateSettingValue').value = configData.settingvalue || '';
        document.getElementById('updateDescription').value = configData.description || '';

        const modal = new bootstrap.Modal(document.getElementById('updateConfigurationModal'));
        modal.show();
    }
</script>