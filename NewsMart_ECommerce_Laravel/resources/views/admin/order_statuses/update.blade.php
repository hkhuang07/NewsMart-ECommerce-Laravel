<div class="modal fade" id="updateOrderStatusModal" tabindex="-1" aria-labelledby="updateOrderStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content item-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="updateOrderStatusModalLabel">
                    <i class="fa-light fa-edit"></i>
                    Edit Order Status
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="updateOrderStatusForm" action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="updateStatusId" name="status_id" value="">

                    <div class="form-group mb-4">
                        <label class="form-label" for="updateName">
                            <i class="fa-light fa-clipboard-check"></i>
                            Status Name
                        </label>
                        <input
                            type="text"
                            class="form-control item-input"
                            id="updateName"
                            name="name"
                            placeholder="Enter status name"
                            required />
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="updateDescription">
                            <i class="fa-light fa-file-text"></i>
                            Status Description
                        </label>
                        <textarea
                            class="form-control item-textarea"
                            id="updateDescription"
                            name="description"
                            rows="4"
                            placeholder="Enter status description"></textarea>
                        <div class="invalid-feedback"></div>
                    </div>
                </form>
            </div>

            <div class="modal-footer item-modal-footer">
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">
                    <i class="fa-light fa-times"></i>
                    Cancel
                </button>
                <button type="submit" form="updateOrderStatusForm" class="btn btn-action" id="updateSubmitBtn">
                    <i class="fa-light fa-save"></i>
                    <span class="btn-text">Update Status</span>
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
        const updateOrderStatusModal = document.getElementById('updateOrderStatusModal');
        const updateOrderStatusForm = document.getElementById('updateOrderStatusForm');
        const updateSubmitBtn = document.getElementById('updateSubmitBtn');
        const btnText = updateSubmitBtn.querySelector('.btn-text');
        const btnLoading = updateSubmitBtn.querySelector('.btn-loading');

        // Reset modal khi đóng
        updateOrderStatusModal.addEventListener('hidden.bs.modal', function() {
            updateOrderStatusForm.reset();

            const invalidInputs = updateOrderStatusForm.querySelectorAll('.is-invalid');
            invalidInputs.forEach(input => input.classList.remove('is-invalid'));
            const feedbacks = updateOrderStatusForm.querySelectorAll('.invalid-feedback');
            feedbacks.forEach(feedback => {
                feedback.style.display = 'none';
                feedback.textContent = '';
            });

            updateSubmitBtn.disabled = false;
            btnText.style.display = 'inline';
            btnLoading.style.display = 'none';
        });

        // Gửi form qua AJAX (để reload trang sau khi update thành công)
        updateOrderStatusForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Ngăn submit mặc định

            updateSubmitBtn.disabled = true;
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline';

            const formData = new FormData(updateOrderStatusForm);

            fetch(updateOrderStatusForm.action, {
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
        updateOrderStatusModal.addEventListener('shown.bs.modal', function() {
            document.getElementById('updateName').focus();
        });
    });

    // Mở modal và đổ dữ liệu
    function openUpdateStatusModal(statusId, statusData) {
        const updateForm = document.getElementById('updateOrderStatusForm');
        updateForm.action = `{{ route('admin.orderstatus.update', ['id' => '__ID__']) }}`.replace('__ID__', statusId);

        document.getElementById('updateStatusId').value = statusId;
        document.getElementById('updateName').value = statusData.name || '';
        document.getElementById('updateDescription').value = statusData.description || '';

        const invalidInputs = updateForm.querySelectorAll('.is-invalid');
        invalidInputs.forEach(input => input.classList.remove('is-invalid'));

        const updateModal = new bootstrap.Modal(document.getElementById('updateOrderStatusModal'));
        updateModal.show();
    }
</script>