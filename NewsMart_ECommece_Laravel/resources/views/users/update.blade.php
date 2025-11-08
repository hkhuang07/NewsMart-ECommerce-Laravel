<div class="modal fade" id="updateUserModal" tabindex="-1" aria-labelledby="updateUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content item-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="updateUserModalLabel">
                    <i class="fa-light fa-edit"></i>
                    Edit User
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="updateModalMessages" class="mb-3" style="display: none;">
                    <div id="updateErrorMessage" class="alert alert-danger" style="display: none;"></div>
                    <div id="updateSuccessMessage" class="alert alert-success" style="display: none;"></div>
                </div>

                <form id="updateUserForm" action="" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="updateUserId" name="user_id" value="">

                    <h6 class="user-section-title mb-3 border-bottom pb-2"><i class="fas fa-info-circle me-1"></i> Account Details</h6>
                    <div class="row">
                        <div class="col-md-6">
                            {{-- Name (Required) --}}
                            <div class="form-group mb-4">
                                <label class="form-label" for="updateName">
                                    <i class="fas fa-user-tag"></i> Full Name
                                </label>
                                <input
                                    type="text"
                                    class="form-control item-input"
                                    id="updateName"
                                    name="name"
                                    placeholder="Enter full name"
                                    required />
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label" for="updateUsername">
                                    <i class="fas fa-user"></i> Username (Login ID)
                                </label>
                                <input
                                    type="text"
                                    class="form-control item-input"
                                    id="updateUsername"
                                    name="username"
                                    placeholder="Enter unique username"
                                    required />
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label" for="updateEmail">
                                    <i class="fa-light fa-envelope"></i> Email Address
                                </label>
                                <input
                                    type="email"
                                    class="form-control item-input"
                                    id="updateEmail"
                                    name="email"
                                    placeholder="Enter unique email address"
                                    required />
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="updateRoleid">
                                    <i class="fas fa-id-badge"></i> User Role
                                </label>
                                <select
                                    class="form-control item-input"
                                    id="updateRoleid"
                                    name="roleid"
                                    required>
                                    <option value="">-- Select Role --</option>
                                    @if(isset($roles))
                                    @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                    @endif
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>

                            {{-- Password (Optional) --}}
                            <div class="form-group mb-4">
                                <label class="form-label" for="updatePassword">
                                    <i class="fas fa-lock"></i> Password (New)
                                </label>
                                <input
                                    type="password"
                                    class="form-control item-input"
                                    id="updatePassword"
                                    name="password"
                                    placeholder="Leave empty to keep current password" />
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label" for="updatePasswordConfirmation">
                                    <i class="fas fa-lock-open"></i> Confirm Password
                                </label>
                                <input
                                    type="password"
                                    class="form-control item-input"
                                    id="updatePasswordConfirmation"
                                    name="password_confirmation"
                                    placeholder="Re-enter new password" />
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h6 class="user-section-title mb-3 border-bottom pb-2"><i class="fas fa-address-card me-1"></i> Profile & Contact</h6>
                    <div class="row">
                        <div class="col-md-6">
                            {{-- Avatar (File Upload) --}}
                            <div class="form-group mb-4">
                                <label class="form-label" for="updateAvatar">
                                    <i class="fas fa-image"></i> Profile Picture (Avatar)
                                </label>
                                <input
                                    type="file"
                                    class="form-control item-input"
                                    id="updateAvatar"
                                    name="avatar"
                                    accept="image/*" />
                                <small class="form-text text-muted">Leave empty to keep current avatar.</small>
                                <div class="invalid-feedback"></div>

                                <div id="currentAvatarPreview" class="mt-3" style="display: none;">
                                    <label class="form-label">Current:</label>
                                    <div class="current-logo-container">
                                        <img id="currentAvatarImage" src="" alt="Current Avatar" class="current-logo-preview">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label" for="updateBackground">
                                    <i class="fas fa-camera"></i> Profile Background Image
                                </label>
                                <input
                                    type="file"
                                    class="form-control item-input"
                                    id="updateBackground"
                                    name="background"
                                    accept="image/*" />
                                <small class="form-text text-muted">Leave empty to keep current background.</small>
                                <div class="invalid-feedback"></div>

                                <div id="currentBackgroundPreview" class="mt-3" style="display: none;">
                                    <label class="form-label">Current:</label>
                                    <div class="current-logo-container">
                                        <img id="currentBackgroundImage" src="" alt="Current Background" class="current-logo-preview">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label" for="updateJobs">
                                    <i class="fas fa-briefcase"></i> Job Title
                                </label>
                                <input type="text" class="form-control item-input" id="updateJobs" name="jobs" placeholder="e.g., Software Developer" />
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="updateCompany">
                                    <i class="fas fa-building"></i> Company
                                </label>
                                <input type="text" class="form-control item-input" id="updateCompany" name="company" placeholder="e.g., NewsMart Tech" />
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label" for="updateSchool">
                                    <i class="fas fa-graduation-cap"></i> School/University
                                </label>
                                <input type="text" class="form-control item-input" id="updateSchool" name="school" placeholder="e.g., FPT University" />
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label" for="updatePhone">
                                    <i class="fa-light fa-phone"></i> Phone Number
                                </label>
                                <input type="text" class="form-control item-input" id="updatePhone" name="phone" placeholder="Enter phone number" />
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="form-group mb-4">
                                <label class="form-label" for="updateAddress">
                                    <i class="fa-light fa-location-dot"></i> Address
                                </label>
                                <input type="text" class="form-control item-input" id="updateAddress" name="address" placeholder="Enter physical address" />
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h6 class="user-section-title mb-3 border-bottom pb-2">
                        <i class="fas fa-toggle-on me-1"></i> Status
                    </h6>
                    <div class="form-group mb-4">
                        <div class="form-check form-switch">
                            <input class="user-form-check-input"
                                type="checkbox"
                                id="updateIsactive"
                                name="isactive"
                                value="1">
                            <label class="form-check-label" for="updateIsactive">
                                Account Active
                            </label>
                            <small class="form-check-note d-block">Uncheck to disable user login access.</small>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer item-modal-footer">
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">
                    <i class="fa-light fa-times"></i>
                    Cancel
                </button>
                <button type="submit" form="updateUserForm" class="btn btn-action" id="updateSubmitBtn">
                    <i class="fa-light fa-save"></i>
                    <span class="btn-text">Update User</span>
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
        const updateUserModal = document.getElementById('updateUserModal');
        const updateUserForm = document.getElementById('updateUserForm');
        const updateSubmitBtn = document.getElementById('updateSubmitBtn');
        const btnText = updateSubmitBtn.querySelector('.btn-text');
        const btnLoading = updateSubmitBtn.querySelector('.btn-loading');

        updateUserModal.addEventListener('hidden.bs.modal', function() {
            updateUserForm.reset();

            const invalidInputs = updateUserForm.querySelectorAll('.is-invalid');
            invalidInputs.forEach(i => i.classList.remove('is-invalid'));
            const feedbacks = updateUserForm.querySelectorAll('.invalid-feedback');
            feedbacks.forEach(f => {
                f.style.display = 'none';
                f.textContent = '';
            });

            document.getElementById('updateModalMessages').style.display = 'none';
            document.getElementById('updateErrorMessage').style.display = 'none';
            document.getElementById('updateSuccessMessage').style.display = 'none';

            document.getElementById('currentAvatarPreview').style.display = 'none';
            document.getElementById('currentBackgroundPreview').style.display = 'none';

            updateSubmitBtn.disabled = false;
            btnText.style.display = 'inline';
            btnLoading.style.display = 'none';
        });

        updateUserForm.addEventListener('submit', function(e) {
            updateSubmitBtn.disabled = true;
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline';
        });

        updateUserModal.addEventListener('shown.bs.modal', function() {
            document.getElementById('updateName').focus();
        });
    });

    function openUpdateModal(userId) {
        const selectRole = document.getElementById('updateRoleid');
        const isactiveCheckbox = document.getElementById('updateIsactive');
        const updateForm = document.getElementById('updateUserForm');

        const urlFetch = `{{ route('api.user.get', ['id' => '__ID__']) }}`.replace('__ID__', userId);

        updateForm.action = `{{ route('user.update', ['id' => '__ID__']) }}`.replace('__ID__', userId);
        document.getElementById('updateUserId').value = userId;

        const baseStorageUrl = "{{ asset('storage') }}";

        const updateModal = new bootstrap.Modal(document.getElementById('updateUserModal'));
        updateModal.show();

        fetch(urlFetch)
            .then(response => {
                if (!response.ok) throw new Error('Failed to fetch user data.');
                return response.json();
            })
            .then(data => {
                document.getElementById('updateName').value = data.name || '';
                document.getElementById('updateUsername').value = data.username || '';
                document.getElementById('updateEmail').value = data.email || '';
                document.getElementById('updatePhone').value = data.phone || '';
                document.getElementById('updateAddress').value = data.address || '';
                document.getElementById('updateJobs').value = data.jobs || '';
                document.getElementById('updateCompany').value = data.company || '';
                document.getElementById('updateSchool').value = data.school || '';

                if (selectRole) {
                    selectRole.value = data.role_id || data.roleid || '';
                }

                if (isactiveCheckbox) {
                    isactiveCheckbox.checked = data.is_active;
                }

                const currentAvatarPreview = document.getElementById('currentAvatarPreview');
                const currentAvatarImage = document.getElementById('currentAvatarImage');
                const currentBackgroundPreview = document.getElementById('currentBackgroundPreview');
                const currentBackgroundImage = document.getElementById('currentBackgroundImage');

                if (data.avatar) {
                    currentAvatarImage.src = baseStorageUrl + '/' + data.avatar;
                    currentAvatarPreview.style.display = 'block';
                } else {
                    currentAvatarPreview.style.display = 'none';
                    currentAvatarImage.src = '';
                }
                if (data.background) {
                    currentBackgroundImage.src = baseStorageUrl + '/' + data.background;
                    currentBackgroundPreview.style.display = 'block';
                } else {
                    currentBackgroundPreview.style.display = 'none';
                    currentBackgroundImage.src = '';
                }

                updateForm.querySelectorAll('.is-invalid').forEach(i => i.classList.remove('is-invalid'));
                updateForm.querySelectorAll('.invalid-feedback').forEach(f => {
                    f.style.display = 'none';
                    f.textContent = '';
                });

            })
            .catch(error => {
                console.error('Error fetching user data:', error);
                updateModal.hide();
            });
    }

    window.openUpdateModal = openUpdateModal;
</script>