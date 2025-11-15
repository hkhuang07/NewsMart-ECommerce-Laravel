<div class="modal fade" id="updateProfileModal" tabindex="-1" aria-labelledby="updateProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content item-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="updateProfileModalLabel">
                    <i class="fa-light fa-edit"></i>
                    Edit Profile Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="updateProfileForm" action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @if (session('profile_update_errors'))
                    <div class="alert alert-danger">Please fix the following errors.</div>
                    @endif

                    <h6 class="user-section-title mb-3 border-bottom pb-2"><i class="fas fa-user-circle me-1"></i> Core Details</h6>
                    <div class="row">
                        <div class="col-md-6">
                            {{-- Full Name --}}
                            <div class="form-group mb-4">
                                <label class="form-label" for="profileName"><i class="fas fa-user-tag"></i> Full Name</label>
                                <input type="text" class="form-control item-input @error('name') is-invalid @enderror" id="profileName" name="name" placeholder="Enter full name" value="{{ Auth::user()->name }}" required />
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Username (Unique) --}}
                            <div class="form-group mb-4">
                                <label class="form-label" for="profileUsername"><i class="fas fa-user"></i> Username</label>
                                <input type="text" class="form-control item-input @error('username') is-invalid @enderror" id="profileUsername" name="username" placeholder="Enter unique username" value="{{ Auth::user()->username }}" required />
                                @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Email (Unique) --}}
                            <div class="form-group mb-4">
                                <label class="form-label" for="profileEmail"><i class="fa-light fa-envelope"></i> Email Address</label>
                                <input type="email" class="form-control item-input @error('email') is-invalid @enderror" id="profileEmail" name="email" placeholder="Enter unique email address" value="{{ Auth::user()->email }}" required />
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                        </div>

                        <div class="col-md-6">
                            {{-- Phone Number --}}
                            <div class="form-group mb-4">
                                <label class="form-label" for="profilePhone"><i class="fa-light fa-phone"></i> Phone Number</label>
                                <input type="text" class="form-control item-input @error('phone') is-invalid @enderror" id="profilePhone" name="phone" placeholder="Enter phone number" value="{{ Auth::user()->phone }}" />
                                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Address --}}
                            <div class="form-group mb-4">
                                <label class="form-label" for="profileAddress"><i class="fa-light fa-location-dot"></i> Address</label>
                                <input type="text" class="form-control item-input @error('address') is-invalid @enderror" id="profileAddress" name="address" placeholder="Enter physical address" value="{{ Auth::user()->address }}" />
                                @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Job Title --}}
                            <div class="form-group mb-4">
                                <label class="form-label" for="profileJobs"><i class="fas fa-briefcase"></i> Job Title</label>
                                <input type="text" class="form-control item-input @error('jobs') is-invalid @enderror" id="profileJobs" name="jobs" placeholder="e.g., IoT Engineer" value="{{ Auth::user()->jobs }}" />
                                @error('jobs') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Company --}}
                            <div class="form-group mb-4">
                                <label class="form-label" for="profileCompany"><i class="fas fa-building"></i> Company</label>
                                <input type="text" class="form-control item-input @error('company') is-invalid @enderror" id="profileCompany" name="company" placeholder="e.g., GreenTech-Commerce" value="{{ Auth::user()->company }}" />
                                @error('company') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- School --}}
                            <div class="form-group mb-4">
                                <label class="form-label" for="profileSchool"><i class="fas fa-graduation-cap"></i> School/University</label>
                                <input type="text" class="form-control item-input @error('school') is-invalid @enderror" id="profileSchool" name="school" placeholder="e.g., FPT University" value="{{ Auth::user()->school }}" />
                                @error('school') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h6 class="user-section-title mb-3 border-bottom pb-2"><i class="fas fa-images me-1"></i> Picture Updates (Max 2MB)</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="profileAvatar"><i class="fas fa-image"></i> Profile Picture (Avatar)</label>
                                <input type="file" class="form-control item-input @error('avatar') is-invalid @enderror" id="profileAvatar" name="avatar" accept="image/*" />
                                <small class="form-text text-muted">Current Avatar: <span id="currentAvatarName">{{ Str::limit(Auth::user()->avatar, 30) ?? 'Default' }}</span></small>
                                @error('avatar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div id="currentAvatarPreview" class="mt-3" style="display: none;">
                                <label class="form-label">Current:</label>
                                <div class="current-logo-container">
                                    <img id="currentAvatarImage" src="" alt="Current Avatar" class="current-logo-preview">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="profileBackground"><i class="fas fa-camera"></i> Profile Background Image</label>
                                <input type="file" class="form-control item-input @error('background') is-invalid @enderror" id="profileBackground" name="background" accept="image/*" />
                                <small class="form-text text-muted">Current Background: <span id="currentBackgroundName">{{ Str::limit(Auth::user()->background, 30) ?? 'Default' }}</span></small>
                                @error('background') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div id="currentBackgroundPreview" class="mt-3" style="display: none;">
                                <label class="form-label">Current:</label>
                                <div class="current-logo-container">
                                    <img id="currentBackgroundImage" src="" alt="Current Background" class="current-logo-preview">
                                </div>
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
                <button type="submit" form="updateProfileForm" class="btn btn-action" id="profileSubmitBtn">
                    <i class="fa-light fa-save"></i>
                    <span class="btn-text">Save Changes</span>
                    <span class="btn-loading" style="display: none;">
                        <i class="fa-light fa-spinner fa-spin"></i>
                        Saving...
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modalElement = document.getElementById('updateProfileModal');

        modalElement.addEventListener('show.bs.modal', function() {
            const user = @json(Auth::user()); 
            const baseStorageUrl = "{{ asset('storage') }}"; 
            
            const currentAvatarPreview = document.getElementById('currentAvatarPreview');
            const currentAvatarImage = document.getElementById('currentAvatarImage');
            const currentBackgroundPreview = document.getElementById('currentBackgroundPreview');
            const currentBackgroundImage = document.getElementById('currentBackgroundImage');

            if (user.avatar) {
                currentAvatarImage.src = baseStorageUrl + '/app/public/' + user.avatar; 
                currentAvatarPreview.style.display = 'block';
            } else {
                currentAvatarPreview.style.display = 'none';
            }
            
            if (user.background) {
                currentBackgroundImage.src = baseStorageUrl + '/app/public/' + user.background;
                currentBackgroundPreview.style.display = 'block';
            } else {
                currentBackgroundPreview.style.display = 'none';
            }

        });
    });
</script>   