<div class="modal fade" id="deleteReviewModal" tabindex="-1" aria-labelledby="deleteReviewModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content delete-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="deleteReviewModalLabel">
                    <i class="fas fa-exclamation-triangle text-warning"></i>
                    Confirm Delete Review
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
                            Do you really want to delete this review with ID
                            <strong id="deleteReviewIdToDelete" class="text-danger"></strong>?
                        </p>

                        <div class="item-info-preview bg-light p-3 rounded mb-3" id="deleteReviewPreview">
                            <div class="text-start">
                                <div class="preview-item mb-1">
                                    <small class="text-muted">User ID:</small>
                                    <span id="deleteReviewUserId"></span>
                                </div>
                                <div class="preview-item mb-1">
                                    <small class="text-muted">Product ID:</small>
                                    <span id="deleteReviewProductId"></span>
                                </div>
                                <div class="preview-item mb-1">
                                    <small class="text-muted">Order ID:</small>
                                    <span id="deleteReviewOrderId"></span>
                                </div>
                                <div class="preview-item mb-1">
                                    <small class="text-muted">Rating:</small>
                                    <span id="deleteReviewRating"></span>
                                </div>
                                <div class="preview-item mb-2">
                                    <small class="text-muted">Content:</small>
                                    <span id="deleteReviewContent"></span>
                                </div>
                                <div class="preview-item mb-2">
                                    <small class="text-muted">Status:</small>
                                    <span id="deleteReviewStatus"></span>
                                </div>
                            </div>
                        </div>

                        <small class="warning-text text-muted">
                            <i class="fas fa-exclamation-circle"></i>
                            This action cannot be undone and may affect product feedback statistics.
                        </small>
                    </div>
                </div>
            </div>

            <div class="modal-footer item-modal-footer">
                <button type="button" class="btn btn-cancel me-3" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i>
                    Cancel
                </button>
                <a href="#" id="deleteConfirmReviewBtn" class="btn btn-delete">
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
        const deleteReviewModal = document.getElementById('deleteReviewModal');
        const deleteConfirmBtn = document.getElementById('deleteConfirmReviewBtn');
        const btnText = deleteConfirmBtn.querySelector('span:not(.btn-loading)');
        const btnLoading = deleteConfirmBtn.querySelector('.btn-loading');

        deleteConfirmBtn.addEventListener('click', function(e) {
            e.preventDefault();
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline';
            deleteConfirmBtn.style.pointerEvents = 'none';
            window.location.href = this.href;
        });

        deleteReviewModal.addEventListener('hidden.bs.modal', function() {
            btnText.style.display = 'inline';
            btnLoading.style.display = 'none';
            deleteConfirmBtn.style.pointerEvents = 'auto';
        });
    });

    function openDeleteReviewModal(reviewId, reviewData) {
        document.getElementById('deleteReviewIdToDelete').textContent = reviewId;
        const deleteBtn = document.getElementById('deleteConfirmReviewBtn');
        deleteBtn.href = `{{ route('review.delete', ['id' => '__ID__']) }}`.replace('__ID__', reviewId);

        // Populate review info
        document.getElementById('deleteReviewUserId').textContent = reviewData.userid || 'N/A';
        document.getElementById('deleteReviewProductId').textContent = reviewData.productid || 'N/A';
        document.getElementById('deleteReviewOrderId').textContent = reviewData.orderid || 'N/A';
        document.getElementById('deleteReviewRating').textContent = reviewData.rating || 'N/A';
        document.getElementById('deleteReviewContent').textContent = reviewData.content || 'N/A';
        document.getElementById('deleteReviewStatus').textContent = reviewData.status || 'N/A';

        const deleteModal = new bootstrap.Modal(document.getElementById('deleteReviewModal'));
        deleteModal.show();
    }
</script>