<div class="modal fade" id="updateCommentModal" tabindex="-1" aria-labelledby="updateCommentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content item-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="updateCommentModalLabel">
                    <i class="fa-light fa-edit"></i>
                    Edit Comment
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <div id="updateModalMessages" class="mb-3" style="display: none;">
                    <div id="updateErrorMessage" class="alert alert-danger" style="display: none;"></div>
                    <div id="updateSuccessMessage" class="alert alert-success" style="display: none;"></div>
                </div>

                <form id="updateCommentForm" action="" method="post">
                    @csrf
                    <input type="hidden" id="updateCommentId" name="comment_id">

                    <div class="form-group mb-4">
                        <label class="form-label" for="updatePostId">
                            <i class="fa-light fa-paperclip"></i>
                            Post ID
                        </label>
                        <input
                            type="number"
                            class="form-control item-input"
                            id="updatePostId"
                            name="postid"
                            placeholder="Enter post ID"
                            required />
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="updateUserId">
                            <i class="fa-light fa-user"></i>
                            User ID
                        </label>
                        <input
                            type="number"
                            class="form-control item-input"
                            id="updateUserId"
                            name="userid"
                            placeholder="Enter user ID"
                            required />
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="updateParentId">
                            <i class="fa-light fa-comments"></i>
                            Parent Comment ID (Optional)
                        </label>
                        <input
                            type="number"
                            class="form-control item-input"
                            id="updateParentId"
                            name="parentcommentid"
                            placeholder="Enter parent comment ID (optional)" />
                        <div class="invalid-feedback"></div>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="updateContent">
                            <i class="fa-light fa-file-lines"></i>
                            Comment Content
                        </label>
                        <textarea
                            class="form-control item-textarea"
                            id="updateContent"
                            name="content"
                            rows="4"
                            placeholder="Enter comment content"
                            required></textarea>
                        <div class="invalid-feedback"></div>
                    </div>
                </form>
            </div>

            <div class="modal-footer item-modal-footer">
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">
                    <i class="fa-light fa-times"></i>
                    Cancel
                </button>

                <button type="submit" form="updateCommentForm" class="btn btn-action" id="updateSubmitBtn">
                    <i class="fa-light fa-save"></i>
                    <span class="btn-text">Update Comment</span>
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
    const updateModal = document.getElementById('updateCommentModal');
    const updateForm = document.getElementById('updateCommentForm');
    const updateBtn = document.getElementById('updateSubmitBtn');
    const btnText = updateBtn.querySelector('.btn-text');
    const btnLoading = updateBtn.querySelector('.btn-loading');

    updateModal.addEventListener('hidden.bs.modal', function() {
        updateForm.reset();

        const invalid = updateForm.querySelectorAll('.is-invalid');
        invalid.forEach(input => input.classList.remove('is-invalid'));

        const feedbacks = updateForm.querySelectorAll('.invalid-feedback');
        feedbacks.forEach(fb => {
            fb.style.display = 'none';
            fb.textContent = '';
        });

        document.getElementById('updateModalMessages').style.display = 'none';
        document.getElementById('updateErrorMessage').style.display = 'none';
        document.getElementById('updateSuccessMessage').style.display = 'none';

        updateBtn.disabled = false;
        btnText.style.display = 'inline';
        btnLoading.style.display = 'none';
    });

    updateForm.addEventListener('submit', function() {
        updateBtn.disabled = true;
        btnText.style.display = 'none';
        btnLoading.style.display = 'inline';
    });

    updateModal.addEventListener('shown.bs.modal', function() {
        document.getElementById('updateContent').focus();
    });
});

function openUpdateCommentModal(commentId, commentData) {
    const form = document.getElementById('updateCommentForm');
    form.action = `{{ route('admin.comment.update', ['id' => '__ID__']) }}`.replace('__ID__', commentId);

    document.getElementById('updateCommentId').value = commentId;
    document.getElementById('updatePostId').value = commentData.postid;
    document.getElementById('updateUserId').value = commentData.userid;
    document.getElementById('updateParentId').value = commentData.parentcommentid ?? '';
    document.getElementById('updateContent').value = commentData.content;

    const modal = new bootstrap.Modal(document.getElementById('updateCommentModal'));
    modal.show();
}
</script>
