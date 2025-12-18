
@extends('layouts.app')

@section('title', 'My Profile')

@section('content')

<div class="profile-container">
    <h1 class="profile-header"><i class="fas fa-user-circle"></i> My Profile</h1>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">Please check the form below for errors.</div>
    @endif
    
    <div class="profile-card">
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Background/Avatar Display Section --}}
            <div class="profile-header-images" style="background-image: url('{{ $user->background ? asset('storage/' . $user->background) : asset('path/to/default/bg.jpg') }}')">
                <div class="profile-avatar-wrapper">
                    <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('path/to/default/avatar.png') }}" alt="{{ $user->name }}" class="profile-avatar">
                    <label for="avatar_upload" class="avatar-edit-icon"><i class="fas fa-camera"></i></label>
                    <input type="file" id="avatar_upload" name="avatar" accept="image/*" class="d-none">
                </div>
            </div>

            {{-- Basic Info --}}
            <div class="profile-details-grid">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="form-control @error('name') is-invalid @enderror">
                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}" class="form-control @error('username') is-invalid @enderror">
                    @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="form-control @error('email') is-invalid @enderror">
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Role is Read-Only --}}
                <div class="form-group">
                    <label>Role</label>
                    <input type="text" value="{{ $user->role->name ?? 'N/A' }}" class="form-control" disabled>
                </div>
                
                {{-- Contact & Work Info --}}
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" class="form-control @error('phone') is-invalid @enderror">
                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" name="address" id="address" value="{{ old('address', $user->address) }}" class="form-control @error('address') is-invalid @enderror">
                    @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                
                <div class="form-group">
                    <label for="jobs">Job Title</label>
                    <input type="text" name="jobs" id="jobs" value="{{ old('jobs', $user->jobs) }}" class="form-control">
                </div>
                
                <div class="form-group">
                    <label for="company">Company</label>
                    <input type="text" name="company" id="company" value="{{ old('company', $user->company) }}" class="form-control">
                </div>
                
                <div class="form-group">
                    <label for="school">School</label>
                    <input type="text" name="school" id="school" value="{{ old('school', $user->school) }}" class="form-control">
                </div>
            </div>

            <div class="profile-actions">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
                <a href="{{ route('profile.change_password_form') }}" class="btn btn-warning"><i class="fas fa-lock"></i> Change Password</a>
            </div>
        </form>
    </div>
</div>
@endsection

{{-- Lưu ý: Bạn cần tạo CSS (profile.css) để style trang này cho đẹp hơn --}}