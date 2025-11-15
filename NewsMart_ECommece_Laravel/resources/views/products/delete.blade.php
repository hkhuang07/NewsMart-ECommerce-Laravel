<div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content delete-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="deleteProductModalLabel">
                    <i class="fas fa-exclamation-triangle text-warning"></i>
                    Confirm Delete Product
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
                            Do you really want to delete the product 
                            <strong id="deleteProductNameToDelete" class="text-danger"></strong>?
                        </p>
                        
                        <div class="item-info-preview bg-light p-3 rounded mb-3" id="deleteProductPreview">
                            <div class="row">
                                <div class="col-4">
                                    <div class="preview-logo" id="deleteLogoPreview">
                                        <img id="deleteProductLogo" src="" alt="Product Logo" class="delete-preview-logo">
                                        <div id="deleteNoLogo" class="no-logo-placeholder">
                                            <i class="fas fa-building"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="preview-details text-start">
                                        <div class="preview-item" id="deleteEmailPreview">
                                            <small class="text-muted">Email:</small>
                                            <span id="deleteProductEmail"></span>
                                        </div>
                                        <div class="preview-item" id="deleteContactPreview">
                                            <small class="text-muted">Contact:</small>
                                            <span id="deleteProductContact"></span>
                                        </div>
                                        <div class="preview-item" id="deleteAddressPreview">
                                            <small class="text-muted">Address:</small>
                                            <span id="deleteProductAddress"></span>
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
        const deleteProductModal = document.getElementById('deleteProductModal');
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

        // Reset button state when modal is hidden
        deleteProductModal.addEventListener('hidden.bs.modal', function() {
            btnText.style.display = 'inline';
            btnLoading.style.display = 'none';
            deleteConfirmBtn.style.pointerEvents = 'auto';
        });
    });

    // Function to open delete modal with product data
    function openDeleteModal(productId, productData) {
        // Set product name
        document.getElementById('deleteProductNameToDelete').textContent = productData.name;
        
        // Set delete URL
        const deleteBtn = document.getElementById('deleteConfirmDeleteBtn');
        deleteBtn.href = `{{ route('product.delete', ['id' => '__ID__']) }}`.replace('__ID__', productId);
        
        // Populate product preview
        document.getElementById('deleteProductEmail').textContent = productData.email || 'N/A';
        document.getElementById('deleteProductContact').textContent = productData.contact || 'N/A';
        document.getElementById('deleteProductAddress').textContent = productData.address || 'N/A';
        
        // Handle logo preview
        const logoImg = document.getElementById('deleteProductLogo');
        const noLogoPlaceholder = document.getElementById('deleteNoLogo');
        
        if (productData.logo) {
            const logoUrl = `{{ asset('storage/app/private/') }}/${productData.logo}`;
            logoImg.src = logoUrl;
            logoImg.style.display = 'block';
            noLogoPlaceholder.style.display = 'none';
        } else {
            logoImg.style.display = 'none';
            noLogoPlaceholder.style.display = 'flex';
        }
        
        // Show modal
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteProductModal'));
        deleteModal.show();
    }
</script>