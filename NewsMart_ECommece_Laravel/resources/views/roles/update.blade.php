<div class="modal fade" id="updateRoleModal" tabindex="-1" aria-labelledby="updateRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content item-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="updateRoleModalLabel">
                    <i class="fa-light fa-edit"></i>
                    Edit Role
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="updateRoleForm" action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="updateRoleId" name="role_id" value="">

                    <div class="form-group mb-4">
                        <label class="form-label" for="updateName">
                            <i class="fa-light fa-user-shield"></i>
                            Role Name
                        </label>
                        <input
                            type="text"
                            class="form-control item-input"
                            id="updateName"
                            name="name"
                            placeholder="Enter role name"
                            required />
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="updateSlug">
                            <i class="fa-light fa-link"></i>
                            Role Slug
                        </label>
                        <input
                            type="text"
                            class="form-control item-input"
                            id="updateSlug"
                            name="slug"
                            placeholder="Enter role slug (optional)" />
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="updateDescription">
                            <i class="fa-light fa-file-text"></i>
                            Role Description
                        </label>
                        <textarea
                            class="form-control item-textarea"
                            id="updateDescription"
                            name="description"
                            rows="4"
                            placeholder="Enter role description"></textarea>
                        <div class="invalid-feedback"></div>
                    </div>
                </form>
            </div>

            <div class="modal-footer item-modal-footer">
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">
                    <i class="fa-light fa-times"></i>
                    Cancel
                </button>
                <button type="submit" form="updateRoleForm" class="btn btn-action" id="updateSubmitBtn">
                    <i class="fa-light fa-save"></i>
                    <span class="btn-text">Update Role</span>
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
        const updateRoleModal = document.getElementById('updateRoleModal');
        const updateRoleForm = document.getElementById('updateRoleForm');
        const updateSubmitBtn = document.getElementById('updateSubmitBtn');
        const btnText = updateSubmitBtn.querySelector('.btn-text');
        const btnLoading = updateSubmitBtn.querySelector('.btn-loading');

        // Reset modal khi đóng
        updateRoleModal.addEventListener('hidden.bs.modal', function() {
            updateRoleForm.reset();

            const invalidInputs = updateRoleForm.querySelectorAll('.is-invalid');
            invalidInputs.forEach(input => input.classList.remove('is-invalid'));
            const feedbacks = updateRoleForm.querySelectorAll('.invalid-feedback');
            feedbacks.forEach(feedback => {
                feedback.style.display = 'none';
                feedback.textContent = '';
            });

            updateSubmitBtn.disabled = false;
            btnText.style.display = 'inline';
            btnLoading.style.display = 'none';
        });

        // Gửi form qua AJAX (để reload trang sau khi update thành công)
        updateRoleForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Ngăn submit mặc định

            updateSubmitBtn.disabled = true;
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline';

            const formData = new FormData(updateRoleForm);

            fetch(updateRoleForm.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (response.ok) {
                    // Thành công → reload lại trang
                    location.reload();
                } else {
                    // Nếu lỗi → bật lại nút
                    updateSubmitBtn.disabled = false;
                    btnText.style.display = 'inline';
                    btnLoading.style.display = 'none';
                    console.error('Update failed');
                }
            })
            .catch(error => {
                console.error(error);
                updateSubmitBtn.disabled = false;
                btnText.style.display = 'inline';
                btnLoading.style.display = 'none';
            });
        });

        // Focus ô nhập khi mở modal
        updateRoleModal.addEventListener('shown.bs.modal', function() {
            document.getElementById('updateName').focus();
        });
    });

    // Mở modal và đổ dữ liệu
    function openUpdateModal(roleId, roleData) {
        const updateForm = document.getElementById('updateRoleForm');
        updateForm.action = `{{ route('role.update', ['id' => '__ID__']) }}`.replace('__ID__', roleId);

        document.getElementById('updateRoleId').value = roleId;
        document.getElementById('updateName').value = roleData.name || '';
        document.getElementById('updateSlug').value = roleData.slug || '';
        document.getElementById('updateDescription').value = roleData.description || '';

        const invalidInputs = updateForm.querySelectorAll('.is-invalid');
        invalidInputs.forEach(input => input.classList.remove('is-invalid'));

        const updateModal = new bootstrap.Modal(document.getElementById('updateRoleModal'));
        updateModal.show();
    }
</script>
