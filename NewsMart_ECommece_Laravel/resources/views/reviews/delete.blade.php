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
                        <i class="fas fa-comment-dots delete-icon"></i>
                    </div>

                    <h4 class="delete-title mb-3">Are you sure?</h4>

                    <div class="delete-message mb-4">
                        <p class="mb-2">
                            Do you really want to delete this review by
                            <strong id="deleteReviewUserName" class="text-danger"></strong>?
                        </p>

                        <div class="item-info-preview bg-light p-3 rounded mb-3" id="deleteReviewPreview">
                            <div class="text-start">
                                <div class="preview-item mb-1">
                                    <small class="text-muted">Product:</small>
                                    <span id="deleteReviewProduct"></span>
                                </div>
                                <div class="preview-item mb-1">
                                    <small class="text-muted">Rating:</small>
                                    <span id="deleteReviewRating"></span>
                                </div>
                                <div class="preview-item mb-1">
                                    <small class="text-muted">Comment:</small>
                                    <span id="deleteReviewComment"></span>
                                </div>
                            </div>
                        </div>

                        <small class="warning-text text-muted">
                            <i class="fas fa-exclamation-circle"></i>
                            This action cannot be undone and will permanently remove the review.
                        </small>
                    </div>
                </div>
            </div>

            <div class="modal-footer item-modal-footer">
                <button type="button" class="btn btn-cancel me-3" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i>
                    Cancel
                </button>
                <a href="#" id="deleteConfirmDeleteReviewBtn" class="btn btn-delete">
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
        const deleteConfirmBtn = document.getElementById('deleteConfirmDeleteReviewBtn');
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

        // Reset button state when modal is hidden
        deleteReviewModal.addEventListener('hidden.bs.modal', function() {
            btnText.style.display = 'inline';
            btnLoading.style.display = 'none';
            deleteConfirmBtn.style.pointerEvents = 'auto';
        });
    });

    // Function to open delete modal with review data
    function openDeleteReviewModal(reviewId, reviewData) {
        // Set user name
        document.getElementById('deleteReviewUserName').textContent = reviewData.user_name || 'Unknown User';
        
        // Set delete URL
        const deleteBtn = document.getElementById('deleteConfirmDeleteReviewBtn');
        deleteBtn.href = `{{ route('review.delete', ['id' => '__ID__']) }}`.replace('__ID__', reviewId);
        
        // Populate review preview
        document.getElementById('deleteReviewProduct').textContent = reviewData.product_name || 'N/A';
        document.getElementById('deleteReviewRating').textContent = reviewData.rating ? reviewData.rating + '/5' : 'N/A';
        document.getElementById('deleteReviewComment').textContent = reviewData.comment || 'No comment';
        
        // Show modal
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteReviewModal'));
        deleteModal.show();
    }
</script>