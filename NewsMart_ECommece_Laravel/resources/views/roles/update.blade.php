<div class="modal fade" id="updateRoleModal" tabindex="-1" aria-labelledby="updateRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content item-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="updateRoleModalLabel">
                    <i class="fa-light fa-edit"></i>
                    Edit Role
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                {{-- THÊM: Khu vực hiển thị thông báo lỗi/thành công từ AJAX hoặc Laravel Session --}}
                <div id="updateModalMessages" class="mb-3" style="display: none;">
                    <div id="updateErrorMessage" class="alert alert-danger" style="display: none;"></div>
                    <div id="updateSuccessMessage" class="alert alert-success" style="display: none;"></div>
                </div>

                <form id="updateRoleForm" action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="updateRoleId" name="role_id" value="">

                    <div class="form-group mb-4">
                        <label class="form-label" for="updateName">
                            <i class="fa-light fa-user-shield"></i>
                            Role Name
                        </label>
                        <input
                            type="text"
                            class="form-control item-input @if(session('update_errors') && session('update_errors')->has('name')) is-invalid @endif"
                            id="updateName"
                            name="name"
                            placeholder="Enter role name"
                            required 
                            {{-- BƯỚC 3: DÙNG old() VỚI update_errors ĐỂ GIỮ DỮ LIỆU ĐÃ NHẬP --}}
                            value="{{ old('name', session('update_old.name')) }}"
                        />
                        {{-- SỬA LỖI: Invalid Feedback cho trường 'name' --}}
                        @if(session('update_errors') && session('update_errors')->has('name'))
                            <div class="invalid-feedback" style="display: block;">
                                <strong>{{ session('update_errors')->first('name') }}</strong>
                            </div>
                        @else
                            <div class="invalid-feedback"></div>
                        @endif
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="updateDescription">
                            <i class="fa-light fa-file-text"></i>
                            Role Description
                        </label>
                        <textarea
                            class="form-control item-textarea @if(session('update_errors') && session('update_errors')->has('description')) is-invalid @endif"
                            id="updateDescription"
                            name="description"
                            rows="4"
                            placeholder="Enter role description">{{ old('description', session('update_old.description')) }}</textarea>
                        
                        {{-- SỬA LỖI: Invalid Feedback cho trường 'description' --}}
                        @if(session('update_errors') && session('update_errors')->has('description'))
                            <div class="invalid-feedback" style="display: block;">
                                <strong>{{ session('update_errors')->first('description') }}</strong>
                            </div>
                        @else
                            <div class="invalid-feedback"></div>
                        @endif
                    </div>
                </form>
            </div>

            <div class="modal-footer item-modal-footer">
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">
                    <i class="fa-light fa-times"></i>
                    Cancel
                </button>
                <button type="submit" form="updateRoleForm" class="btn btn-action" id="updateSubmitBtn">
                    <i class="fa-light fa-save"></i>
                    <span class="btn-text">Update Role</span>
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
        const updateRoleModal = document.getElementById('updateRoleModal');
        const updateRoleForm = document.getElementById('updateRoleForm');
        const updateSubmitBtn = document.getElementById('updateSubmitBtn');
        // Đã loại bỏ các dòng JS liên quan đến ẩn/hiện thông báo khi bạn dùng logic Laravel Session để xử lý.

        // Reset modal khi đóng
        updateRoleModal.addEventListener('hidden.bs.modal', function() {
            updateRoleForm.reset();

            const invalidInputs = updateRoleForm.querySelectorAll('.is-invalid');
            invalidInputs.forEach(input => input.classList.remove('is-invalid'));
            
            const feedbacks = updateRoleForm.querySelectorAll('.invalid-feedback');
            feedbacks.forEach(feedback => {
                feedback.style.display = 'none';
                feedback.textContent = '';
            });
            
            // Tắt hiệu ứng loading
            const btnText = updateSubmitBtn.querySelector('.btn-text');
            const btnLoading = updateSubmitBtn.querySelector('.btn-loading');
            updateSubmitBtn.disabled = false;
            btnText.style.display = 'inline';
            btnLoading.style.display = 'none';
        });

        // Gửi form (Giữ nguyên logic AJAX xử lý lỗi 422 và reload)
        updateRoleForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Khởi tạo lại trạng thái submit button
            const btnText = updateSubmitBtn.querySelector('.btn-text');
            const btnLoading = updateSubmitBtn.querySelector('.btn-loading');
            updateSubmitBtn.disabled = true;
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline';

            // Xóa lỗi cũ
            const invalidInputs = updateRoleForm.querySelectorAll('.is-invalid');
            invalidInputs.forEach(input => input.classList.remove('is-invalid'));
            const feedbacks = updateRoleForm.querySelectorAll('.invalid-feedback');
            feedbacks.forEach(feedback => {
                feedback.style.display = 'none';
                feedback.textContent = '';
            });
            document.getElementById('updateErrorMessage').style.display = 'none';


            const formData = new FormData(updateRoleForm);

            fetch(updateRoleForm.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (response.status === 422) {
                    return response.json().then(data => { throw data.errors; });
                }
                
                if (response.ok) {
                    location.reload(); // Thành công → reload
                } else {
                    throw new Error('Cập nhật thất bại.');
                }
            })
            .catch(errors => {
                const errorDiv = document.getElementById('updateErrorMessage');
                const modalMessages = document.getElementById('updateModalMessages');
                
                if (typeof errors === 'object' && errors !== null) {
                    let errorHtml = '<strong>Vui lòng sửa các lỗi sau:</strong><ul>';
                    
                    for (const field in errors) {
                        const inputElement = document.getElementById('update' + field.charAt(0).toUpperCase() + field.slice(1));
                        const feedbackElement = inputElement ? inputElement.nextElementSibling : null;
                        
                        if (inputElement) inputElement.classList.add('is-invalid');
                        if (feedbackElement && feedbackElement.classList.contains('invalid-feedback')) {
                            feedbackElement.textContent = errors[field][0];
                            feedbackElement.style.display = 'block';
                        }
                        errorHtml += `<li>${errors[field][0]}</li>`;
                    }
                    errorHtml += '</ul>';
                    
                    errorDiv.innerHTML = errorHtml;
                    errorDiv.style.display = 'block';
                    if (modalMessages) modalMessages.style.display = 'block';

                } else {
                    errorDiv.innerHTML = `<strong>Lỗi:</strong> ${errors.message || 'Có lỗi xảy ra trong quá trình cập nhật.'}`;
                    errorDiv.style.display = 'block';
                    if (modalMessages) modalMessages.style.display = 'block';
                }

                updateSubmitBtn.disabled = false;
                btnText.style.display = 'inline';
                btnLoading.style.display = 'none';
            });
        });

        // Focus ô nhập khi mở modal
        updateRoleModal.addEventListener('shown.bs.modal', function() {
            document.getElementById('updateName').focus();
        });
    });

    // Mở modal và đổ dữ liệu
    function openUpdateModal(roleId, roleData) {
        const updateForm = document.getElementById('updateRoleForm');
        // Khắc phục lỗi: Thay thế '__ID__' trong route
        updateForm.action = `{{ route('role.update', ['id' => '__ID__']) }}`.replace('__ID__', roleId); 

        document.getElementById('updateRoleId').value = roleId;
        document.getElementById('updateName').value = roleData.name || '';
        document.getElementById('updateDescription').value = roleData.description || '';
        
        // Cố gắng đặt giá trị slug nếu tồn tại
        const updateSlugElement = document.getElementById('updateSlug');
        if (updateSlugElement) {
             updateSlugElement.value = roleData.slug || '';
        }

        // Đảm bảo ẩn mọi lỗi/trạng thái cũ khi mở Modal
        const invalidInputs = updateForm.querySelectorAll('.is-invalid');
        invalidInputs.forEach(input => input.classList.remove('is-invalid'));
        const feedbacks = updateForm.querySelectorAll('.invalid-feedback');
        feedbacks.forEach(feedback => feedback.style.display = 'none');
        
        const modalMessages = document.getElementById('updateModalMessages');
        if (modalMessages) {
             modalMessages.style.display = 'none';
             document.getElementById('updateErrorMessage').style.display = 'none';
             document.getElementById('updateSuccessMessage').style.display = 'none';
        }

        // Khởi tạo và hiển thị Modal
        const updateModal = new bootstrap.Modal(document.getElementById('updateRoleModal'));
        updateModal.show();
    }
</script>