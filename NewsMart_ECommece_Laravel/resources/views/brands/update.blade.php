<div class="modal fade" id="updateBrandModal" tabindex="-1" aria-labelledby="updateBrandModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content brand-modal">
            <div class="modal-header brand-modal-header">
                <h5 class="modal-title" id="updateBrandModalLabel">
                    <i class="fa-light fa-edit"></i>
                    Edit Brand
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="updateModalMessages" class="mb-3" style="display: none;">
                    <div id="updateErrorMessage" class="alert alert-danger" style="display: none;"></div>
                    <div id="updateSuccessMessage" class="alert alert-success" style="display: none;"></div>
                </div>

                <form id="updateBrandForm" action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="updateBrandId" name="brand_id" value="">

                    <div class="form-group mb-4">
                        <label class="form-label" for="updateName">
                            <i class="fa-light fa-tag"></i>
                            Brand Name
                        </label>
                        <input
                            type="text"
                            class="form-control brand-input"
                            id="updateName"
                            name="name"
                            placeholder="Enter brand name"
                            required />
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="updateAddress">
                            <i class="fa-light fa-location-dot"></i>
                            Brand Address
                        </label>
                        <input
                            type="text"
                            class="form-control brand-input"
                            id="updateAddress"
                            name="address"
                            placeholder="Enter brand address" />
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="updateEmail">
                            <i class="fa-light fa-envelope"></i>
                            Brand Email
                        </label>
                        <input
                            type="email"
                            class="form-control brand-input"
                            id="updateEmail"
                            name="email"
                            placeholder="Enter brand email" />
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="updateContact">
                            <i class="fa-light fa-phone"></i>
                            Brand Contact
                        </label>
                        <input
                            type="text"
                            class="form-control brand-input"
                            id="updateContact"
                            name="contact"
                            placeholder="Enter contact number" />
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="updateDescription">
                            <i class="fa-light fa-file-text"></i>
                            Brand Description
                        </label>
                        <textarea
                            class="form-control brand-textarea"
                            id="updateDescription"
                            name="description"
                            rows="4"
                            placeholder="Enter brand description"></textarea>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="updateLogo">
                            <i class="fa-light fa-image"></i>
                            Brand Logo (Image file only)
                        </label>
                        <input
                            type="file"
                            class="form-control brand-input"
                            id="updateLogo"
                            name="logo"
                            accept="image/*" />
                        <small class="form-text text-muted">Leave empty to keep current logo</small>
                        <div class="invalid-feedback"></div>
                        
                        <!-- Current Logo Preview -->
                        <div id="currentLogoPreview" class="mt-3" style="display: none;">
                            <label class="form-label">Current Logo:</label>
                            <div class="current-logo-container">
                                <img id="currentLogoImage" src="" alt="Current Logo" class="current-logo-preview">
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer brand-modal-footer">
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">
                    <i class="fa-light fa-times"></i>
                    Cancel
                </button>
                <button type="submit" form="updateBrandForm" class="btn btn-action" id="updateSubmitBtn">
                    <i class="fa-light fa-save"></i>
                    <span class="btn-text">Update Brand</span>
                    <span class="btn-loading" style="display: none;">
                        <i class="fa-light fa-spinner fa-spin"></i>
                        Updating...
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.current-logo-preview {
    max-width: 100px;
    max-height: 100px;
    object-fit: contain;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 5px;
}

.current-logo-container {
    display: flex;
    align-items: center;
    gap: 10px;
}
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const updateBrandModal = document.getElementById('updateBrandModal');
        const updateBrandForm = document.getElementById('updateBrandForm');
        const updateSubmitBtn = document.getElementById('updateSubmitBtn');
        const btnText = updateSubmitBtn.querySelector('.btn-text');
        const btnLoading = updateSubmitBtn.querySelector('.btn-loading');

        // Reset form when modal is hidden
        updateBrandModal.addEventListener('hidden.bs.modal', function() {
            updateBrandForm.reset();

            // Clear validation errors
            const invalidInputs = updateBrandForm.querySelectorAll('.is-invalid');
            invalidInputs.forEach(input => {
                input.classList.remove('is-invalid');
            });
            const feedbacks = updateBrandForm.querySelectorAll('.invalid-feedback');
            feedbacks.forEach(feedback => {
                feedback.style.display = 'none';
                feedback.textContent = '';
            });

            // Hide messages
            document.getElementById('updateModalMessages').style.display = 'none';
            document.getElementById('updateErrorMessage').style.display = 'none';
            document.getElementById('updateSuccessMessage').style.display = 'none';
            
            // Hide current logo preview
            document.getElementById('currentLogoPreview').style.display = 'none';
            
            // Reset button state
            updateSubmitBtn.disabled = false;
            btnText.style.display = 'inline';
            btnLoading.style.display = 'none';
        });

        // Handle form submission
        updateBrandForm.addEventListener('submit', function(e) {
            // Show loading state
            updateSubmitBtn.disabled = true;
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline';
        });

        // Focus first input when modal is shown
        updateBrandModal.addEventListener('shown.bs.modal', function() {
            document.getElementById('updateName').focus();
        });
    });

    // Function to populate update modal with brand data
    function openUpdateModal(brandId, brandData) {
        // Set form action
        const updateForm = document.getElementById('updateBrandForm');
        updateForm.action = `{{ route('brand.update', ['id' => '__ID__']) }}`.replace('__ID__', brandId);
        
        // Set brand ID
        document.getElementById('updateBrandId').value = brandId;
        
        // Populate form fields
        document.getElementById('updateName').value = brandData.name || '';
        document.getElementById('updateAddress').value = brandData.address || '';
        document.getElementById('updateEmail').value = brandData.email || '';
        document.getElementById('updateContact').value = brandData.contact || '';
        document.getElementById('updateDescription').value = brandData.description || '';
        
        // Show current logo if exists
        const currentLogoPreview = document.getElementById('currentLogoPreview');
        const currentLogoImage = document.getElementById('currentLogoImage');
        
        if (brandData.logo) {
            const logoUrl = `{{ asset('storage/app/private/') }}/${brandData.logo}`;
            currentLogoImage.src = logoUrl;
            currentLogoPreview.style.display = 'block';
        } else {
            currentLogoPreview.style.display = 'none';
        }
        
        // Clear any previous validation errors
        const invalidInputs = updateForm.querySelectorAll('.is-invalid');
        invalidInputs.forEach(input => {
            input.classList.remove('is-invalid');
        });
        
        // Show modal
        const updateModal = new bootstrap.Modal(document.getElementById('updateBrandModal'));
        updateModal.show();
    }
</script>