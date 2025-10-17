<div class="modal fade" id="deleteOrderStatusModal" tabindex="-1" aria-labelledby="deleteOrderStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content delete-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="deleteOrderStatusModalLabel">
                    <i class="fas fa-exclamation-triangle text-warning"></i>
                    Confirm Delete Order Status
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
                            Do you really want to delete the order status 
                            <strong id="deleteStatusNameToDelete" class="text-danger"></strong>?
                        </p>
                        
                        <div class="item-info-preview bg-light p-3 rounded mb-3" id="deleteStatusPreview">
                            <div class="preview-details text-start">
                                <div class="preview-item mb-2">
                                    <small class="text-muted">Description:</small>
                                    <span id="deleteStatusDescription"></span>
                                </div>
                            </div>
                        </div>
                        
                        <small class="warning-text text-muted">
                            <i class="fas fa-exclamation-circle"></i>
                            This action cannot be undone and may affect related orders.
                        </small>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer item-modal-footer">
                <button type="button" class="btn btn-cancel me-3" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i>
                    Cancel
                </button>
                <a href="#" id="deleteConfirmDeleteBtn" class="btn btn-delete">
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
    const deleteStatusModal = document.getElementById('deleteOrderStatusModal');
    const deleteConfirmBtn = document.getElementById('deleteConfirmDeleteBtn');
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

    // Reset button when modal is hidden
    deleteStatusModal.addEventListener('hidden.bs.modal', function() {
        btnText.style.display = 'inline';
        btnLoading.style.display = 'none';
        deleteConfirmBtn.style.pointerEvents = 'auto';
    });
});

// Function to open delete modal with order status data
function openDeleteStatusModal(statusId, statusData) {
    // Set status name
    document.getElementById('deleteStatusNameToDelete').textContent = statusData.name;

    // Set delete URL
    const deleteBtn = document.getElementById('deleteConfirmDeleteBtn');
    deleteBtn.href = `<?php echo e(route('order_statuses.delete', ['id' => '__ID__'])); ?>`.replace('__ID__', statusId);

    // Populate status preview
    document.getElementById('deleteStatusDescription').textContent = statusData.description || 'No description provided';

    // Show modal
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteOrderStatusModal'));
    deleteModal.show();
}
</script>
<?php /**PATH C:\wamp64\www\Project\NewsMart_ECommece_Laravel\resources\views/order_statuses/delete.blade.php ENDPATH**/ ?>