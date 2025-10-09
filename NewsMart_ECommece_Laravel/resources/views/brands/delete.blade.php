<div class="modal fade" id="deleteBrandModal" tabindex="-1" aria-labelledby="deleteBrandModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content delete-modal">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteBrandModalLabel">
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
                            Do you really want to delete the brand 
                            <strong id="deleteBrandNameToDelete" class="text-danger"></strong>?
                        </p>
                        
                        <div class="brand-info-preview bg-light p-3 rounded mb-3" id="delet eBrandPreview">
                            <div class="row">
                                <div class="col-4">
                                    <div class="preview-logo" id="deleteLogoPreview">
                                        <img id="deleteBrandLogo" src="" alt="Brand Logo" class="delete-preview-logo">
                                        <div id="deleteNoLogo" class="no-logo-placeholder">
                                            <i class="fas fa-building"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="preview-details text-start">
                                        <div class="preview-item" id="deleteEmailPreview">
                                            <small class="text-muted">Email:</small>
                                            <span id="deleteBrandEmail"></span>
                                        </div>
                                        <div class="preview-item" id="deleteContactPreview">
                                            <small class="text-muted">Contact:</small>
                                            <span id="deleteBrandContact"></span>
                                        </div>
                                        <div class="preview-item" id="deleteAddressPreview">
                                            <small class="text-muted">Address:</small>
                                            <span id="deleteBrandAddress"></span>
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
            
            <div class="modal-footer justify-content-center">
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

<style>
.delete-modal .modal-content {
    border: none;
    box-shadow: 0 10px 40px rgba(0,0,0,0.15);
    border-radius: 15px;
}

.delete-icon-container {
    width: 80px;
    height: 80px;
    margin: 0 auto;
    background: linear-gradient(135deg, #fee2e2, #fecaca);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.delete-icon {
    font-size: 2rem;
    color: #dc2626;
}

.delete-title {
    color: #374151;
    font-weight: 600;
}

.delete-message {
    color: #6b7280;
    line-height: 1.6;
}

.warning-text {
    color: #9ca3af !important;
    font-size: 0.875rem;
}

.btn-cancel {
    background-color: #f3f4f6;
    color: #374151;
    border: 1px solid #d1d5db;
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.2s ease;
}

.btn-cancel:hover {
    background-color: #e5e7eb;
    color: #111827;
    border-color: #9ca3af;
}

.btn-delete {
    background: linear-gradient(135deg, #dc2626, #b91c1c);
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.btn-delete:hover {
    background: linear-gradient(135deg, #b91c1c, #991b1b);
    color: white;
    text-decoration: none;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
}

.brand-info-preview {
    border: 1px solid #e5e7eb;
    background-color: #f9fafb !important;
}

.delete-preview-logo {
    width: 60px;
    height: 60px;
    object-fit: contain;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
}

.no-logo-placeholder {
    width: 60px;
    height: 60px;
    background-color: #f3f4f6;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #9ca3af;
    font-size: 1.5rem;
}

.preview-details {
    font-size: 0.875rem;
}

.preview-item {
    margin-bottom: 4px;
    word-break: break-word;
}

.preview-item small {
    display: inline-block;
    width: 60px;
    font-weight: 500;
}
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteBrandModal = document.getElementById('deleteBrandModal');
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
        deleteBrandModal.addEventListener('hidden.bs.modal', function() {
            btnText.style.display = 'inline';
            btnLoading.style.display = 'none';
            deleteConfirmBtn.style.pointerEvents = 'auto';
        });
    });

    // Function to open delete modal with brand data
    function openDeleteModal(brandId, brandData) {
        // Set brand name
        document.getElementById('deleteBrandNameToDelete').textContent = brandData.name;
        
        // Set delete URL
        const deleteBtn = document.getElementById('deleteConfirmDeleteBtn');
        deleteBtn.href = `{{ route('brand.delete', ['id' => '__ID__']) }}`.replace('__ID__', brandId);
        
        // Populate brand preview
        document.getElementById('deleteBrandEmail').textContent = brandData.email || 'N/A';
        document.getElementById('deleteBrandContact').textContent = brandData.contact || 'N/A';
        document.getElementById('deleteBrandAddress').textContent = brandData.address || 'N/A';
        
        // Handle logo preview
        const logoImg = document.getElementById('deleteBrandLogo');
        const noLogoPlaceholder = document.getElementById('deleteNoLogo');
        
        if (brandData.logo) {
            const logoUrl = `{{ asset('storage/app/private/') }}/${brandData.logo}`;
            logoImg.src = logoUrl;
            logoImg.style.display = 'block';
            noLogoPlaceholder.style.display = 'none';
        } else {
            logoImg.style.display = 'none';
            noLogoPlaceholder.style.display = 'flex';
        }
        
        // Show modal
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteBrandModal'));
        deleteModal.show();
    }
</script>