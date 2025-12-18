@extends('layouts.app')

@section('title', 'Đổi Mật Khẩu')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-header d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="page-title">
                        <i class="fas fa-key text-primary me-2"></i>
                        Đổi Mật Khẩu
                    </h1>
                    <p class="page-description text-muted">
                        Cập nhật mật khẩu để bảo vệ tài khoản của bạn
                    </p>
                </div>
                <div class="page-actions">
                    <a href="{{ route('user.profile', $user->id) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Quay lại hồ sơ
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Security Warning -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-warning">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
                    <div>
                        <h5 class="alert-heading mb-1">Lưu Ý Về Bảo Mật</h5>
                        <p class="mb-0">
                            Để bảo vệ tài khoản của bạn, hãy sử dụng mật khẩu mạnh với ít nhất 8 ký tự, 
                            bao gồm chữ cái, số và ký tự đặc biệt. Không chia sẻ mật khẩu với ai khác.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Password Change Form -->
        <div class="col-lg-8">
            <div class="form-card">
                <div class="form-card-header">
                    <h5 class="form-card-title">
                        <i class="fas fa-lock me-2"></i>
                        Thay Đổi Mật Khẩu
                    </h5>
                </div>
                <div class="form-card-body">
                    <form action="{{ route('user.change-password', $user->id) }}" 
                          method="POST" 
                          class="needs-validation" 
                          novalidate 
                          id="passwordChangeForm">
                        @csrf
                        @method('PUT')
                        
                        <!-- Current Password -->
                        <div class="form-section">
                            <h6 class="form-section-title">
                                <i class="fas fa-key me-2"></i>
                                Mật Khẩu Hiện Tại
                            </h6>
                            <div class="form-group">
                                <label for="current_password" class="form-label required">
                                    Mật Khẩu Hiện Tại <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control @error('current_password') is-invalid @enderror" 
                                           id="current_password" 
                                           name="current_password" 
                                           placeholder="Nhập mật khẩu hiện tại"
                                           required>
                                    <button class="btn btn-outline-secondary" 
                                            type="button" 
                                            onclick="togglePassword('current_password')">
                                        <i class="fas fa-eye" id="current_password-icon"></i>
                                    </button>
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- New Password -->
                        <div class="form-section">
                            <h6 class="form-section-title">
                                <i class="fas fa-key me-2"></i>
                                Mật Khẩu Mới
                            </h6>
                            <div class="form-group">
                                <label for="new_password" class="form-label required">
                                    Mật Khẩu Mới <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control @error('new_password') is-invalid @enderror" 
                                           id="new_password" 
                                           name="new_password" 
                                           placeholder="Nhập mật khẩu mới"
                                           required>
                                    <button class="btn btn-outline-secondary" 
                                            type="button" 
                                            onclick="togglePassword('new_password')">
                                        <i class="fas fa-eye" id="new_password-icon"></i>
                                    </button>
                                    @error('new_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Mật khẩu phải có ít nhất 8 ký tự
                                </div>
                            </div>

                            <!-- Password Strength Indicator -->
                            <div class="password-strength" id="passwordStrength">
                                <div class="strength-label">Độ mạnh mật khẩu:</div>
                                <div class="strength-bar">
                                    <div class="strength-fill" id="strengthFill"></div>
                                </div>
                                <div class="strength-text" id="strengthText">
                                    Nhập mật khẩu để xem độ mạnh
                                </div>
                            </div>

                            <!-- Password Requirements -->
                            <div class="password-requirements mt-3">
                                <h6 class="requirements-title">Mật khẩu phải có:</h6>
                                <ul class="requirements-list" id="requirementsList">
                                    <li class="requirement" id="req-length">
                                        <i class="fas fa-times text-danger me-2"></i>
                                        Ít nhất 8 ký tự
                                    </li>
                                    <li class="requirement" id="req-uppercase">
                                        <i class="fas fa-times text-danger me-2"></i>
                                        Ít nhất 1 chữ hoa (A-Z)
                                    </li>
                                    <li class="requirement" id="req-lowercase">
                                        <i class="fas fa-times text-danger me-2"></i>
                                        Ít nhất 1 chữ thường (a-z)
                                    </li>
                                    <li class="requirement" id="req-number">
                                        <i class="fas fa-times text-danger me-2"></i>
                                        Ít nhất 1 chữ số (0-9)
                                    </li>
                                    <li class="requirement" id="req-special">
                                        <i class="fas fa-times text-danger me-2"></i>
                                        Ít nhất 1 ký tự đặc biệt (!@#$%^&*)
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Confirm New Password -->
                        <div class="form-section">
                            <h6 class="form-section-title">
                                <i class="fas fa-check me-2"></i>
                                Xác Nhận Mật Khẩu
                            </h6>
                            <div class="form-group">
                                <label for="new_password_confirmation" class="form-label required">
                                    Xác Nhận Mật Khẩu Mới <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control" 
                                           id="new_password_confirmation" 
                                           name="new_password_confirmation" 
                                           placeholder="Nhập lại mật khẩu mới"
                                           required>
                                    <button class="btn btn-outline-secondary" 
                                            type="button" 
                                            onclick="togglePassword('new_password_confirmation')">
                                        <i class="fas fa-eye" id="new_password_confirmation-icon"></i>
                                    </button>
                                    <div class="invalid-feedback">
                                        Vui lòng xác nhận mật khẩu mới
                                    </div>
                                </div>
                                <div class="password-match mt-2" id="passwordMatch">
                                    <i class="fas fa-times text-danger me-2"></i>
                                    <span>Mật khẩu xác nhận chưa khớp</span>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="form-actions">
                            <div class="d-flex justify-content-between">
                                <div class="form-actions-left">
                                    <button type="button" class="btn btn-outline-info" onclick="generatePassword()">
                                        <i class="fas fa-magic me-2"></i>Tạo mật khẩu ngẫu nhiên
                                    </button>
                                </div>
                                <div class="form-actions-right">
                                    <a href="{{ route('user.profile', $user->id) }}" class="btn btn-outline-secondary me-2">
                                        <i class="fas fa-times me-2"></i>Hủy
                                    </a>
                                    <button type="submit" class="btn btn-primary" id="submitBtn" disabled>
                                        <i class="fas fa-save me-2"></i>Cập Nhật Mật Khẩu
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Security Tips & Information -->
        <div class="col-lg-4">
            <!-- User Info -->
            <div class="info-card mb-4">
                <div class="info-card-header">
                    <h6 class="info-card-title">
                        <i class="fas fa-user me-2"></i>
                        Thông Tin Tài Khoản
                    </h6>
                </div>
                <div class="info-card-body">
                    <div class="user-info-mini">
                        <div class="info-item">
                            <span class="info-label">Tên đăng nhập:</span>
                            <span class="info-value">{{ $user->username }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Email:</span>
                            <span class="info-value">{{ $user->email }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Vai trò:</span>
                            <span class="info-value">
                                @if($user->role)
                                    {{ $user->role->name }}
                                @else
                                    Khách hàng
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Security Tips -->
            <div class="tips-card mb-4">
                <div class="tips-card-header">
                    <h6 class="tips-card-title">
                        <i class="fas fa-lightbulb me-2"></i>
                        Mẹo Bảo Mật
                    </h6>
                </div>
                <div class="tips-card-body">
                    <div class="security-tip">
                        <i class="fas fa-shield-alt text-success me-2"></i>
                        <div>
                            <strong>Sử dụng mật khẩu duy nhất</strong>
                            <p class="tip-text">Không sử dụng cùng một mật khẩu cho nhiều tài khoản khác nhau</p>
                        </div>
                    </div>
                    <div class="security-tip">
                        <i class="fas fa-sync-alt text-info me-2"></i>
                        <div>
                            <strong>Thay đổi định kỳ</strong>
                            <p class="tip-text">Nên thay đổi mật khẩu ít nhất 3 tháng một lần</p>
                        </div>
                    </div>
                    <div class="security-tip">
                        <i class="fas fa-eye text-warning me-2"></i>
                        <div>
                            <strong>Không chia sẻ</strong>
                            <p class="tip-text">Không bao giờ chia sẻ mật khẩu với người khác, kể cả người thân</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Password Examples -->
            <div class="examples-card">
                <div class="examples-card-header">
                    <h6 class="examples-card-title">
                        <i class="fas fa-key me-2"></i>
                        Ví Dụ Mật Khẩu Mạnh
                    </h6>
                </div>
                <div class="examples-card-body">
                    <div class="password-example">
                        <code>MyP@ssw0rd2024!</code>
                    </div>
                    <div class="password-example">
                        <code>Secure#Login@123</code>
                    </div>
                    <div class="password-example">
                        <code>Strong$Pass99!</code>
                    </div>
                    <p class="examples-note mt-3">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Các mật khẩu này chỉ là ví dụ. Vui lòng tạo mật khẩu riêng cho bạn.
                        </small>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('javascript')
<script>
// Password visibility toggle
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '-icon');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Password strength checker
function checkPasswordStrength(password) {
    let score = 0;
    let feedback = [];
    
    // Length check
    if (password.length >= 8) score += 20;
    else feedback.push('Ít nhất 8 ký tự');
    
    // Uppercase check
    if (/[A-Z]/.test(password)) score += 20;
    else feedback.push('Chữ hoa');
    
    // Lowercase check
    if (/[a-z]/.test(password)) score += 20;
    else feedback.push('Chữ thường');
    
    // Number check
    if (/[0-9]/.test(password)) score += 20;
    else feedback.push('Chữ số');
    
    // Special character check
    if (/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)) score += 20;
    else feedback.push('Ký tự đặc biệt');
    
    return { score, feedback };
}

// Update password strength indicator
function updatePasswordStrength() {
    const password = document.getElementById('new_password').value;
    const strengthFill = document.getElementById('strengthFill');
    const strengthText = document.getElementById('strengthText');
    
    if (!password) {
        strengthFill.style.width = '0%';
        strengthText.textContent = 'Nhập mật khẩu để xem độ mạnh';
        return;
    }
    
    const { score } = checkPasswordStrength(password);
    strengthFill.style.width = score + '%';
    
    if (score < 40) {
        strengthFill.className = 'strength-fill strength-weak';
        strengthText.textContent = 'Yếu';
        strengthText.className = 'strength-text text-danger';
    } else if (score < 80) {
        strengthFill.className = 'strength-fill strength-medium';
        strengthText.textContent = 'Trung bình';
        strengthText.className = 'strength-text text-warning';
    } else {
        strengthFill.className = 'strength-fill strength-strong';
        strengthText.textContent = 'Mạnh';
        strengthText.className = 'strength-text text-success';
    }
}

// Update password requirements
function updatePasswordRequirements() {
    const password = document.getElementById('new_password').value;
    const requirements = {
        'req-length': password.length >= 8,
        'req-uppercase': /[A-Z]/.test(password),
        'req-lowercase': /[a-z]/.test(password),
        'req-number': /[0-9]/.test(password),
        'req-special': /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)
    };
    
    for (const [id, isValid] of Object.entries(requirements)) {
        const element = document.getElementById(id);
        const icon = element.querySelector('i');
        
        if (isValid) {
            icon.className = 'fas fa-check text-success me-2';
            element.classList.remove('requirement-invalid');
            element.classList.add('requirement-valid');
        } else {
            icon.className = 'fas fa-times text-danger me-2';
            element.classList.remove('requirement-valid');
            element.classList.add('requirement-invalid');
        }
    }
}

// Check password match
function checkPasswordMatch() {
    const password = document.getElementById('new_password').value;
    const confirmation = document.getElementById('new_password_confirmation').value;
    const matchElement = document.getElementById('passwordMatch');
    
    if (!confirmation) {
        matchElement.style.display = 'none';
        return false;
    }
    
    matchElement.style.display = 'flex';
    
    if (password === confirmation) {
        matchElement.innerHTML = '<i class="fas fa-check text-success me-2"></i><span>Mật khẩu xác nhận khớp</span>';
        matchElement.className = 'password-match password-match-success';
        return true;
    } else {
        matchElement.innerHTML = '<i class="fas fa-times text-danger me-2"></i><span>Mật khẩu xác nhận chưa khớp</span>';
        matchElement.className = 'password-match password-match-error';
        return false;
    }
}

// Update submit button state
function updateSubmitButton() {
    const currentPassword = document.getElementById('current_password').value;
    const newPassword = document.getElementById('new_password').value;
    const confirmation = document.getElementById('new_password_confirmation').value;
    const submitBtn = document.getElementById('submitBtn');
    
    const { score } = checkPasswordStrength(newPassword);
    const isPasswordMatch = checkPasswordMatch();
    const isFormValid = currentPassword && newPassword && confirmation && 
                       score >= 40 && isPasswordMatch;
    
    submitBtn.disabled = !isFormValid;
}

// Generate random password
function generatePassword() {
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*';
    let password = '';
    
    // Ensure at least one character from each category
    const uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'[Math.floor(Math.random() * 26)];
    const lowercase = 'abcdefghijklmnopqrstuvwxyz'[Math.floor(Math.random() * 26)];
    const number = '0123456789'[Math.floor(Math.random() * 10)];
    const special = '!@#$%^&*'[Math.floor(Math.random() * 8)];
    
    password += uppercase + lowercase + number + special;
    
    // Fill the rest randomly
    for (let i = 4; i < 12; i++) {
        password += chars[Math.floor(Math.random() * chars.length)];
    }
    
    // Shuffle the password
    password = password.split('').sort(() => Math.random() - 0.5).join('');
    
    document.getElementById('new_password').value = password;
    document.getElementById('new_password_confirmation').value = password;
    
    updatePasswordStrength();
    updatePasswordRequirements();
    checkPasswordMatch();
    updateSubmitButton();
}

// Event listeners
document.getElementById('current_password').addEventListener('input', updateSubmitButton);
document.getElementById('new_password').addEventListener('input', function() {
    updatePasswordStrength();
    updatePasswordRequirements();
    checkPasswordMatch();
    updateSubmitButton();
});
document.getElementById('new_password_confirmation').addEventListener('input', function() {
    checkPasswordMatch();
    updateSubmitButton();
});

// Form submission
document.getElementById('passwordChangeForm').addEventListener('submit', function(e) {
    const currentPassword = document.getElementById('current_password').value;
    const newPassword = document.getElementById('new_password').value;
    const confirmation = document.getElementById('new_password_confirmation').value;
    
    if (!currentPassword || !newPassword || !confirmation) {
        e.preventDefault();
        alert('Vui lòng điền đầy đủ thông tin!');
        return false;
    }
    
    if (newPassword !== confirmation) {
        e.preventDefault();
        alert('Mật khẩu xác nhận không khớp!');
        return false;
    }
    
    const { score } = checkPasswordStrength(newPassword);
    if (score < 40) {
        e.preventDefault();
        alert('Mật khẩu mới quá yếu! Vui lòng chọn mật khẩu mạnh hơn.');
        return false;
    }
    
    const confirmMsg = 'Bạn có chắc chắn muốn thay đổi mật khẩu? Sau khi thay đổi, bạn sẽ cần sử dụng mật khẩu mới để đăng nhập.';
    if (!confirm(confirmMsg)) {
        e.preventDefault();
        return false;
    }
});

// Bootstrap form validation
(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();
</script>
@endpush

<style>
.password-strength {
    margin-top: 1rem;
}

.strength-bar {
    height: 8px;
    background-color: #e9ecef;
    border-radius: 4px;
    overflow: hidden;
    margin: 0.5rem 0;
}

.strength-fill {
    height: 100%;
    transition: all 0.3s ease;
    border-radius: 4px;
}

.strength-weak {
    background-color: #dc3545;
    width: 40%;
}

.strength-medium {
    background-color: #ffc107;
    width: 70%;
}

.strength-strong {
    background-color: #28a745;
    width: 100%;
}

.strength-text {
    font-size: 0.875rem;
    font-weight: 500;
}

.password-requirements {
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
    padding: 1rem;
}

.requirements-title {
    font-size: 0.875rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #495057;
}

.requirements-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.requirement {
    font-size: 0.875rem;
    padding: 0.25rem 0;
    transition: all 0.2s ease;
}

.requirement-valid {
    color: #28a745;
}

.requirement-invalid {
    color: #dc3545;
}

.password-match {
    display: none;
    align-items: center;
    font-size: 0.875rem;
    padding: 0.5rem;
    border-radius: 0.25rem;
    margin-top: 0.5rem;
}

.password-match-success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.password-match-error {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.security-tip {
    display: flex;
    align-items: flex-start;
    margin-bottom: 1rem;
    padding: 0.75rem;
    background-color: #f8f9fa;
    border-radius: 0.375rem;
}

.tip-text {
    font-size: 0.875rem;
    margin: 0.25rem 0 0 0;
    color: #6c757d;
}

.password-example {
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 0.25rem;
    padding: 0.5rem;
    margin-bottom: 0.5rem;
    font-family: 'Courier New', monospace;
    font-size: 0.875rem;
}

.examples-note {
    font-size: 0.75rem;
}
</style>
@endsection