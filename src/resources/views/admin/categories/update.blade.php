<div class="modal fade" id="updateBrandModal" tabindex="-1" aria-labelledby="updateBrandModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content item-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="updateBrandModalLabel">
                    <i class="fa-light fa-edit"></i>
                    Edit Category
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
                            Category Name
                        </label>
                        <input
                            type="text"
                            class="form-control item-input"
                            id="updateName"
                            name="name"
                            placeholder="Enter category name" {{ old('name') }}
                            required />
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group mb-4">
                        <label class="form-label" for="parentid">
                            <i class="fa-light fa-tag"></i>
                            Category Parent
                        </label>
                        <select class="form-select @error('parentid') is-invalid @enderror" id="parentid" name="parentid" >
                            <option value="">-- Choose --</option>
                            @foreach($categories as $value)
                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                            @endforeach
                            </select>
                        @error('description')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
            
                    <div class="form-group mb-4">
                        <label class="form-label" for="updateDescription">
                            <i class="fa-light fa-file-text"></i>
                            Category Description
                        </label>
                        <textarea
                            class="form-control item-textarea"
                            id="updateDescription"
                            name="description"
                            rows="4"
                            placeholder="Enter brand description">{{ old('description') }}</textarea>
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="updateLogo">
                            <i class="fa-light fa-image"></i>
                            Category Logo (Image file only)
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
                <button type="submit" form="updateBrandForm" class="btn btn-action" id="updateSubmitBtn">
                    <i class="fa-light fa-save"></i>
                    <span class="btn-text">Update Category</span>
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
        const updateBrandModal = document.getElementById('updateBrandModal');
        const updateBrandForm = document.getElementById('updateBrandForm');
        const updateSubmitBtn = document.getElementById('updateSubmitBtn');
        const btnText = updateSubmitBtn.querySelector('.btn-text');
        const btnLoading = updateSubmitBtn.querySelector('.btn-loading');

        updateBrandModal.addEventListener('hidden.bs.modal', function() {
            updateBrandForm.reset();

            const invalidInputs = updateBrandForm.querySelectorAll('.is-invalid');
            invalidInputs.forEach(input => {
                input.classList.remove('is-invalid');
            });
            const feedbacks = updateBrandForm.querySelectorAll('.invalid-feedback');
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

        updateBrandForm.addEventListener('submit', function(e) {
            // Show loading state
            updateSubmitBtn.disabled = true;
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline';
        });

        updateBrandModal.addEventListener('shown.bs.modal', function() {
            document.getElementById('updateName').focus();
        });
    });

    function openUpdateModal(brandId, brandData) {
        const updateForm = document.getElementById('updateBrandForm');
        updateForm.action = `{{ route('admin.category.update', ['id' => '__ID__']) }}`.replace('__ID__', brandId);
        
        document.getElementById('updateBrandId').value = brandId;
        
        document.getElementById('updateName').value = brandData.name || '';
        
        document.getElementById('parentid').value = brandData.parentid || '';
        document.getElementById('updateDescription').value = brandData.description || '';
        
        const currentLogoPreview = document.getElementById('currentLogoPreview');
        const currentLogoImage = document.getElementById('currentLogoImage');
        
        if (brandData.image) {
            const logoUrl = `{{ asset('storage/app/private/') }}/${brandData.image}`;
            currentLogoImage.src = logoUrl;
            currentLogoPreview.style.display = 'block';
        } else {
            currentLogoPreview.style.display = 'none';
        }
        
        const invalidInputs = updateForm.querySelectorAll('.is-invalid');
        invalidInputs.forEach(input => {
            input.classList.remove('is-invalid');
        });
        
        const updateModal = new bootstrap.Modal(document.getElementById('updateBrandModal'));
        updateModal.show();
    }
</script>