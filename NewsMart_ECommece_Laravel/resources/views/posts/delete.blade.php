<div class="modal fade" id="deletePostModal" tabindex="-1" aria-labelledby="deletePostModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content delete-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="deletePostModalLabel">
                    <i class="fas fa-exclamation-triangle text-warning"></i>
                    Confirm Delete Post
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="delete-confirmation text-center">
                    <div class="delete-icon-container mb-3">
                        <i class="fas fa-file-alt delete-icon"></i>
                    </div>

                    <h4 class="delete-title mb-3">Are you sure?</h4>

                    <div class="delete-message mb-4">
                        <p class="mb-2">
                            Do you really want to delete the post
                            <strong id="deletePostTitleToDelete" class="text-danger"></strong>?
                        </p>

                        <div class="item-info-preview bg-light p-3 rounded mb-3" id="deletePostPreview">
                            <div class="text-start">
                                <div class="preview-item mb-2" id="deletePostSlugPreview">
                                    <small class="text-muted">Slug:</small>
                                    <span id="deletePostSlug"></span>
                                </div>
                                <div class="preview-item mb-2" id="deletePostStatusPreview">
                                    <small class="text-muted">Status:</small>
                                    <span id="deletePostStatus"></span>
                                </div>
                                <div class="preview-item" id="deletePostExcerptPreview">
                                    <small class="text-muted">Excerpt:</small>
                                    <span id="deletePostExcerpt"></span>
                                </div>
                            </div>
                        </div>

                        <small class="warning-text text-muted">
                            <i class="fas fa-exclamation-circle"></i>
                            This action cannot be undone and will permanently remove the post.
                        </small>
                    </div>
                </div>
            </div>

            <div class="modal-footer item-modal-footer">
                <button type="button" class="btn btn-cancel me-3" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i>
                    Cancel
                </button>
                <a href="#" id="deleteConfirmPostBtn" class="btn btn-delete">
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
        const deletePostModal = document.getElementById('deletePostModal');
        const deleteConfirmBtn = document.getElementById('deleteConfirmPostBtn');
        const btnText = deleteConfirmBtn.querySelector('span:not(.btn-loading)');
        const btnLoading = deleteConfirmBtn.querySelector('.btn-loading');

        // Khi bấm xác nhận xóa
        deleteConfirmBtn.addEventListener('click', function(e) {
            e.preventDefault();

            btnText.style.display = 'none';
            btnLoading.style.display = 'inline';
            deleteConfirmBtn.style.pointerEvents = 'none';

            // Điều hướng đến route xóa
            window.location.href = this.href;
        });

        // Reset modal khi đóng
        deletePostModal.addEventListener('hidden.bs.modal', function() {
            btnText.style.display = 'inline';
            btnLoading.style.display = 'none';
            deleteConfirmBtn.style.pointerEvents = 'auto';
        });
    });

    // Hàm mở modal và điền dữ liệu bài viết
    function openDeletePostModal(postId, postData) {
        document.getElementById('deletePostTitleToDelete').textContent = postData.title;

        // Gán đường dẫn route xóa
        const deleteBtn = document.getElementById('deleteConfirmPostBtn');
        deleteBtn.href = `{{ route('post.delete', ['id' => '__ID__']) }}`.replace('__ID__', postId);

        // Hiển thị thông tin preview
        document.getElementById('deletePostSlug').textContent = postData.slug || 'N/A';
        document.getElementById('deletePostStatus').textContent = postData.status || 'N/A';
        document.getElementById('deletePostExcerpt').textContent =
            postData.content ? postData.content.substring(0, 100) + '...' : 'No content';

        // Hiển thị modal
        const deleteModal = new bootstrap.Modal(document.getElementById('deletePostModal'));
        deleteModal.show();
    }
</script>