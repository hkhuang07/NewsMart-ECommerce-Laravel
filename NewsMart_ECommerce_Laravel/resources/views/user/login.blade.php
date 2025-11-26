@extends('layouts.app')

@section('content')
<div class="auth-container">
    <!-- Background với hiệu ứng gradient và blur -->
    <div class="auth-background"></div>

    <div class="auth-card">
        <!-- Phần bên trái - Chào mừng và slogan -->
        <div class="auth-welcome">
            <div class="welcome-overlay"></div>
            <div class="welcome-content">
                <h1>Welcome to NewsMart</h1>
                <p class="welcome-motto">{{ 'Igniting Minds, Fueling Markets!' }}</p>
            </div>
        </div>

        <!-- Phần bên phải - Form Đăng nhập -->
        <div class="auth-form-section">
            <div class="auth-form-header">
                <a href="{{ route('register') }}" class="register-link">
                    &gt; Register
                </a>
                <h2 class="auth-form-title">Login</h2>
            </div>

            <form method="POST" action="{{ route('login') }}" class="auth-form" id="loginForm">
                @csrf

                <!-- Trường Username/Email -->
                <div class="auth-input-group">
                    <i class="fas fa-user auth-input-icon"></i>
                    <input
                        type="text"
                        name="login"
                        placeholder="Username or Email"
                        value="{{ old('login') }}"
                        class="auth-input @error('login') auth-input-error @enderror"
                        required
                        autocomplete="login"
                        autofocus
                    >
                </div>

                <!-- Trường Password -->
                <div class="auth-input-group">
                    <i class="fas fa-lock auth-input-icon"></i>
                    <input
                        type="password"
                        name="password"
                        placeholder="Password"
                        class="auth-input @error('password') auth-input-error @enderror"
                        required
                        autocomplete="current-password"
                    >
                </div>

                <!-- Liên kết đổi mật khẩu -->
                <div class="auth-form-links">
                    <a href="{{ route('password.request') }}" class="auth-link">
                        Forgot Password?
                    </a>
                </div>

                <!-- Remember Me -->
                <div class="auth-remember">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember" class="auth-remember-label">Remember Me</label>
                </div>

                <!-- Nút Login -->
                <button type="submit" class="auth-btn-login" id="loginButton" disabled>
                    <span class="btn-text">Log In</span>
                    <span class="btn-loading">
                        <i class="fas fa-spinner fa-spin"></i>
                    </span>
                </button>
            </form>

            <!-- Error Messages -->
            @error('login')
                <div class="auth-message auth-error">
                    <i class="fas fa-exclamation-triangle"></i>
                    {{ $message }}
                </div>
            @enderror

            @error('password')
                <div class="auth-message auth-error">
                    <i class="fas fa-exclamation-triangle"></i>
                    {{ $message }}
                </div>
            @enderror

            @error('email')
                <div class="auth-message auth-error">
                    <i class="fas fa-exclamation-triangle"></i>
                    {{ $message }}
                </div>
            @enderror

            <!-- Success Messages -->
            @if (session('status'))
                <div class="auth-message auth-success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('status') }}
                </div>
            @endif

            @if (session('success'))
                <div class="auth-message auth-success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Register Link -->
            <p class="auth-register-text">
                Don't have an account yet? 
                <a href="{{ route('register') }}" class="auth-link">
                    Sign Up
                </a>
            </p>
        </div>
    </div>
</div>

<!-- JavaScript for form handling -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('loginForm');
    const button = document.getElementById('loginButton');
    const inputs = form.querySelectorAll('.auth-input');

    // Enable button only when all required fields are filled
    function checkFormValidity() {
        const loginInput = form.querySelector('input[name="login"]');
        const passwordInput = form.querySelector('input[name="password"]');
        
        const isValid = loginInput.value.trim() !== '' && passwordInput.value.trim() !== '';
        button.disabled = !isValid;
    }

    // Check validity on input
    inputs.forEach(input => {
        input.addEventListener('input', checkFormValidity);
        input.addEventListener('change', checkFormValidity);
    });

    // Initial check
    checkFormValidity();

    // Form submission handling
    form.addEventListener('submit', function(e) {
        button.disabled = true;
        button.classList.add('auth-btn-loading');
    });

    // Auto-hide messages after 5 seconds
    const messages = document.querySelectorAll('.auth-message');
    messages.forEach(message => {
        setTimeout(() => {
            message.style.opacity = '0';
            setTimeout(() => {
                message.style.display = 'none';
            }, 300);
        }, 5000);
    });
});
</script>
@endsection