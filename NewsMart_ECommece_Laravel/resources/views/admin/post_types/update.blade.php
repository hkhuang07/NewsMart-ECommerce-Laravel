<div class="modal fade" id="updatePostTypeModal" tabindex="-1" aria-labelledby="updatePostTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content item-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="updatePostTypeModalLabel">
                    <i class="fa-light fa-edit"></i>
                    Edit PostType
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="updateModalMessages" class="mb-3" style="display: none;">
                    <div id="updateErrorMessage" class="alert alert-danger" style="display: none;"></div>
                    <div id="updateSuccessMessage" class="alert alert-success" style="display: none;"></div>
                </div>

                <form id="updatePostTypeForm" action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="updatePostTypeId" name="post_type_id" value="">

                    <div class="form-group mb-4">
                        <label class="form-label" for="updateName">
                            <i class="fa-light fa-tag"></i>
                            PostType Name
                        </label>
                        <input
                            type="text"
                            class="form-control item-input"
                            id="updateName"
                            name="name"
                            placeholder="Enter post_type name"
                            required />
                        <div class="invalid-feedback"></div>
                    </div>

   

                    <div class="form-group mb-4">
                        <label class="form-label" for="updateDescription">
                            <i class="fa-light fa-file-text"></i>
                            PostType Description
                        </label>
                        <textarea
                            class="form-control item-textarea"
                            id="updateDescription"
                            name="description"
                            rows="4"
                            placeholder="Enter post_type description"></textarea>
                        <div class="invalid-feedback"></div>
                    </div>

               
                </form>
            </div>

            <div class="modal-footer item-modal-footer">
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">
                    <i class="fa-light fa-times"></i>
                    Cancel
                </button>
                <button type="submit" form="updatePostTypeForm" class="btn btn-action" id="updateSubmitBtn">
                    <i class="fa-light fa-save"></i>
                    <span class="btn-text">Update PostType</span>
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
        const updatePostTypeModal = document.getElementById('updatePostTypeModal');
        const updatePostTypeForm = document.getElementById('updatePostTypeForm');
        const updateSubmitBtn = document.getElementById('updateSubmitBtn');
        const btnText = updateSubmitBtn.querySelector('.btn-text');
        const btnLoading = updateSubmitBtn.querySelector('.btn-loading');

        updatePostTypeModal.addEventListener('hidden.bs.modal', function() {
            updatePostTypeForm.reset();

            const invalidInputs = updatePostTypeForm.querySelectorAll('.is-invalid');
            invalidInputs.forEach(input => {
                input.classList.remove('is-invalid');
            });
            const feedbacks = updatePostTypeForm.querySelectorAll('.invalid-feedback');
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

        updatePostTypeForm.addEventListener('submit', function(e) {
            // Show loading state
            updateSubmitBtn.disabled = true;
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline';
        });

        updatePostTypeModal.addEventListener('shown.bs.modal', function() {
            document.getElementById('updateName').focus();
        });
    });

    function openUpdateModal(post_typeId, post_typeData) {
        const updateForm = document.getElementById('updatePostTypeForm');
        updateForm.action = `{{ route('admin.post_type.update', ['id' => '__ID__']) }}`.replace('__ID__', post_typeId);
        
        document.getElementById('updatePostTypeId').value = post_typeId;
        
        document.getElementById('updateName').value = post_typeData.name || '';

        document.getElementById('updateDescription').value = post_typeData.description || '';
        

        
       
        const updateModal = new bootstrap.Modal(document.getElementById('updatePostTypeModal'));
        updateModal.show();
    }
</script>