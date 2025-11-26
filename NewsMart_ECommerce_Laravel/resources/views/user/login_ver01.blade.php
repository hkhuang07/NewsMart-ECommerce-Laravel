@extends('layouts.app')

@section('styles')
<link href="{{ asset('css/auth.css') }}" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@endsection

@section('content')
@php
$motto = "Igniting Minds, Fueling Markets.";
@endphp

<div class="d-flex align-items-center justify-content-center min-vh-100 p-4 full-screen-bg">
    <div class="row login-container">
        <div class="col-md-6 d-none d-md-flex align-items-center justify-content-center left-panel">

            <div class="left-overlay"></div>

            <div class="position-relative text-center text-light p-2" style="z-index: 10;">
                <h1 class="h6 font-weight-bold mb-1">Welcome to NewsMart</h1>
                <p class="text-xs text-info font-italic font-weight-light">{{ $motto }}</p>
            </div>
        </div>

        <div class="col-12 col-md-6 right-panel">
            <div class="d-flex justify-content-end mb-2">
                <a href="{{ route('register') }}" class="text-secondary hover-white transition-colors small" style="text-decoration: none;">
                    &gt; Register
                </a>
            </div>

            <h2 class="h4 font-weight-semibold text-center mb-4">Login</h2>

            @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show small" role="alert">
                {{ session('status') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            @endif


            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show small font-weight-bold text-center p-1" role="alert">
                {{ $errors->first('login') ?: $errors->first('password') ?: 'Login failed. Please check your credentials.' }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="position-relative mb-3">
                    <i class="fa fa-user icon-absolute"></i>
                    <input id="login" type="text" placeholder="Username or Email"
                        class="form-control form-control-custom @error('login') is-invalid @enderror"
                        name="login" value="{{ old('login') }}" required autocomplete="login" autofocus>
                </div>

                <div class="position-relative mb-3">
                    <i class="fa fa-lock icon-absolute"></i>
                    <input id="password" type="password" placeholder="Password"
                        class="form-control form-control-custom @error('password') is-invalid @enderror"
                        name="password" required autocomplete="current-password">
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="form-check small">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label text-gray-400" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                    @if (Route::has('password.request'))
                    <a class="text-secondary" href="{{ route('password.request') }}" style="text-decoration: none;">
                        {{ __('Forgot Your Password?') }}
                    </a>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary btn-custom-gradient w-100 d-flex align-items-center justify-content-center">
                    {{ __('Log In') }}
                </button>
            </form>

            <p class="mt-3 text-center small text-gray-400">
                Don't have an account yet?
                <a href="{{ route('register') }}" class="text-info hover-underline" style="text-decoration: none;">
                    Sign Up
                </a>
            </p>
        </div>
    </div>
</div>
@endsection