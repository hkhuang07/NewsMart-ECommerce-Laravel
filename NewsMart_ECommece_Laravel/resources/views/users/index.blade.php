@extends('layouts.app')

@section('title', 'User Management')

@section('styles')
<link href="{{ asset('css/list.css') }}" rel="stylesheet">
<link href="{{ asset('css/form.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="item-management-container">
    {{-- Header Section --}}
    <div class="item-header">
        <div class="container mx-auto px-4">
            <div class="header-content">
                <div class="header-left">
                    <h1 class="page-title">
                        <i class="fas fa-users"></i>
                        User Management
                    </h1>
                    <p class="page-subtitle">
                        Manage and organize user accounts and permissions
                    </p>
                </div>
                <div class="header-right">
                    @if(canManageUsers())
                    <button type="button" class="btn-add-new" data-bs-toggle="modal" data-bs-target="#addUserModal">
                        <i class="fa-light fa-plus"></i>
                        Add New User
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Status Alert --}}
    <div class="container mx-auto px-4 mt-3">
        <div id="generalMessageArea">
            @if(session('success'))
            <div class="alert alert-success" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="alert alert-danger" role="alert">
                <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
            </div>
            @endif
        </div>
    </div>

    {{-- Main Grid Content --}}
    <div class="container mx-auto px-4 py-8">
        <div id="loadingState" class="loading-container d-none">
            <div class="loading-spinner"></div>
            <p class="loading-text">Loading users...</p>
        </div>

        <div class="items-grid" id="usersGrid">
            @forelse($users as $user)
            <div class="item-card" data-user-id="{{ $user->id }}">
                <div class="item-image-container">
                    <div class="item-image-placeholder">
                        @if($user->avatar)
                        <img src="{{ asset('storage/app/public/'. $user->avatar) }}" alt="{{ $user->name }}" 
                        class="item-image" 
                        loading="lazy">

                        @else
                        <i class="fas fa-user-circle"></i>
                        @endif
                    </div>

                    <div class="status-badge {{ $user->isactive ? 'bg-success' : 'bg-danger' }}">
                        <i class="fas {{ $user->isactive ? 'fa-check-circle' : 'fa-ban' }}"></i>
                        {{ $user->isactive ? 'Active' : 'Inactive' }}
                    </div>

                    @if(canManageUsers())
                    <div class="action-overlay">
                        <div class="action-buttons">
                            <button type="button"
                                class="action-btn edit-btn"
                                title="Edit User"
                                onclick="openEditUserModal('{{ $user->id }}', {{ json_encode($user) }})">
                                <i class="fas fa-edit"></i>
                                <span>Edit</span>
                            </button>

                            @if($user->roleid != 1)
                            <button type="button"
                                class="action-btn delete-btn"
                                title="Delete User"
                                onclick="openDeleteUserModal('{{ $user->id }}', {{ json_encode($user) }})">
                                <i class="fas fa-trash-alt"></i>
                                <span>Delete</span>
                            </button>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>

                <div class="item-content">
                    <h3 class="item-title" title="{{ $user->name }}">
                        {{ $user->name }}
                    </h3>

                    <div class="item-info">
                        <div class="info-item">
                            <i class="fas fa-user"></i>
                            <span class="info-label">Username:</span>
                            <span class="info-value">{{ $user->username }}</span>
                        </div>

                        <div class="info-item">
                            <i class="fas fa-user-tag"></i>
                            <span class="info-label">Role:</span>
                            <span class="info-value">{{ $user->role->name ?? 'N/A' }}</span>
                        </div>

                        <div class="info-item">
                            <i class="fas fa-envelope"></i>
                            <span class="info-label">Email:</span>
                            <span class="info-value" title="{{ $user->email }}">
                                {{ Str::limit($user->email, 25) }}
                            </span>
                        </div>

                        @if($user->jobs || $user->company)
                        <div class="info-item">
                            <i class="fas fa-briefcase"></i>
                            <span class="info-label">Job/Company:</span>
                            <span class="info-value">{{ $user->jobs }} @if($user->jobs && $user->company) at @endif {{ $user->company }}</span>
                        </div>
                        @endif

                        @if($user->phone)
                        <div class="info-item">
                            <i class="fas fa-phone"></i>
                            <span class="info-label">Phone:</span>
                            <span class="info-value">{{ $user->phone }}</span>
                        </div>
                        @endif

                        @if($user->address)
                        <div class="info-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span class="info-label">Address:</span>
                            <span class="info-value" title="{{ $user->address }}">
                                {{ Str::limit($user->address, 30) }}
                            </span>
                        </div>
                        @endif

                        @if($user->school)
                        <div class="info-item">
                            <i class="fas fa-graduation-cap"></i>
                            <span class="info-label">School:</span>
                            <span class="info-value">{{ $user->school }}</span>
                        </div>
                        @endif

                    </div>

                    <div class="item-footer">
                        <div class="created-date">
                            <i class="fas fa-calendar-alt"></i>
                            Created {{ $user->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <div class="empty-content">
                    <i class="fas fa-users empty-icon"></i>
                    <h3 class="empty-title">No Users Found</h3>
                    <p class="empty-text">
                        You haven't added any users yet. Start managing user accounts.
                    </p>
                    @if(canManageUsers())
                    <button type="button" class="btn-add-first" data-bs-toggle="modal" data-bs-target="#addUserModal">
                        <i class="fas fa-plus"></i>
                        Create Your First User
                    </button>
                    @endif
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>

@include('users.add')
@include('users.update')
@include('users.delete')

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const itemCards = document.querySelectorAll('.item-card');

        itemCards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px) scale(1.02)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });

            card.addEventListener('click', function(e) {
                if (!e.target.closest('.action-btn') && !e.target.closest('.action-overlay')) {
                    console.log('User card clicked:', this.dataset.userId);
                }
            });
        });

        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'n' && !e.shiftKey) {
                e.preventDefault();
                const addUserModal = new bootstrap.Modal(document.getElementById('addUserModal'));
                addUserModal.show();
            }
        });

        // Hide general message area after 5 seconds
        setTimeout(() => {
            const generalMessageArea = document.getElementById('generalMessageArea');
            if (generalMessageArea) {
                generalMessageArea.innerHTML = '';
            }
        }, 5000);
    });

    // Edit User Modal Function (like Brands)
    function openEditUserModal(userId, userData) {
        // Use the function from update.blade.php
        openUpdateModal(userId, userData);
    }

    // Delete User Modal Function (like Brands)
    function openDeleteUserModal(userId, userData) {
        // Use the function from delete.blade.php
        openDeleteModal(userId, userData);
    }

    // Loading functions (like Brands)
    function showLoading() {
        const loadingState = document.getElementById('loadingState');
        const usersGrid = document.getElementById('usersGrid');

        if (loadingState && usersGrid) {
            loadingState.classList.remove('d-none');
            usersGrid.style.opacity = '0.3';
        }
    }

    function hideLoading() {
        const loadingState = document.getElementById('loadingState');
        const usersGrid = document.getElementById('usersGrid');

        if (loadingState && usersGrid) {
            loadingState.classList.add('d-none');
            usersGrid.style.opacity = '1';
        }
    }

    // Search functionality (like Brands)
    function filterUsers(searchTerm) {
        const cards = document.querySelectorAll('.item-card');
        let visibleCount = 0;
        const term = searchTerm.toLowerCase();

        cards.forEach(card => {
            const userName = card.querySelector('.item-title').textContent.toLowerCase();
            const infoItems = card.querySelectorAll('.item-info .info-value');
            let searchableText = userName;
            infoItems.forEach(item => {
                searchableText += ' ' + item.textContent.toLowerCase();
            });

            const isVisible = searchableText.includes(term);

            if (isVisible) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        const emptyState = document.querySelector('.empty-state');
        if (emptyState) {
            emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
        }
    }
</script>

@if ($errors->any() && !session('update_errors') && !session('delete_errors'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addUserModal = new bootstrap.Modal(document.getElementById('addUserModal'));
        addUserModal.show();
    });
</script>
@endif

@if (session('update_errors'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const updateUserModal = new bootstrap.Modal(document.getElementById('updateUserModal'));
        updateUserModal.show();
    });
</script>
@endif
@endsection