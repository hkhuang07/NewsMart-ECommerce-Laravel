<div class="modal fade" id="addConfigurationModal" tabindex="-1" aria-labelledby="addConfigurationModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content item-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="addConfigurationModalLabel">
                    <i class="fa-light fa-plus-circle"></i>
                    Add New Configuration
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="modalMessages" class="mb-3" style="display: none;">
                    <div id="errorMessage" class="alert alert-danger" style="display: none;"></div>
                    <div id="successMessage" class="alert alert-success" style="display: none;"></div>
                </div>

                <form id="addConfigurationForm" action="{{ route('configuration.add') }}" method="post">
                    @csrf

                    {{-- Setting Key --}}
                    <div class="form-group mb-4">
                        <label class="form-label" for="settingkey">
                            <i class="fa-light fa-key"></i>
                            Setting Key
                        </label>
                        <input type="text" class="form-control item-input @error('settingkey') is-invalid @enderror"
                            id="settingkey" name="settingkey" value="{{ old('settingkey') }}"
                            placeholder="Enter unique setting key" required />
                        @error('settingkey')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>

                    {{-- Setting Value --}}
                    <div class="form-group mb-4">
                        <label class="form-label" for="settingvalue">
                            <i class="fa-light fa-pen-to-square"></i>
                            Setting Value
                        </label>
                        <textarea class="form-control item-textarea @error('settingvalue') is-invalid @enderror"
                            id="settingvalue" name="settingvalue" rows="4"
                            placeholder="Enter configuration value">{{ old('settingvalue') }}</textarea>
                        @error('settingvalue')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="form-group mb-4">
                        <label class="form-label" for="description">
                            <i class="fa-light fa-file-lines"></i>
                            Description
                        </label>
                        <input type="text" class="form-control item-input @error('description') is-invalid @enderror"
                            id="description" name="description" value="{{ old('description') }}"
                            placeholder="Optional: describe what this setting does" />
                        @error('description')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
                </form>
            </div>

            <div class="modal-footer item-modal-footer">
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">
                    <i class="fa-light fa-times"></i>
                    Cancel
                </button>
                <button type="submit" form="addConfigurationForm" class="btn btn-action" id="submitBtn">
                    <i class="fa-light fa-save"></i>
                    <span class="btn-text">Add Configuration</span>
                    <span class="btn-loading" style="display: none;">
                        <i class="fa-light fa-spinner fa-spin"></i>
                        Adding...
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('addConfigurationModal');
        const form = document.getElementById('addConfigurationForm');
        const submitBtn = document.getElementById('submitBtn');
        const btnText = submitBtn.querySelector('.btn-text');
        const btnLoading = submitBtn.querySelector('.btn-loading');

        // Reset form when modal is hidden
        modal.addEventListener('hidden.bs.modal', function() {
            form.reset();

            // Clear validation errors
            const invalidInputs = form.querySelectorAll('.is-invalid');
            invalidInputs.forEach(input => input.classList.remove('is-invalid'));
            const feedbacks = form.querySelectorAll('.invalid-feedback');
            feedbacks.forEach(f => f.style.display = 'none');

            // Hide messages
            document.getElementById('modalMessages').style.display = 'none';
            document.getElementById('errorMessage').style.display = 'none';
            document.getElementById('successMessage').style.display = 'none';

            // Reset button
            submitBtn.disabled = false;
            btnText.style.display = 'inline';
            btnLoading.style.display = 'none';
        });

        // Loading effect when submit
        form.addEventListener('submit', function() {
            submitBtn.disabled = true;
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline';
        });

        // Auto-focus first input when modal is shown
        modal.addEventListener('shown.bs.modal', function() {
            document.getElementById('settingkey').focus();
        });
    });
</script>