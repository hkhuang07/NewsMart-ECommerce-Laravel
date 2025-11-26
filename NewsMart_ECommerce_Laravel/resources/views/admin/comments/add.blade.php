<div class="modal fade" id="addCommentModal" tabindex="-1" aria-labelledby="addCommentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content item-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="addCommentModalLabel">
                    <i class="fa-light fa-plus-circle"></i>
                    Add New Comment
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="modalMessages" class="mb-3" style="display: none;">
                    <div id="errorMessage" class="alert alert-danger" style="display: none;"></div>
                    <div id="successMessage" class="alert alert-success" style="display: none;"></div>
                </div>

                <form id="addCommentForm" action="{{ route('admin.comment.add') }}" method="post">
                    @csrf

                    <div class="form-group mb-4">
                        <label class="form-label" for="postid">
                            <i class="fa-light fa-file-lines"></i>
                            Post ID
                        </label>
                        <input
                            type="number"
                            class="form-control item-input @error('postid') is-invalid @enderror"
                            id="postid"
                            name="postid"
                            value="{{ old('postid') }}"
                            placeholder="Enter post ID"
                            required />
                        @error('postid')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="userid">
                            <i class="fa-light fa-user"></i>
                            User ID
                        </label>
                        <input
                            type="number"
                            class="form-control item-input @error('userid') is-invalid @enderror"
                            id="userid"
                            name="userid"
                            value="{{ old('userid') }}"
                            placeholder="Enter user ID"
                            required />
                        @error('userid')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="parentcommentid">
                            <i class="fa-light fa-reply"></i>
                            Parent Comment ID (optional)
                        </label>
                        <input
                            type="number"
                            class="form-control item-input @error('parentcommentid') is-invalid @enderror"
                            id="parentcommentid"
                            name="parentcommentid"
                            value="{{ old('parentcommentid') }}"
                            placeholder="Enter parent comment ID" />
                        @error('parentcommentid')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="content">
                            <i class="fa-light fa-comment"></i>
                            Comment Content
                        </label>
                        <textarea
                            class="form-control item-textarea @error('content') is-invalid @enderror"
                            id="content"
                            name="content"
                            rows="4"
                            placeholder="Enter comment"
                            required>{{ old('content') }}</textarea>
                        @error('content')
                        <div class="invalid-feedback">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>

                </form>
            </div>

            <div class="modal-footer item-modal-footer">
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">
                    <i class="fa-light fa-times"></i>
                    Cancel
                </button>

                <button type="submit" form="addCommentForm" class="btn btn-action" id="submitBtn">
                    <i class="fa-light fa-save"></i>
                    <span class="btn-text">Add Comment</span>
                    <span class="btn-loading" style="display: none;">
                        <i class="fa-light fa-spinner fa-spin"></i>
                        Adding...
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const addCommentModal = document.getElementById('addCommentModal');
    const addCommentForm = document.getElementById('addCommentForm');
    const submitBtn = document.getElementById('submitBtn');
    const btnText = submitBtn.querySelector('.btn-text');
    const btnLoading = submitBtn.querySelector('.btn-loading');

    addCommentModal.addEventListener('hidden.bs.modal', function() {
        addCommentForm.reset();

        const invalidInputs = addCommentForm.querySelectorAll('.is-invalid');
        invalidInputs.forEach(input => input.classList.remove('is-invalid'));

        const feedbacks = addCommentForm.querySelectorAll('.invalid-feedback');
        feedbacks.forEach(fb => fb.style.display = 'none');

        document.getElementById('modalMessages').style.display = 'none';
        document.getElementById('errorMessage').style.display = 'none';
        document.getElementById('successMessage').style.display = 'none';

        submitBtn.disabled = false;
        btnText.style.display = 'inline';
        btnLoading.style.display = 'none';
    });

    addCommentForm.addEventListener('submit', function() {
        submitBtn.disabled = true;
        btnText.style.display = 'none';
        btnLoading.style.display = 'inline';
    });

    addCommentModal.addEventListener('shown.bs.modal', function() {
        document.getElementById('postid').focus();
    });
});
</script>
