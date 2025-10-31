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
                    <input type="hidden" id="updateSettingKeyHidden" name="settingkey_hidden" value="">

                    {{-- Setting Key --}}
                    <div class="form-group mb-4">
                        <label class="form-label" for="updateSettingKey">
                            <i class="fa-light fa-key"></i>
                            Setting Key
                        </label>
                        <input type="text" class="form-control item-input" id="updateSettingKey" name="settingkey"
                            placeholder="Enter setting key" required readonly />
                        <div class="invalid-feedback"></div>
                    </div>

                    {{-- Setting Value --}}
                    <div class="form-group mb-4">
                        <label class="form-label" for="updateSettingValue">
                            <i class="fa-light fa-pen-to-square"></i>
                            Setting Value
                        </label>
                        <textarea class="form-control item-textarea" id="updateSettingValue" name="settingvalue"
                            rows="4" placeholder="Enter setting value"></textarea>
                        <div class="invalid-feedback"></div>
                    </div>

                    {{-- Description --}}
                    <div class="form-group mb-4">
                        <label class="form-label" for="updateDescription">
                            <i class="fa-light fa-file-lines"></i>
                            Description
                        </label>
                        <textarea class="form-control item-textarea" id="updateDescription" name="description" rows="3"
                            placeholder="Enter description (optional)"></textarea>
                        <div class="invalid-feedback"></div>
                    </div>
                </form>
            </div>

            <div class="modal-footer item-modal-footer">
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">
                    <i class="fa-light fa-times"></i>
                    Cancel
                </button>
                <button type="submit" form="updateConfigurationForm" class="btn btn-action" id="updateSubmitBtn">
                    <i class="fa-light fa-save"></i>
                    <span class="btn-text">Update Configuration</span>
                    <span class="btn-loading" style="display: none;">
                        <i class="fa-light fa-spinner fa-spin"></i>
                        Updating...
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const updateConfigurationModal = document.getElementById('updateConfigurationModal');
        const updateConfigurationForm = document.getElementById('updateConfigurationForm');
        const updateSubmitBtn = document.getElementById('updateSubmitBtn');
        const btnText = updateSubmitBtn.querySelector('.btn-text');
        const btnLoading = updateSubmitBtn.querySelector('.btn-loading');

        // Reset form when modal is closed
        updateConfigurationModal.addEventListener('hidden.bs.modal', function() {
            updateConfigurationForm.reset();

            const invalidInputs = updateConfigurationForm.querySelectorAll('.is-invalid');
            invalidInputs.forEach(input => input.classList.remove('is-invalid'));
            const feedbacks = updateConfigurationForm.querySelectorAll('.invalid-feedback');
            feedbacks.forEach(feedback => {
                feedback.style.display = 'none';
                feedback.textContent = '';
            });

            document.getElementById('updateModalMessages').style.display = 'none';
            document.getElementById('updateErrorMessage').style.display = 'none';
            document.getElementById('updateSuccessMessage').style.display = 'none';

            updateSubmitBtn.disabled = false;
            btnText.style.display = 'inline';
            btnLoading.style.display = 'none';
        });

        // Loading state on submit
        updateConfigurationForm.addEventListener('submit', function() {
            updateSubmitBtn.disabled = true;
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline';
        });

        // Focus input when modal opens
        updateConfigurationModal.addEventListener('shown.bs.modal', function() {
            document.getElementById('updateSettingValue').focus();
        });
    });

    // Open update modal with data
    function openUpdateConfigurationModal(settingkey, configData) {
        const updateForm = document.getElementById('updateConfigurationForm');
        updateForm.action = `{{ route('configuration.update', ['settingkey' => '__KEY__']) }}`.replace('__KEY__', settingkey);

        document.getElementById('updateSettingKeyHidden').value = settingkey;
        document.getElementById('updateSettingKey').value = configData.settingkey || '';
        document.getElementById('updateSettingValue').value = configData.settingvalue || '';
        document.getElementById('updateDescription').value = configData.description || '';

        const invalidInputs = updateForm.querySelectorAll('.is-invalid');
        invalidInputs.forEach(input => input.classList.remove('is-invalid'));

        const updateModal = new bootstrap.Modal(document.getElementById('updateConfigurationModal'));
        updateModal.show();
    }
</script>