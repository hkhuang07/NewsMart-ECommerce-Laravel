<div class="modal fade" id="addReviewModal" tabindex="-1" aria-labelledby="addReviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content item-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="addReviewModalLabel">
                    <i class="fa-light fa-plus-circle"></i>
                    Add New Review
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="modalMessages" class="mb-3" style="display: none;">
                    <div id="errorMessage" class="alert alert-danger" style="display: none;"></div>
                    <div id="successMessage" class="alert alert-success" style="display: none;"></div>
                </div>

                <form id="addReviewForm" action="{{ route('admin.review.add') }}" method="post">
                    @csrf

                    <!-- User ID -->
                    <div class="form-group mb-4">
                        <label class="form-label" for="userid">
                            <i class="fa-light fa-user"></i>
                            User ID
                        </label>
                        <input type="number" class="form-control item-input @error('userid') is-invalid @enderror"
                            id="userid" name="userid" value="{{ old('userid') }}" placeholder="Enter user ID"
                            required />
                        @error('userid')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>

                    <!-- Product ID -->
                    <div class="form-group mb-4">
                        <label class="form-label" for="productid">
                            <i class="fa-light fa-box"></i>
                            Product ID
                        </label>
                        <input type="number" class="form-control item-input @error('productid') is-invalid @enderror"
                            id="productid" name="productid" value="{{ old('productid') }}"
                            placeholder="Enter product ID" required />
                        @error('productid')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>

                    <!-- Order ID -->
                    <div class="form-group mb-4">
                        <label class="form-label" for="orderid">
                            <i class="fa-light fa-receipt"></i>
                            Order ID
                        </label>
                        <input type="number" class="form-control item-input @error('orderid') is-invalid @enderror"
                            id="orderid" name="orderid" value="{{ old('orderid') }}" placeholder="Enter order ID" />
                        @error('orderid')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>

                    <!-- Rating -->
                    <div class="form-group mb-4">
                        <label class="form-label" for="rating">
                            <i class="fa-light fa-star"></i>
                            Rating
                        </label>
                        <input type="number" class="form-control item-input @error('rating') is-invalid @enderror"
                            id="rating" name="rating" value="{{ old('rating') }}" placeholder="Enter rating (1-5)"
                            min="1" max="5" required />
                        @error('rating')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>

                    <!-- Content -->
                    <div class="form-group mb-4">
                        <label class="form-label" for="content">
                            <i class="fa-light fa-comment"></i>
                            Content
                        </label>
                        <textarea class="form-control item-textarea @error('content') is-invalid @enderror" id="content"
                            name="content" rows="4" placeholder="Enter review content">{{ old('content') }}</textarea>
                        @error('content')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="form-group mb-4">
                        <label class="form-label" for="status">
                            <i class="fa-light fa-info-circle"></i>
                            Status
                        </label>
                        <select class="form-control item-input @error('status') is-invalid @enderror" id="status"
                            name="status" required>
                            <option value="Pending" {{ old('status')=='Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Approved" {{ old('status')=='Approved' ? 'selected' : '' }}>Approved</option>
                            <option value="Rejected" {{ old('status')=='Rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                        @error('status')
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
                <button type="submit" form="addReviewForm" class="btn btn-action" id="submitBtn">
                    <i class="fa-light fa-save"></i>
                    <span class="btn-text">Add Review</span>
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
        const addReviewModal = document.getElementById('addReviewModal');
        const addReviewForm = document.getElementById('addReviewForm');
        const submitBtn = document.getElementById('submitBtn');
        const btnText = submitBtn.querySelector('.btn-text');
        const btnLoading = submitBtn.querySelector('.btn-loading');

        addReviewModal.addEventListener('hidden.bs.modal', function() {
            addReviewForm.reset();
            const invalidInputs = addReviewForm.querySelectorAll('.is-invalid');
            invalidInputs.forEach(input => input.classList.remove('is-invalid'));
            const feedbacks = addReviewForm.querySelectorAll('.invalid-feedback');
            feedbacks.forEach(fb => fb.style.display = 'none');
            document.getElementById('modalMessages').style.display = 'none';
            document.getElementById('errorMessage').style.display = 'none';
            document.getElementById('successMessage').style.display = 'none';
            submitBtn.disabled = false;
            btnText.style.display = 'inline';
            btnLoading.style.display = 'none';
        });

        addReviewForm.addEventListener('submit', function(e) {
            submitBtn.disabled = true;
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline';
        });

        addReviewModal.addEventListener('shown.bs.modal', function() {
            document.getElementById('userid').focus();
        });
    });
</script>