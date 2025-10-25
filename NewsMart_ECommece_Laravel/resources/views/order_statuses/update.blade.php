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
                <div id="updateModalMessages" class="mb-3" style="display: none;">
                    <div id="updateErrorMessage" class="alert alert-danger" style="display: none;"></div>
                    <div id="updateSuccessMessage" class="alert alert-success" style="display: none;"></div>
                </div>

                <form id="updateOrderStatusForm" action="" method="post">
                    @csrf
                    <input type="hidden" id="updateOrderStatusId" name="order_statuses_id" value="">

                    <!-- Name -->
                    <div class="form-group mb-4">
                        <label class="form-label" for="updateName">
                            <i class="fa-light fa-tag"></i>
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

                    <!-- Description -->
                    <div class="form-group mb-4">
                        <label class="form-label" for="updateDescription">
                            <i class="fa-light fa-file-text"></i>
                            Description
                        </label>
                        <textarea
                            class="form-control item-textarea"
                            id="updateDescription"
                            name="description"
                            rows="4"
                            placeholder="Enter status description (optional)"></textarea>
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
    const updateModal = document.getElementById('updateOrderStatusModal');
    const updateForm = document.getElementById('updateOrderStatusForm');
    const updateSubmitBtn = document.getElementById('updateSubmitBtn');
    const btnText = updateSubmitBtn.querySelector('.btn-text');
    const btnLoading = updateSubmitBtn.querySelector('.btn-loading');

    // Reset modal khi đóng
    updateModal.addEventListener('hidden.bs.modal', function() {
        updateForm.reset();
        updateSubmitBtn.disabled = false;
        btnText.style.display = 'inline';
        btnLoading.style.display = 'none';
    });

    // Khi submit form
    updateForm.addEventListener('submit', function() {
        updateSubmitBtn.disabled = true;
        btnText.style.display = 'none';
        btnLoading.style.display = 'inline';
    });

    // Focus ô đầu tiên khi mở modal
    updateModal.addEventListener('shown.bs.modal', function() {
        document.getElementById('updateName').focus();
    });
});

// Mở modal và gán dữ liệu
function openUpdateModal(orderStatusId, orderStatusData) {
    const form = document.getElementById('updateOrderStatusForm');
    form.action = `{{ route('order_statuses.update', ['id' => '__ID__']) }}`.replace('__ID__', orderStatusId);
    
    document.getElementById('updateOrderStatusId').value = orderStatusId;
    document.getElementById('updateName').value = orderStatusData.name || '';
    document.getElementById('updateDescription').value = orderStatusData.description || '';

    const modal = new bootstrap.Modal(document.getElementById('updateOrderStatusModal'));
    modal.show();
}
</script>
