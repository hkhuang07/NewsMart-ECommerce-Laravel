<div class="modal fade" id="updateReviewModal" tabindex="-1" aria-labelledby="updateReviewModalLabel" aria-hidden="true">
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

                <form id="updateReviewForm" action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="updateReviewId" name="review_id" value="">

                    <div class="form-group mb-4">
                        <label class="form-label" for="updateName">
                            <i class="fa-light fa-tag"></i>
                            Review Name
                        </label>
                        <input
                            type="text"
                            class="form-control item-input"
                            id="updateName"
                            name="name"
                            placeholder="Enter review name"
                            required />
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="updateAddress">
                            <i class="fa-light fa-location-dot"></i>
                            Review Address
                        </label>
                        <input
                            type="text"
                            class="form-control item-input"
                            id="updateAddress"
                            name="address"
                            placeholder="Enter review address" />
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="updateEmail">
                            <i class="fa-light fa-envelope"></i>
                            Review Email
                        </label>
                        <input
                            type="email"
                            class="form-control item-input"
                            id="updateEmail"
                            name="email"
                            placeholder="Enter review email" />
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="updateContact">
                            <i class="fa-light fa-phone"></i>
                            Review Contact
                        </label>
                        <input
                            type="text"
                            class="form-control item-input"
                            id="updateContact"
                            name="contact"
                            placeholder="Enter contact number" />
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="updateDescription">
                            <i class="fa-light fa-file-text"></i>
                            Review Description
                        </label>
                        <textarea
                            class="form-control item-textarea"
                            id="updateDescription"
                            name="description"
                            rows="4"
                            placeholder="Enter review description"></textarea>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="updateLogo">
                            <i class="fa-light fa-image"></i>
                            Review Logo (Image file only)
                        </label>
                        <input
                            type="file"
                            class="form-control item-input"
                            id="updateLogo"
                            name="logo"
                            accept="image/*" />
                        <small class="form-text text-muted">Leave empty to keep current logo</small>
                        <div class="invalid-feedback"></div>
                        
                        <div id="currentLogoPreview" class="mt-3" style="display: none;">
                            <label class="form-label">Current Logo:</label>
                            <div class="current-logo-container">
                                <img id="currentLogoImage" src="" alt="Current Logo" class="current-logo-preview">
                            </div>
                        </div>
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

        updateReviewModal.addEventListener('hidden.bs.modal', function() {
            updateReviewForm.reset();

            const invalidInputs = updateReviewForm.querySelectorAll('.is-invalid');
            invalidInputs.forEach(input => {
                input.classList.remove('is-invalid');
            });
            const feedbacks = updateReviewForm.querySelectorAll('.invalid-feedback');
            feedbacks.forEach(feedback => {
                feedback.style.display = 'none';
                feedback.textContent = '';
            });

            document.getElementById('updateModalMessages').style.display = 'none';
            document.getElementById('updateErrorMessage').style.display = 'none';
            document.getElementById('updateSuccessMessage').style.display = 'none';
            
            document.getElementById('currentLogoPreview').style.display = 'none';
            
            updateSubmitBtn.disabled = false;
            btnText.style.display = 'inline';
            btnLoading.style.display = 'none';
        });

        updateReviewForm.addEventListener('submit', function(e) {
            // Show loading state
            updateSubmitBtn.disabled = true;
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline';
        });

        updateReviewModal.addEventListener('shown.bs.modal', function() {
            document.getElementById('updateName').focus();
        });
    });

    function openUpdateModal(reviewId, reviewData) {
        const updateForm = document.getElementById('updateReviewForm');
        updateForm.action = `{{ route('review.update', ['id' => '__ID__']) }}`.replace('__ID__', reviewId);
        
        document.getElementById('updateReviewId').value = reviewId;
        
        document.getElementById('updateName').value = reviewData.name || '';
        document.getElementById('updateAddress').value = reviewData.address || '';
        document.getElementById('updateEmail').value = reviewData.email || '';
        document.getElementById('updateContact').value = reviewData.contact || '';
        document.getElementById('updateDescription').value = reviewData.description || '';
        
        const currentLogoPreview = document.getElementById('currentLogoPreview');
        const currentLogoImage = document.getElementById('currentLogoImage');
        
        if (reviewData.logo) {
            const logoUrl = `{{ asset('storage/app/private/') }}/${reviewData.logo}`;
            currentLogoImage.src = logoUrl;
            currentLogoPreview.style.display = 'block';
        } else {
            currentLogoPreview.style.display = 'none';
        }
        
        const invalidInputs = updateForm.querySelectorAll('.is-invalid');
        invalidInputs.forEach(input => {
            input.classList.remove('is-invalid');
        });
        
        const updateModal = new bootstrap.Modal(document.getElementById('updateReviewModal'));
        updateModal.show();
    }
</script>