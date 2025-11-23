@extends('layouts.app')

@section('content')
<div class="auth-container">
    <div class="auth-regis-background"></div>

    <div class="auth-card">
        <div class="auth-regis-welcome">
            <div class="welcome-overlay"></div>
            <div class="welcome-content">
                <h1>Welcome to NewsMart</h1>
                <p class="welcome-motto">{{ 'Igniting Minds, Fueling Markets!' }}</p>
            </div>
        </div>

        <div class="auth-form-section">
            <div class="auth-form-header">
                <a href="{{ route('login') }}" class="register-link">
                    &gt; Login
                </a>
                <h2 class="auth-form-title">{{ __('Register') }}</h2>
            </div>

            <form method="POST" action="{{ route('register') }}" class="auth-form" id="registerForm">
                @csrf

                <div class="auth-input-group">
                    <i class="fas fa-user-circle auth-input-icon"></i> <input
                        id="name"
                        type="text"
                        name="name"
                        placeholder="{{ __('Name') }}"
                        value="{{ old('name') }}"
                        class="auth-input @error('name') auth-input-error @enderror"
                        required
                        autocomplete="name"
                        autofocus
                    >
                </div>

                <div class="auth-input-group">
                    <i class="fas fa-envelope auth-input-icon"></i> <input
                        id="email"
                        type="email"
                        name="email"
                        placeholder="{{ __('Email Address') }}"
                        value="{{ old('email') }}"
                        class="auth-input @error('email') auth-input-error @enderror"
                        required
                        autocomplete="email"
                    >
                </div>

                <div class="auth-input-group">
                    <i class="fas fa-lock auth-input-icon"></i> <input
                        id="password"
                        type="password"
                        name="password"
                        placeholder="{{ __('Password') }}"
                        class="auth-input @error('password') auth-input-error @enderror"
                        required
                        autocomplete="new-password"
                    >
                </div>

                <div class="auth-input-group">
                    <i class="fas fa-lock auth-input-icon"></i> <input
                        id="password-confirm"
                        type="password"
                        name="password_confirmation"
                        placeholder="{{ __('Confirm Password') }}"
                        class="auth-input"
                        required
                        autocomplete="new-password"
                    >
                </div>

                <button type="submit" class="auth-btn-login mt-3" id="registerButton" disabled>
                    <span class="btn-text">{{ __('Register') }}</span>
                    <span class="btn-loading">
                        <i class="fas fa-spinner fa-spin"></i>
                    </span>
                </button>
            </form>

            @error('name')
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
            @error('password')
                <div class="auth-message auth-error">
                    <i class="fas fa-exclamation-triangle"></i>
                    {{ $message }}
                </div>
            @enderror
            
            <p class="auth-register-text">
                Already have an account? 
                <a href="{{ route('login') }}" class="auth-link">
                    Log In
                </a>
            </p>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registerForm');
    const button = document.getElementById('registerButton');
    const inputs = form.querySelectorAll('.auth-input');

    // Enable button only when all required fields are filled
    function checkFormValidity() {
        const nameInput = form.querySelector('input[name="name"]');
        const emailInput = form.querySelector('input[name="email"]');
        const passwordInput = form.querySelector('input[name="password"]');
        const confirmPasswordInput = form.querySelector('input[name="password_confirmation"]');
        
        const isValid = nameInput.value.trim() !== '' && 
                        emailInput.value.trim() !== '' && 
                        passwordInput.value.trim() !== '' &&
                        confirmPasswordInput.value.trim() !== '';

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