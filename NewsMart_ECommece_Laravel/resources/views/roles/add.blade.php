<div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="addRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content item-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="addRoleModalLabel">
                    <i class="fa-light fa-plus-circle"></i>
                    Add New Role
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="modalMessages" class="mb-3" style="display: none;">
                    <div id="errorMessage" class="alert alert-danger" style="display: none;"></div>
                    <div id="successMessage" class="alert alert-success" style="display: none;"></div>
                </div>

                <form id="addRoleForm" action="{{ route('role.add') }}" method="post">
                    @csrf

                    <div class="form-group mb-4">
                        <label class="form-label" for="name">
                            <i class="fa-light fa-user-shield"></i>
                            Role Name
                        </label>
                        <input
                            type="text"
                            class="form-control item-input @error('name') is-invalid @enderror"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Enter role name"
                            required />
                        @error('name')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
                    
                    <div class="form-group mb-4">
                        <label class="form-label" for="description">
                            <i class="fa-light fa-file-lines"></i>
                            Role Description
                        </label>
                        <textarea
                            class="form-control item-textarea @error('description') is-invalid @enderror"
                            id="description"
                            name="description"
                            rows="4"
                            placeholder="Describe this role">{{ old('description') }}</textarea>
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
                <button type="submit" form="addRoleForm" class="btn btn-action" id="submitBtn">
                    <i class="fa-light fa-save"></i>
                    <span class="btn-text">Add Role</span>
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
        const addRoleModal = document.getElementById('addRoleModal');
        const addRoleForm = document.getElementById('addRoleForm');
        const submitBtn = document.getElementById('submitBtn');
        const btnText = submitBtn.querySelector('.btn-text');
        const btnLoading = submitBtn.querySelector('.btn-loading');

        // Reset form khi đóng modal
        addRoleModal.addEventListener('hidden.bs.modal', function() {
            addRoleForm.reset();

            // Xóa lỗi validation
            const invalidInputs = addRoleForm.querySelectorAll('.is-invalid');
            invalidInputs.forEach(input => input.classList.remove('is-invalid'));
            const feedbacks = addRoleForm.querySelectorAll('.invalid-feedback');
            feedbacks.forEach(fb => fb.style.display = 'none');

            // Ẩn thông báo
            document.getElementById('modalMessages').style.display = 'none';
            document.getElementById('errorMessage').style.display = 'none';
            document.getElementById('successMessage').style.display = 'none';

            // Reset nút
            submitBtn.disabled = false;
            btnText.style.display = 'inline';
            btnLoading.style.display = 'none';
        });

        // Khi submit
        addRoleForm.addEventListener('submit', function() {
            submitBtn.disabled = true;
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline';
        });

        // Focus input đầu tiên
        addRoleModal.addEventListener('shown.bs.modal', function() {
            document.getElementById('name').focus();
        });
    });
</script>
