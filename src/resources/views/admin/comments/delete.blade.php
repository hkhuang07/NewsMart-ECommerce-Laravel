<div class="modal fade" id="deleteCommentModal" tabindex="-1" aria-labelledby="deleteCommentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content delete-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="deleteCommentModalLabel">
                    <i class="fas fa-exclamation-triangle text-warning"></i>
                    Confirm Delete Comment
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
                            Do you really want to delete this comment?
                        </p>

                        <div class="item-info-preview bg-light p-3 rounded mb-3 text-start" id="deleteCommentPreview">

                            <div class="preview-item mb-2">
                                <small class="text-muted">Comment ID:</small>
                                <span id="deleteCommentId"></span>
                            </div>

                            <div class="preview-item mb-2">
                                <small class="text-muted">User ID:</small>
                                <span id="deleteCommentUserId"></span>
                            </div>

                            <div class="preview-item mb-2">
                                <small class="text-muted">Post ID:</small>
                                <span id="deleteCommentPostId"></span>
                            </div>

                            <div class="preview-item mb-2">
                                <small class="text-muted">Parent Comment ID:</small>
                                <span id="deleteCommentParentId"></span>
                            </div>

                            <div class="preview-item">
                                <small class="text-muted">Content:</small>
                                <div id="deleteCommentContent" class="fw-bold text-dark"></div>
                            </div>

                        </div>

                        <small class="warning-text text-muted">
                            <i class="fas fa-exclamation-circle"></i>
                            This action cannot be undone.
                        </small>
                    </div>
                </div>
            </div>

            <div class="modal-footer item-modal-footer">
                <button type="button" class="btn btn-cancel me-3" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i>
                    Cancel
                </button>

                <a href="#" id="deleteConfirmCommentBtn" class="btn btn-delete">
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
    const deleteModal = document.getElementById('deleteCommentModal');
    const deleteConfirmBtn = document.getElementById('deleteConfirmCommentBtn');
    const btnText = deleteConfirmBtn.querySelector('span:not(.btn-loading)');
    const btnLoading = deleteConfirmBtn.querySelector('.btn-loading');

    deleteConfirmBtn.addEventListener('click', function(e) {
        e.preventDefault();
        btnText.style.display = 'none';
        btnLoading.style.display = 'inline';
        deleteConfirmBtn.style.pointerEvents = 'none';

        window.location.href = this.href;
    });

    deleteModal.addEventListener('hidden.bs.modal', function() {
        btnText.style.display = 'inline';
        btnLoading.style.display = 'none';
        deleteConfirmBtn.style.pointerEvents = 'auto';
    });
});

function openDeleteCommentModal(commentId, commentData) {
    document.getElementById('deleteCommentId').textContent = commentId;
    document.getElementById('deleteCommentUserId').textContent = commentData.userid;
    document.getElementById('deleteCommentPostId').textContent = commentData.postid;
    document.getElementById('deleteCommentParentId').textContent = commentData.parentcommentid ?? 'None';
    document.getElementById('deleteCommentContent').textContent = commentData.content;

    const deleteBtn = document.getElementById('deleteConfirmCommentBtn');
    deleteBtn.href = `{{ route('admin.comment.delete', ['id' => '__ID__']) }}`.replace('__ID__', commentId);

    const modal = new bootstrap.Modal(document.getElementById('deleteCommentModal'));
    modal.show();
}
</script>
