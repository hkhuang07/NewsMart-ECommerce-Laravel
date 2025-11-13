<div class="modal fade" id="updatePostModal" tabindex="-1" aria-labelledby="updatePostModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content item-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="updatePostModalLabel">
                    <i class="fa-light fa-edit"></i>
                    Edit Post
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="updatePostForm" action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="updatePostId" name="post_id" value="">

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label" for="updateTitle">
                                <i class="fa-light fa-heading"></i>
                                Post Title
                            </label>
                            <input type="text" class="form-control item-input" id="updateTitle" name="title"
                                placeholder="Enter post title" required />
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label" for="updateSlug">
                                <i class="fa-light fa-link"></i>
                                Slug
                            </label>
                            <input type="text" class="form-control item-input" id="updateSlug" name="slug"
                                placeholder="auto-generated or custom slug" />
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="col-md-12 mb-4">
                            <label class="form-label" for="updateContent">
                                <i class="fa-light fa-file-lines"></i>
                                Content
                            </label>
                            <textarea class="form-control item-textarea" id="updateContent" name="content" rows="6"
                                placeholder="Enter post content"></textarea>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label" for="updateStatus">
                                <i class="fa-light fa-toggle-on"></i>
                                Status
                            </label>
                            <select id="updateStatus" name="status" class="form-select">
                                <option value="Pending">Pending</option>
                                <option value="Published">Published</option>
                                <option value="Draft">Draft</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label class="form-label" for="updateImage">
                                <i class="fa-light fa-image"></i>
                                Image
                            </label>
                            <input type="file" class="form-control" id="updateImage" name="image" accept="image/*" />
                            <div class="mt-2" id="currentImagePreview" style="display:none;">
                                <small class="text-muted">Current image:</small><br>
                                <img src="" id="previewImage" alt="Current image" class="img-thumbnail mt-1"
                                    width="120">
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
                <button type="submit" form="updatePostForm" class="btn btn-action" id="updateSubmitBtn">
                    <i class="fa-light fa-save"></i>
                    <span class="btn-text">Update Post</span>
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
    const updateModal = document.getElementById('updatePostModal');
    const updateForm = document.getElementById('updatePostForm');
    const updateSubmitBtn = document.getElementById('updateSubmitBtn');
    const btnText = updateSubmitBtn.querySelector('.btn-text');
    const btnLoading = updateSubmitBtn.querySelector('.btn-loading');

    updateModal.addEventListener('hidden.bs.modal', function() {
        updateForm.reset();
        document.getElementById('currentImagePreview').style.display = 'none';
        const invalids = updateForm.querySelectorAll('.is-invalid');
        invalids.forEach(el => el.classList.remove('is-invalid'));
        updateSubmitBtn.disabled = false;
        btnText.style.display = 'inline';
        btnLoading.style.display = 'none';
    });

    updateForm.addEventListener('submit', function(e) {
        e.preventDefault();

        updateSubmitBtn.disabled = true;
        btnText.style.display = 'none';
        btnLoading.style.display = 'inline';

        const formData = new FormData(updateForm);

        fetch(updateForm.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (response.ok) {
                location.reload();
            } else {
                updateSubmitBtn.disabled = false;
                btnText.style.display = 'inline';
                btnLoading.style.display = 'none';
            }
        })
        .catch(() => {
            updateSubmitBtn.disabled = false;
            btnText.style.display = 'inline';
            btnLoading.style.display = 'none';
        });
    });

    updateModal.addEventListener('shown.bs.modal', function() {
        document.getElementById('updateTitle').focus();
    });
});

// Hàm mở modal và đổ dữ liệu
function openUpdatePostModal(postId, postData) {
    const form = document.getElementById('updatePostForm');
    form.action = `{{ route('post.update', ['id' => '__ID__']) }}`.replace('__ID__', postId);

    document.getElementById('updatePostId').value = postId;
    document.getElementById('updateTitle').value = postData.title || '';
    document.getElementById('updateSlug').value = postData.slug || '';
    document.getElementById('updateContent').value = postData.content || '';
    document.getElementById('updateStatus').value = postData.status || 'Pending';

    if (postData.image) {
        document.getElementById('currentImagePreview').style.display = 'block';
        document.getElementById('previewImage').src = `/uploads/posts/${postData.image}`;
    } else {
        document.getElementById('currentImagePreview').style.display = 'none';
    }

    const updateModal = new bootstrap.Modal(document.getElementById('updatePostModal'));
    updateModal.show();
}
</script>