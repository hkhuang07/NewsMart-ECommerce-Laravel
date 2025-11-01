@extends('layouts.app')

@section('title', 'Hồ Sơ Cá Nhân')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-header d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="page-title">
                        <i class="fas fa-user-circle text-primary me-2"></i>
                        Hồ Sơ Cá Nhân
                    </h1>
                    <p class="page-description text-muted">
                        Xem và cập nhật thông tin hồ sơ cá nhân của bạn
                    </p>
                </div>
                <div class="page-actions">
                    <a href="{{ route('user') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Quay lại danh sách
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="profile-header-card">
                <div class="row align-items-center">
                    <div class="col-md-3 text-center">
                        <div class="profile-avatar">
                            @if($user->avatar)
                                <img src="{{ asset('public/images/avatars/' . $user->avatar) }}" 
                                     alt="{{ $user->name }}" class="avatar-large">
                            @else
                                <div class="avatar-placeholder-large">
                                    <i class="fas fa-user fa-5x text-muted"></i>
                                </div>
                            @endif
                            <div class="avatar-status {{ $user->isactive ? 'online' : 'offline' }}">
                                <i class="fas fa-circle"></i>
                            </div>
                        </div>
                        <button class="btn btn-outline-primary btn-sm mt-3" 
                                onclick="document.getElementById('avatar-upload').click()">
                            <i class="fas fa-camera me-2"></i>Thay đổi ảnh
                        </button>
                        <input type="file" id="avatar-upload" accept="image/*" style="display: none;">
                    </div>
                    <div class="col-md-6">
                        <div class="profile-info">
                            <h2 class="profile-name">{{ $user->fullname ?? $user->name }}</h2>
                            <p class="profile-username">@{{ $user->username }}</p>
                            <div class="profile-badges">
                                <span class="role-badge role-{{ strtolower($user->role->name ?? 'user') }}">
                                    @if($user->role)
                                        <i class="fas fa-user-tag me-1"></i>{{ $user->role->name }}
                                    @else
                                        <i class="fas fa-user me-1"></i>Khách hàng
                                    @endif
                                </span>
                                <span class="status-badge {{ $user->isactive ? 'active' : 'inactive' }}">
                                    <i class="fas fa-circle me-1"></i>
                                    {{ $user->isactive ? 'Đang hoạt động' : 'Đã vô hiệu hóa' }}
                                </span>
                            </div>
                            <div class="profile-meta">
                                <div class="meta-item">
                                    <i class="fas fa-envelope me-2"></i>
                                    <span>{{ $user->email }}</span>
                                </div>
                                @if($user->phone)
                                <div class="meta-item">
                                    <i class="fas fa-phone me-2"></i>
                                    <span>{{ $user->phone }}</span>
                                </div>
                                @endif
                                @if($user->address)
                                <div class="meta-item">
                                    <i class="fas fa-map-marker-alt me-2"></i>
                                    <span>{{ $user->address }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="profile-stats text-end">
                            <div class="stat-item">
                                <div class="stat-number">{{ $user->created_at->diffForHumans() }}</div>
                                <div class="stat-label">Tham gia</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">{{ $user->ordersAsCustomer->count() }}</div>
                                <div class="stat-label">Đơn hàng</div>
                            </div>
                            @if($user->role && in_array($user->role->id, [4, 5]))
                            <div class="stat-item">
                                <div class="stat-number">
                                    @if($user->role->id == 4)
                                        {{ $user->productsAsSaler->count() }}
                                    @elseif($user->role->id == 5)
                                        {{ $user->shipperAssignments->count() }}
                                    @else
                                        0
                                    @endif
                                </div>
                                <div class="stat-label">
                                    @if($user->role->id == 4)
                                        Sản phẩm
                                    @elseif($user->role->id == 5)
                                        Đơn giao
                                    @else
                                        Hoạt động
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Content Tabs -->
    <div class="row">
        <div class="col-12">
            <div class="profile-tabs-card">
                <!-- Tab Navigation -->
                <ul class="nav nav-tabs profile-tabs-nav" id="profileTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" 
                                id="info-tab" 
                                data-bs-toggle="tab" 
                                data-bs-target="#info-pane" 
                                type="button" 
                                role="tab">
                            <i class="fas fa-user me-2"></i>
                            Thông Tin Cá Nhân
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" 
                                id="activity-tab" 
                                data-bs-toggle="tab" 
                                data-bs-target="#activity-pane" 
                                type="button" 
                                role="tab">
                            <i class="fas fa-history me-2"></i>
                            Lịch Sử Hoạt Động
                        </button>
                    </li>
                    @if(Auth::id() == $user->id)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" 
                                id="settings-tab" 
                                data-bs-toggle="tab" 
                                data-bs-target="#settings-pane" 
                                type="button" 
                                role="tab">
                            <i class="fas fa-cog me-2"></i>
                            Cài Đặt Tài Khoản
                        </button>
                    </li>
                    @endif
                </ul>

                <!-- Tab Content -->
                <div class="tab-content profile-tabs-content" id="profileTabsContent">
                    <!-- Profile Information Tab -->
                    <div class="tab-pane fade show active" id="info-pane" role="tabpanel">
                        <div class="tab-content-header">
                            <h5 class="tab-title">
                                <i class="fas fa-user me-2"></i>
                                Thông Tin Cá Nhân
                            </h5>
                            <p class="tab-description">Cập nhật thông tin cá nhân của bạn</p>
                        </div>

                        <form action="{{ route('user.profile', $user->id) }}" method="POST" class="profile-form">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="form-label">
                                            Tên Hiển Thị
                                        </label>
                                        <input type="text" 
                                               class="form-control @error('name') is-invalid @enderror" 
                                               id="name" 
                                               name="name" 
                                               value="{{ old('name', $user->name) }}">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="fullname" class="form-label">
                                            Họ và Tên Đầy Đủ
                                        </label>
                                        <input type="text" 
                                               class="form-control @error('fullname') is-invalid @enderror" 
                                               id="fullname" 
                                               name="fullname" 
                                               value="{{ old('fullname', $user->fullname) }}">
                                        @error('fullname')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" class="form-label">
                                            Email
                                        </label>
                                        <input type="email" 
                                               class="form-control @error('email') is-invalid @enderror" 
                                               id="email" 
                                               name="email" 
                                               value="{{ old('email', $user->email) }}">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone" class="form-label">
                                            Số Điện Thoại
                                        </label>
                                        <input type="tel" 
                                               class="form-control @error('phone') is-invalid @enderror" 
                                               id="phone" 
                                               name="phone" 
                                               value="{{ old('phone', $user->phone) }}">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="address" class="form-label">
                                    Địa Chỉ
                                </label>
                                <textarea class="form-control @error('address') is-invalid @enderror" 
                                          id="address" 
                                          name="address" 
                                          rows="3">{{ old('address', $user->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-actions">
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Lưu Thông Tin
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Activity History Tab -->
                    <div class="tab-pane fade" id="activity-pane" role="tabpanel">
                        <div class="tab-content-header">
                            <h5 class="tab-title">
                                <i class="fas fa-history me-2"></i>
                                Lịch Sử Hoạt Động
                            </h5>
                            <p class="tab-description">Theo dõi các hoạt động gần đây</p>
                        </div>

                        <div class="activity-timeline">
                            @forelse($user->userActivities()->latest()->limit(10)->get() as $activity)
                            <div class="activity-item">
                                <div class="activity-icon">
                                    @switch($activity->actiontype)
                                        @case('LOGIN')
                                            <i class="fas fa-sign-in-alt text-success"></i>
                                            @break
                                        @case('LOGOUT')
                                            <i class="fas fa-sign-out-alt text-danger"></i>
                                            @break
                                        @case('CREATE')
                                            <i class="fas fa-plus text-primary"></i>
                                            @break
                                        @case('UPDATE')
                                            <i class="fas fa-edit text-warning"></i>
                                            @break
                                        @case('DELETE')
                                            <i class="fas fa-trash text-danger"></i>
                                            @break
                                        @default
                                            <i class="fas fa-circle text-muted"></i>
                                    @endswitch
                                </div>
                                <div class="activity-content">
                                    <div class="activity-title">{{ $activity->actiontype }}</div>
                                    <div class="activity-description">
                                        @if($activity->details)
                                            {{ $activity->details }}
                                        @else
                                            Thực hiện hành động {{ strtolower($activity->actiontype) }}
                                        @endif
                                    </div>
                                    <div class="activity-meta">
                                        <span class="activity-time">
                                            <i class="fas fa-clock me-1"></i>
                                            {{ $activity->created_at->diffForHumans() }}
                                        </span>
                                        @if($activity->ipaddress)
                                        <span class="activity-ip">
                                            <i class="fas fa-globe me-1"></i>
                                            {{ $activity->ipaddress }}
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="no-activity">
                                <i class="fas fa-history fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Chưa có hoạt động nào được ghi nhận</p>
                            </div>
                            @endforelse
                        </div>

                        <div class="text-center mt-4">
                            <a href="{{ route('user.activities', $user->id) }}" class="btn btn-outline-primary">
                                <i class="fas fa-list me-2"></i>Xem tất cả hoạt động
                            </a>
                        </div>
                    </div>

                    @if(Auth::id() == $user->id)
                    <!-- Account Settings Tab -->
                    <div class="tab-pane fade" id="settings-pane" role="tabpanel">
                        <div class="tab-content-header">
                            <h5 class="tab-title">
                                <i class="fas fa-cog me-2"></i>
                                Cài Đặt Tài Khoản
                            </h5>
                            <p class="tab-description">Quản lý cài đặt và bảo mật tài khoản</p>
                        </div>

                        <div class="settings-sections">
                            <!-- Security Settings -->
                            <div class="settings-section">
                                <h6 class="settings-section-title">
                                    <i class="fas fa-shield-alt me-2"></i>
                                    Bảo Mật
                                </h6>
                                <div class="settings-item">
                                    <div class="settings-item-content">
                                        <div class="settings-item-title">Đổi Mật Khẩu</div>
                                        <div class="settings-item-description">
                                            Cập nhật mật khẩu để bảo vệ tài khoản
                                        </div>
                                    </div>
                                    <div class="settings-item-action">
                                        <a href="{{ route('user.change-password', $user->id) }}" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-key me-2"></i>Đổi mật khẩu
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Privacy Settings -->
                            <div class="settings-section">
                                <h6 class="settings-section-title">
                                    <i class="fas fa-eye me-2"></i>
                                    Quyền Riêng Tư
                                </h6>
                                <div class="settings-item">
                                    <div class="settings-item-content">
                                        <div class="settings-item-title">Hiển thị trạng thái online</div>
                                        <div class="settings-item-description">
                                            Cho phép người khác thấy trạng thái hoạt động của bạn
                                        </div>
                                    </div>
                                    <div class="settings-item-action">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="showOnlineStatus" checked>
                                            <label class="form-check-label" for="showOnlineStatus"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Notification Settings -->
                            <div class="settings-section">
                                <h6 class="settings-section-title">
                                    <i class="fas fa-bell me-2"></i>
                                    Thông Báo
                                </h6>
                                <div class="settings-item">
                                    <div class="settings-item-content">
                                        <div class="settings-item-title">Email notifications</div>
                                        <div class="settings-item-description">
                                            Nhận thông báo qua email về hoạt động tài khoản
                                        </div>
                                    </div>
                                    <div class="settings-item-action">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="emailNotifications" checked>
                                            <label class="form-check-label" for="emailNotifications"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('javascript')
<script>
// Avatar upload functionality
document.getElementById('avatar-upload').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const formData = new FormData();
        formData.append('avatar', file);
        formData.append('_token', '{{ csrf_token() }}');
        
        // Show loading
        const reader = new FileReader();
        reader.onload = function(e) {
            document.querySelector('.avatar-large').src = e.target.result;
        };
        reader.readAsDataURL(file);
        
        // TODO: Upload to server
        console.log('Avatar upload functionality needs to be implemented');
    }
});

// Phone number validation
document.getElementById('phone').addEventListener('input', function() {
    this.value = this.value.replace(/[^0-9+]/g, '');
});

// Auto-save functionality (optional)
let autoSaveTimeout;
document.querySelectorAll('.profile-form input, .profile-form textarea').forEach(input => {
    input.addEventListener('input', function() {
        clearTimeout(autoSaveTimeout);
        autoSaveTimeout = setTimeout(function() {
            // Auto-save logic can be added here
            console.log('Auto-save triggered');
        }, 2000);
    });
});

// Tab functionality enhancement
document.querySelectorAll('[data-bs-toggle="tab"]').forEach(tab => {
    tab.addEventListener('shown.bs.tab', function (e) {
        const targetPane = e.target.getAttribute('data-bs-target');
        console.log('Tab switched to:', targetPane);
    });
});
</script>
@endpush
@endsection