@extends('layouts.app')

@section('title', 'Profile - ' . ($user->name ?? 'User Profile'))


@section('styles')
<link href="{{ asset('css/profile.css') }}" rel="stylesheet">
<link href="{{ asset('css/form.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
@endsection


@section('content')

@php
$defaultAvatar = asset('storage/app/public/avatar.jpg');
$defaultBackground = asset('storage/app/public/newsmart_logo.jpg');

// Handle avatar and background paths
$avatarUrl = '';
if($user->avatar) {
if(str_starts_with($user->avatar, '/app/public/') || str_starts_with($user->avatar, 'http')) {
$avatarUrl = $user->avatar;
} else {
$avatarUrl = asset('storage/app/public/' . $user->avatar);
}
} else {
$avatarUrl = $defaultAvatar;
}

$backgroundUrl = '';
if($user->background) {
if(str_starts_with($user->background, '/app/public/') || str_starts_with($user->background, 'http')) {
$backgroundUrl = $user->background;
} else {
$backgroundUrl = asset('storage/app/public/' . $user->background);
}
} else {
$backgroundUrl = $defaultBackground;
}
@endphp

<div class="min-h-screen bg-light-bg dark:bg-dark-bg text-light-text dark:text-dark-text">
    <div
        class="relative h-48 sm:h-64 bg-cover bg-center"
        style="background-image: url('{{ $backgroundUrl }}')"
        
        data-bs-toggle="modal"
        data-bs-target="#updateProfileModal">

        <div class="absolute top-4 right-4 z-10">
            <a href="#" 
               class="p-2 rounded-full cursor-pointer bg-[#000040] text-[#F0F8FF] hover:bg-[#191970] transition-colors"
               aria-label="Change Background">
                 <i class="fas fa-camera fa-lg"></i>
            </a>
        </div>
    </div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 -mt-20">
        <div class="flex flex-col sm:flex-row items-start sm:items-end space-x-0 sm:space-x-8">
            <div class="relative w-36 h-36 sm:w-48 sm:h-48 rounded-full border-3 border-[#E6E6FA] bg-[#000040] overflow-hidden shadow-xl z-20">
                <img src="{{ $avatarUrl }}"
                    alt="{{ $user->name }}'s avatar"
                    class="w-full h-full object-cover">
            </div>

            {{-- Basic Info --}}
            <div class="mt-4 sm:mt-0 flex-1 pl-4 sm:pl-0">
                <div class="flex justify-between items-start">
                    <h1 class="mt-5 text-2xl dark:text-dark-text text-light-text sm:text-3xl font-bold">{{ $user->name }}</h1>
                </div>
                <p class="text-md text-[#3A5FCD] mt-1">{{ '@' . $user->username }}</p>

                {{-- Display Job/Company Info --}}
                @if($user->jobs || $user->company)
                <p class="text-sm text-[#1874CD] mt-2 flex items-center space-x-2">
                    <i class="fas fa-briefcase"></i>
                    <span>{{ $user->jobs }} @if($user->jobs && $user->company) at @endif {{ $user->company }}</span>
                </p>
                @endif

                {{-- Display School Info --}}
                @if($user->school)
                <p class="text-sm text-[#009ACD] mt-1 flex items-center space-x-2">
                    <i class="fas fa-graduation-cap"></i>
                    <span>{{ $user->school }}</span>
                </p>
                @endif

                {{-- Action Buttons --}}
                <div class="mt-4 flex gap-3">
                    <button type="button"
                        class="btn-action btn-edit"
                        data-bs-toggle="modal" 
                        data-bs-target="#updateProfileModal"> 
                         <i class="fas fa-edit"></i>
                         <span>Edit Profile</span>
                    </button>
                    
                    <a href="{{ route('profile.changepassword') }}" 
                       class="btn-action btn-password">
                         <i class="fas fa-lock"></i>
                         <span>Change Password</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- Profile Details Section --}}
        <div class="mt-8 p-6 profile-details-card rounded-xl shadow-lg border border-[#98F5FF] dark:border-[#98F5FF]">
            <h2 class="details-title text-2xl font-bold mb-4 dark:text-[#E6E6FA]">Profile Details</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                {{-- Username --}}
                <div class="info-item">
                    <div class="info-icon"><i class="fas fa-user"></i></div>
                    <div class="info-content">
                        <span class="info-label">Username:</span>
                        <span class="info-value">{{ $user->username }}</span>
                    </div>
                </div>

                {{-- Email --}}
                <div class="info-item">
                    <div class="info-icon"><i class="fas fa-envelope"></i></div>
                    <div class="info-content">
                        <span class="info-label">Email:</span>
                        <span class="info-value">{{ $user->email }}</span>
                    </div>
                </div>

                {{-- Phone Number --}}
                <div class="info-item">
                    <div class="info-icon"><i class="fas fa-phone"></i></div>
                    <div class="info-content">
                        <span class="info-label">Phone Number:</span>
                        <span class="info-value">{{ $user->phone ?? 'Not provided' }}</span>
                    </div>
                </div>

                {{-- Address --}}
                <div class="info-item">
                    <div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>
                    <div class="info-content">
                        <span class="info-label">Address:</span>
                        <span class="info-value">{{ $user->address ?? 'Not provided' }}</span>
                    </div>
                </div>

                {{-- School --}}
                <div class="info-item">
                    <div class="info-icon"><i class="fas fa-graduation-cap"></i></div>
                    <div class="info-content">
                        <span class="info-label">School:</span>
                        <span class="info-value">{{ $user->school ?? 'Not provided' }}</span>
                    </div>
                </div>

                {{-- Company --}}
                <div class="info-item">
                    <div class="info-icon"><i class="fas fa-building"></i></div>
                    <div class="info-content">
                        <span class="info-label">Company:</span>
                        <span class="info-value">{{ $user->company ?? 'Not provided' }}</span>
                    </div>
                </div>

                {{-- Job Title --}}
                <div class="info-item">
                    <div class="info-icon"><i class="fas fa-briefcase"></i></div>
                    <div class="info-content">
                        <span class="info-label">Job Title:</span>
                        <span class="info-value">{{ $user->jobs ?? 'Not provided' }}</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@include('users.profile.update')

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modalElement = document.getElementById('updateProfileModal');
        @if ($errors->any() && session('profile_update_attempt'))
            const updateModal = new bootstrap.Modal(modalElement);
            updateModal.show();
        @endif
    });

    @if(session('success'))
    setTimeout(function() {
        const alert = document.querySelector('.alert-success');
        if (alert) {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        }
    }, 5000);
    @endif
</script>

@endsection