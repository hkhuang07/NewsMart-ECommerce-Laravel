<div class="modal fade" id="updateReviewModal" tabindex="-1" aria-labelledby="updateReviewModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content item-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="updateReviewModalLabel">
                    <i class="fa-light fa-edit"></i>
                    Edit Review
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="updateModalMessages" class="mb-3" style="display: none;">
                    <div id="updateErrorMessage" class="alert alert-danger" style="display: none;"></div>
                    <div id="updateSuccessMessage" class="alert alert-success" style="display: none;"></div>
                </div>

                <form id="updateReviewForm" action="" method="post">
                    @csrf
                    <input type="hidden" id="updateReviewId" name="review_id" value="">

                    <div class="form-group mb-4">
                        <label class="form-label" for="updateUserId">
                            <i class="fa-light fa-user"></i>
                            User ID
                        </label>
                        <input type="number" class="form-control item-input" id="updateUserId" name="userid"
                            placeholder="Enter user ID" required />
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="updateProductId">
                            <i class="fa-light fa-box"></i>
                            Product ID
                        </label>
                        <input type="number" class="form-control item-input" id="updateProductId" name="productid"
                            placeholder="Enter product ID" required />
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="updateOrderId">
                            <i class="fa-light fa-receipt"></i>
                            Order ID
                        </label>
                        <input type="number" class="form-control item-input" id="updateOrderId" name="orderid"
                            placeholder="Enter order ID (optional)" />
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="updateRating">
                            <i class="fa-light fa-star"></i>
                            Rating
                        </label>
                        <input type="number" class="form-control item-input" id="updateRating" name="rating"
                            placeholder="Enter rating (1–5)" min="1" max="5" required />
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="updateContent">
                            <i class="fa-light fa-comment"></i>
                            Review Content
                        </label>
                        <textarea class="form-control item-textarea" id="updateContent" name="content" rows="4"
                            placeholder="Enter review content"></textarea>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="updateStatus">
                            <i class="fa-light fa-flag"></i>
                            Status
                        </label>
                        <select class="form-control item-input" id="updateStatus" name="status" required>
                            <option value="Pending">Pending</option>
                            <option value="Approved">Approved</option>
                            <option value="Rejected">Rejected</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>
                </form>
            </div>

            <div class="modal-footer item-modal-footer">
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">
                    <i class="fa-light fa-times"></i>
                    Cancel
                </button>
                <button type="submit" form="updateReviewForm" class="btn btn-action" id="updateSubmitBtn">
                    <i class="fa-light fa-save"></i>
                    <span class="btn-text">Update Review</span>
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
        const updateReviewModal = document.getElementById('updateReviewModal');
        const updateReviewForm = document.getElementById('updateReviewForm');
        const updateSubmitBtn = document.getElementById('updateSubmitBtn');
        const btnText = updateSubmitBtn.querySelector('.btn-text');
        const btnLoading = updateSubmitBtn.querySelector('.btn-loading');

        // Reset form when modal hidden
        updateReviewModal.addEventListener('hidden.bs.modal', function() {
            updateReviewForm.reset();

            updateReviewForm.querySelectorAll('.is-invalid').forEach(input => input.classList.remove('is-invalid'));
            updateReviewForm.querySelectorAll('.invalid-feedback').forEach(fb => {
                fb.style.display = 'none';
                fb.textContent = '';
            });

            document.getElementById('updateModalMessages').style.display = 'none';
            document.getElementById('updateErrorMessage').style.display = 'none';
            document.getElementById('updateSuccessMessage').style.display = 'none';

            updateSubmitBtn.disabled = false;
            btnText.style.display = 'inline';
            btnLoading.style.display = 'none';
        });

        // Loading animation
        updateReviewForm.addEventListener('submit', function() {
            updateSubmitBtn.disabled = true;
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline';
        });

        updateReviewModal.addEventListener('shown.bs.modal', function() {
            document.getElementById('updateUserId').focus();
        });
    });

    // Hàm mở modal update với dữ liệu review
    function openUpdateReviewModal(reviewId, reviewData) {
        const updateForm = document.getElementById('updateReviewForm');
        updateForm.action = `{{ route('admin.review.update', ['id' => '__ID__']) }}`.replace('__ID__', reviewId);

        document.getElementById('updateReviewId').value = reviewId;
        document.getElementById('updateUserId').value = reviewData.userid || '';
        document.getElementById('updateProductId').value = reviewData.productid || '';
        document.getElementById('updateOrderId').value = reviewData.orderid || '';
        document.getElementById('updateRating').value = reviewData.rating || '';
        document.getElementById('updateContent').value = reviewData.content || '';
        document.getElementById('updateStatus').value = reviewData.status || 'Pending';

        const updateModal = new bootstrap.Modal(document.getElementById('updateReviewModal'));
        updateModal.show();
    }
</script>