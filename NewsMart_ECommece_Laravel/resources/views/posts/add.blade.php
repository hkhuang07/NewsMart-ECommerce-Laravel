<div class="modal fade" id="addPostModal" tabindex="-1" aria-labelledby="addPostModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content item-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="addPostModalLabel">
                    <i class="fa-light fa-square-plus"></i>
                    Add New Post
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                {{-- Thông báo --}}
                <div id="modalMessages" class="mb-3" style="display:none;">
                    <div id="errorMessage" class="alert alert-danger" style="display:none;"></div>
                    <div id="successMessage" class="alert alert-success" style="display:none;"></div>
                </div>

                <form id="addPostForm" action="{{ route('post.add') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Tiêu đề --}}
                    <div class="form-group mb-4">
                        <label class="form-label" for="title">
                            <i class="fa-light fa-heading"></i>
                            Title
                        </label>
                        <input type="text" class="form-control item-input @error('title') is-invalid @enderror"
                            id="title" name="title" value="{{ old('title') }}" placeholder="Enter post title" required>
                        @error('title')
                        <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                        @enderror
                    </div>

                    {{-- Slug --}}
                    <div class="form-group mb-4">
                        <label class="form-label" for="slug">
                            <i class="fa-light fa-link"></i>
                            Slug (optional)
                        </label>
                        <input type="text" class="form-control item-input @error('slug') is-invalid @enderror" id="slug"
                            name="slug" value="{{ old('slug') }}" placeholder="Auto-generated if empty">
                        @error('slug')
                        <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                        @enderror
                    </div>

                    {{-- Product ID --}}
                    <div class="form-group mb-4">
                        <label class="form-label" for="productid">
                            <i class="fa-light fa-box"></i>
                            Product ID (optional)
                        </label>
                        <input type="number" class="form-control item-input @error('productid') is-invalid @enderror"
                            id="productid" name="productid" value="{{ old('productid') }}"
                            placeholder="Enter related product ID">
                        @error('productid')
                        <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                        @enderror
                    </div>

                    {{-- Post Type ID --}}
                    <div class="form-group mb-4">
                        <label class="form-label" for="posttypeid">
                            <i class="fa-light fa-layer-group"></i>
                            Post Type ID
                        </label>
                        <input type="number" class="form-control item-input @error('posttypeid') is-invalid @enderror"
                            id="posttypeid" name="posttypeid" value="{{ old('posttypeid') }}"
                            placeholder="Enter post type ID">
                        @error('posttypeid')
                        <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                        @enderror
                    </div>

                    {{-- Topic ID --}}
                    <div class="form-group mb-4">
                        <label class="form-label" for="topicid">
                            <i class="fa-light fa-tags"></i>
                            Topic ID (optional)
                        </label>
                        <input type="number" class="form-control item-input @error('topicid') is-invalid @enderror"
                            id="topicid" name="topicid" value="{{ old('topicid') }}"
                            placeholder="Enter related topic ID">
                        @error('topicid')
                        <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                        @enderror
                    </div>

                    {{-- Content --}}
                    <div class="form-group mb-4">
                        <label class="form-label" for="content">
                            <i class="fa-light fa-file-lines"></i>
                            Content
                        </label>
                        <textarea class="form-control item-textarea @error('content') is-invalid @enderror" id="content"
                            name="content" rows="6" placeholder="Write post content here..."
                            required>{{ old('content') }}</textarea>
                        @error('content')
                        <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="form-group mb-4">
                        <label class="form-label" for="status">
                            <i class="fa-light fa-flag"></i>
                            Status
                        </label>
                        <select class="form-select item-input @error('status') is-invalid @enderror" id="status"
                            name="status">
                            <option value="Pending" {{ old('status')==='Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Published" {{ old('status')==='Published' ? 'selected' : '' }}>Published
                            </option>
                            <option value="Draft" {{ old('status')==='Draft' ? 'selected' : '' }}>Draft</option>
                        </select>
                        @error('status')
                        <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                        @enderror
                    </div>

                    {{-- Image upload --}}
                    <div class="form-group mb-4">
                        <label class="form-label" for="image">
                            <i class="fa-light fa-image"></i>
                            Featured Image
                        </label>
                        <input type="file" class="form-control item-input @error('image') is-invalid @enderror"
                            id="image" name="image" accept="image/*">
                        @error('image')
                        <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                        @enderror
                    </div>
                </form>
            </div>

            {{-- Modal Footer --}}
            <div class="modal-footer item-modal-footer">
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">
                    <i class="fa-light fa-times"></i>
                    Cancel
                </button>
                <button type="submit" form="addPostForm" class="btn btn-action" id="submitBtn">
                    <i class="fa-light fa-save"></i>
                    <span class="btn-text">Add Post</span>
                    <span class="btn-loading" style="display:none;">
                        <i class="fa-light fa-spinner fa-spin"></i> Adding...
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>

{{-- JS xử lý modal --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const addPostModal = document.getElementById('addPostModal');
        const addPostForm = document.getElementById('addPostForm');
        const submitBtn = document.getElementById('submitBtn');
        const btnText = submitBtn.querySelector('.btn-text');
        const btnLoading = submitBtn.querySelector('.btn-loading');

        addPostModal.addEventListener('hidden.bs.modal', function () {
            addPostForm.reset();
            addPostForm.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            document.getElementById('modalMessages').style.display = 'none';
            document.getElementById('errorMessage').style.display = 'none';
            document.getElementById('successMessage').style.display = 'none';
            submitBtn.disabled = false;
            btnText.style.display = 'inline';
            btnLoading.style.display = 'none';
        });

        addPostForm.addEventListener('submit', function () {
            submitBtn.disabled = true;
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline';
        });

        addPostModal.addEventListener('shown.bs.modal', function () {
            document.getElementById('title').focus();
        });
    });
</script>