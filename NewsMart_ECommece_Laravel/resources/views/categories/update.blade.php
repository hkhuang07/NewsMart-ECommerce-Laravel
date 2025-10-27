<div class="modal fade" id="updateCategoryModal" tabindex="-1" aria-labelledby="updateCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content brand-modal">
            <div class="modal-header brand-modal-header">
                <h5 class="modal-title" id="updateCategoryModalLabel">
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

                <form id="updateCategoryForm" action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="updateCategoryId" name="brand_id" value="">

                    <div class="form-group mb-4">
                        <label class="form-label" for="updateName">
                            <i class="fa-light fa-tag"></i>
                            Category Name
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
                        <label class="form-label" for="updateDescription">
                            <i class="fa-light fa-file-text"></i>
                            Category Description
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
                        <label class="form-label" for="description">
                            <i class="fa-light fa-file-text"></i>
                            Category Parent
                        </label>
                        <select class="form-select @error('parentid') is-invalid @enderror" id="parentid" name="parentid" >
                            <option value="">-- Chọn --</option>
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
                        <label class="form-label" for="updateLogo">
                            <i class="fa-light fa-image"></i>
                            Category Image (Image file only)
                        </label>
                        <input
                            type="file"
                            class="form-control brand-input"
                            id="updateLogo"
                            name="logo"
                            accept="image/*" />
                        <small class="form-text text-muted">Leave empty to keep current image</small>
                        <div class="invalid-feedback"></div>
                        
                        <!-- Current Logo Preview -->
                        <div id="currentLogoPreview" class="mt-3" style="display: none;">
                            <label class="form-label">Current Image:</label>
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
                <button type="submit" form="updateCategoryForm" class="btn btn-action" id="updateSubmitBtn">
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
        const updateCategoryModal = document.getElementById('updateCategoryModal');
        const updateCategoryForm = document.getElementById('updateCategoryForm');
        const updateSubmitBtn = document.getElementById('updateSubmitBtn');
        const btnText = updateSubmitBtn.querySelector('.btn-text');
        const btnLoading = updateSubmitBtn.querySelector('.btn-loading');

        updateCategoryModal.addEventListener('hidden.bs.modal', function() {
            updateCategoryForm.reset();

            const invalidInputs = updateCategoryForm.querySelectorAll('.is-invalid');
            invalidInputs.forEach(input => {
                input.classList.remove('is-invalid');
            });
            const feedbacks = updateCategoryForm.querySelectorAll('.invalid-feedback');
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

        updateCategoryForm.addEventListener('submit', function(e) {
            // Show loading state
            updateSubmitBtn.disabled = true;
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline';
        });

        updateCategoryModal.addEventListener('shown.bs.modal', function() {
            document.getElementById('updateName').focus();
        });
    });

    function openUpdateModal(categoryId, categoriesData) {
        const updateForm = document.getElementById('updateCategoryForm');
        updateForm.action = `{{ route('category.update', parameters: ['id' => '__ID__']) }}`.replace('__ID__', categoryId);
        
        document.getElementById('updateCategoryId').value = categoryId;
        
        document.getElementById('updateDescription').value = categoriesData.description || '';
        
        const currentLogoPreview = document.getElementById('currentLogoPreview');
        const currentLogoImage = document.getElementById('currentLogoImage');
        
        if (categoriesData.logo) {
            const logoUrl = `{{ asset('storage/app/private/') }}/${categoriesData.image}`;
            currentLogoImage.src = logoUrl;
            currentLogoPreview.style.display = 'block';
        } else {
            currentLogoPreview.style.display = 'none';
        }
        
        const invalidInputs = updateForm.querySelectorAll('.is-invalid');
        invalidInputs.forEach(input => {
            input.classList.remove('is-invalid');
        });
        
        const updateModal = new bootstrap.Modal(document.getElementById('updateCategoryModal'));
        updateModal.show();
    }
</script>