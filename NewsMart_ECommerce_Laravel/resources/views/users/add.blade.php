<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content item-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="addUserModalLabel">
                    <i class="fa-light fa-plus-circle"></i>
                    Add New User
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="modalMessages" class="mb-3" style="display: none;">
                    <div id="errorMessage" class="alert alert-danger" style="display: none;"></div>
                    <div id="successMessage" class="alert alert-success" style="display: none;"></div>
                </div>

                <form id="addUserForm" action="{{ route('user.add') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    {{-- === ACCOUNT INFO SECTION === --}}
                    <h6 class="user-section-title mb-3 border-bottom pb-2"><i class="fas fa-info-circle me-1"></i> Account Details</h6>
                    <div class="row">
                        <div class="col-md-6">
                            {{-- Name (Required) --}}
                            <div class="form-group mb-4">
                                <label class="form-label" for="name">
                                    <i class="fas fa-user-tag"></i> Full Name
                                </label>
                                <input
                                    type="text"
                                    class="form-control item-input @error('name') is-invalid @enderror"
                                    id="name"
                                    name="name"
                                    value="{{ old('name') }}"
                                    placeholder="Enter full name"
                                    required />
                                @error('name')
                                <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                @enderror
                            </div>

                            {{-- Username (Unique required) --}}
                            <div class="form-group mb-4">
                                <label class="form-label" for="username">
                                    <i class="fas fa-user"></i> Username (Login ID)
                                </label>
                                <input
                                    type="text"
                                    class="form-control item-input @error('username') is-invalid @enderror"
                                    id="username"
                                    name="username"
                                    value="{{ old('username') }}"
                                    placeholder="Enter unique username"
                                    required />
                                @error('username')
                                <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                @enderror
                            </div>

                            {{-- Email (Unique required) --}}
                            <div class="form-group mb-4">
                                <label class="form-label" for="email">
                                    <i class="fa-light fa-envelope"></i> Email Address
                                </label>
                                <input
                                    type="email"
                                    class="form-control item-input @error('email') is-invalid @enderror"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    placeholder="Enter unique email address"
                                    required />
                                @error('email')
                                <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            {{-- Role Selection (Foreign Key: roleid) --}}
                            <div class="form-group mb-4">
                                <label class="form-label" for="roleid">
                                    <i class="fas fa-id-badge"></i> User Role
                                </label>
                                <select
                                    class="form-control item-input @error('roleid') is-invalid @enderror"
                                    id="roleid"
                                    name="roleid"
                                    required>
                                    <option value="">-- Select Role --</option>
                                    @if(isset($roles))
                                    @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ old('roleid') == $role->id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                    @endforeach
                                    @endif
                                </select>
                                @error('roleid')
                                <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                @enderror
                            </div>

                            {{-- Password --}}
                            <div class="form-group mb-4">
                                <label class="form-label" for="password">
                                    <i class="fas fa-lock"></i> Password
                                </label>
                                <input
                                    type="password"
                                    class="form-control item-input @error('password') is-invalid @enderror"
                                    id="password"
                                    name="password"
                                    placeholder="Enter password (min 8 chars)"
                                    required />
                                @error('password')
                                <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                @enderror
                            </div>

                            {{-- Password Confirmation --}}
                            <div class="form-group mb-4">
                                <label class="form-label" for="password_confirmation">
                                    <i class="fas fa-lock-open"></i> Confirm Password
                                </label>
                                <input
                                    type="password"
                                    class="form-control item-input"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    placeholder="Re-enter password"
                                    required />
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    {{-- === PROFILE & CONTACT SECTION === --}}
                    <h6 class="user-section-title mb-3 border-bottom pb-2"><i class="fas fa-address-card me-1"></i> Profile & Contact</h6>
                    <div class="row">
                        <div class="col-md-6">
                            {{-- Avatar (File Upload) --}}
                            <div class="form-group mb-4">
                                <label class="form-label" for="avatar">
                                    <i class="fas fa-image"></i> Profile Picture (Avatar)
                                </label>
                                <input
                                    type="file"
                                    class="form-control item-input @error('avatar') is-invalid @enderror"
                                    id="avatar"
                                    name="avatar"
                                    accept="image/*" />
                                @error('avatar')
                                <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                @enderror
                            </div>

                            {{-- Background (File Upload) --}}
                            <div class="form-group mb-4">
                                <label class="form-label" for="background">
                                    <i class="fas fa-camera"></i> Profile Background Image
                                </label>
                                <input
                                    type="file"
                                    class="form-control item-input @error('background') is-invalid @enderror"
                                    id="background"
                                    name="background"
                                    accept="image/*" />
                                @error('background')
                                <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                @enderror
                            </div>

                            {{-- Job Title --}}
                            <div class="form-group mb-4">
                                <label class="form-label" for="jobs">
                                    <i class="fas fa-briefcase"></i> Job Title
                                </label>
                                <input
                                    type="text"
                                    class="form-control item-input @error('jobs') is-invalid @enderror"
                                    id="jobs"
                                    name="jobs"
                                    value="{{ old('jobs') }}"
                                    placeholder="e.g., Software Developer" />
                                @error('jobs')
                                <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            {{-- Company --}}
                            <div class="form-group mb-4">
                                <label class="form-label" for="company">
                                    <i class="fas fa-building"></i> Company
                                </label>
                                <input
                                    type="text"
                                    class="form-control item-input @error('company') is-invalid @enderror"
                                    id="company"
                                    name="company"
                                    value="{{ old('company') }}"
                                    placeholder="e.g., NewsMart Tech" />
                                @error('company')
                                <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                @enderror
                            </div>

                            {{-- School --}}
                            <div class="form-group mb-4">
                                <label class="form-label" for="school">
                                    <i class="fas fa-graduation-cap"></i> School/University
                                </label>
                                <input
                                    type="text"
                                    class="form-control item-input @error('school') is-invalid @enderror"
                                    id="school"
                                    name="school"
                                    value="{{ old('school') }}"
                                    placeholder="e.g., FPT University" />
                                @error('school')
                                <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                @enderror
                            </div>

                            {{-- Phone Number --}}
                            <div class="form-group mb-4">
                                <label class="form-label" for="phone">
                                    <i class="fa-light fa-phone"></i> Phone Number
                                </label>
                                <input
                                    type="text"
                                    class="form-control item-input @error('phone') is-invalid @enderror"
                                    id="phone"
                                    name="phone"
                                    value="{{ old('phone') }}"
                                    placeholder="Enter phone number" />
                                @error('phone')
                                <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                @enderror
                            </div>

                            {{-- Address --}}
                            <div class="form-group mb-4">
                                <label class="form-label" for="address">
                                    <i class="fa-light fa-location-dot"></i> Address
                                </label>
                                <input
                                    type="text"
                                    class="form-control item-input @error('address') is-invalid @enderror"
                                    id="address"
                                    name="address"
                                    value="{{ old('address') }}"
                                    placeholder="Enter physical address" />
                                @error('address')
                                <div class="invalid-feedback"><strong>{{ $message }}</strong></div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    {{-- === STATUS SECTION === --}}
                    <h6 class="user-section-title mb-3 border-bottom pb-2"><i class="fas fa-toggle-on me-1"></i> Status</h6>
                    <div class="form-group mb-4">
                        <div class="form-check form-switch">
                            <input class="user-form-check-input"
                                type="checkbox"
                                id="isactive"
                                name="isactive"
                                value="1"
                                {{ old('isactive', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="isactive">
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
                <button type="submit" form="addUserForm" class="btn btn-action" id="submitBtn">
                    <i class="fa-light fa-save"></i>
                    <span class="btn-text">Add User</span>
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
        const addUserModal = document.getElementById('addUserModal');
        const addUserForm = document.getElementById('addUserForm');
        const submitBtn = document.getElementById('submitBtn');
        const btnText = submitBtn.querySelector('.btn-text');
        const btnLoading = submitBtn.querySelector('.btn-loading');

        // Reset form when modal is hidden (like Brands)
        addUserModal.addEventListener('hidden.bs.modal', function() {
            addUserForm.reset();

            // Clear validation errors
            const invalidInputs = addUserForm.querySelectorAll('.is-invalid');
            invalidInputs.forEach(input => {
                input.classList.remove('is-invalid');
            });
            const feedbacks = addUserForm.querySelectorAll('.invalid-feedback');
            feedbacks.forEach(feedback => {
                feedback.style.display = 'none';
            });

            // Hide messages
            document.getElementById('modalMessages').style.display = 'none';
            document.getElementById('errorMessage').style.display = 'none';
            document.getElementById('successMessage').style.display = 'none';

            // Reset button state
            submitBtn.disabled = false;
            btnText.style.display = 'inline';
            btnLoading.style.display = 'none';
        });

        // Handle form submission (like Brands - simple submission)
        addUserForm.addEventListener('submit', function(e) {
            // Show loading state only - let form submit normally
            submitBtn.disabled = true;
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline';
        });

        // Focus first input when modal is shown
        addUserModal.addEventListener('shown.bs.modal', function() {
            document.getElementById('name').focus();
        });
    });
</script>