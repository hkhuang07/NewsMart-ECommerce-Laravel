<div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-labelledby="deleteCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content delete-modal">
            <div class="modal-header category-modal-header">
                <h5 class="modal-title" id="deleteCategoryModalLabel">
                    <i class="fas fa-exclamation-triangle text-warning"></i>
                    Confirm Delete Brand
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
                            Do you really want to delete the category 
                            <strong id="deleteCategoryNameToDelete" class="text-danger"></strong>?
                        </p>
                        
                        <div class="category-info-preview bg-light p-3 rounded mb-3" id="deleteBrandPreview">
                            <div class="row">
                                <div class="col-4">
                                    <div class="preview-logo" id="deleteLogoPreview">
                                        <img id="deleteCategoryImage" src="" alt="Brand Logo" class="delete-preview-logo">
                                        <div id="deleteNoLogo" class="no-logo-placeholder">
                                            <i class="fas fa-building"></i>
                                        </div>
                                    </div>
                                </div>
                            
                            </div>
                        </div>
                        
                        <small class="warning-text text-muted">
                            <i class="fas fa-exclamation-circle"></i>
                            This action cannot be undone and may affect related products.
                        </small>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer category-modal-footer">
                <button type="button" class="btn btn-cancel me-3" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i>
                    Cancel
                </button>
                <a href="#" id="deleteConfirmDeleteBtn" class="btn btn-delete">
                    <i class="fas fa-trash-alt"></i>
                    <span class="btn-text">Yes, Delete It</span>
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
        const deleteCategoryModal = document.getElementById('deleteCategoryModal');
        const deleteConfirmBtn = document.getElementById('deleteConfirmDeleteBtn');
        const btnText = deleteConfirmBtn.querySelector('.btn-text');
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
        deleteCategoryModal.addEventListener('hidden.bs.modal', function() {
            btnText.style.display = 'inline';
            btnLoading.style.display = 'none';
            deleteConfirmBtn.style.pointerEvents = 'auto';
        });
    });

    // Function to open delete modal with category data
    function openDeleteModal(categoryId, categoryData) {
        // Set category name
        document.getElementById('deleteCategoryNameToDelete').textContent = categoryData.name;
        
        // Set delete URL
        const deleteBtn = document.getElementById('deleteConfirmDeleteBtn');
        deleteBtn.href = `{{ route('category.delete', ['id' => '__ID__']) }}`.replace('__ID__', categoryId);
        
        // Populate category preview
        
        // Handle logo preview
        const logoImg = document.getElementById('deleteCategoryImage');
        const noLogoPlaceholder = document.getElementById('deleteNoLogo');
        
        if (categoryData.logo) {
            const logoUrl = `{{ asset('storage/app/private/') }}/${categoryData.logo}`;
            logoImg.src = logoUrl;
            logoImg.style.display = 'block';
            noLogoPlaceholder.style.display = 'none';
        } else {
            logoImg.style.display = 'none';
            noLogoPlaceholder.style.display = 'flex';
        }
        
        // Show modal
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteCategoryModal'));
        deleteModal.show();
    }
</script>