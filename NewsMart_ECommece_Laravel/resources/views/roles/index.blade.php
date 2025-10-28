@extends('layouts.app')

@section('title', 'Role Management')

@section('styles')
<link href="{{ asset('css/list.css') }}" rel="stylesheet">
<link href="{{ asset('css/form.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="item-management-container">
    <div class="item-header">
        <div class="container mx-auto px-4">
            <div class="header-content">
                <div class="header-left">
                    <h1 class="page-title">
                        <i class="fas fa-user-shield"></i>
                        Role Management
                    </h1>
                    <p class="page-subtitle">
                        Manage and organize user roles and permissions
                    </p>
                </div>
                <div class="header-right">
                    @if(canManageProducts())
                    <button type="button" class="btn-add-new" data-bs-toggle="modal" data-bs-target="#addRoleModal">
                        <i class="fa-light fa-plus"></i>
                        Add New Role
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div id="loadingState" class="loading-container d-none">
            <div class="loading-spinner"></div>
            <p class="loading-text">Loading roles...</p>
        </div>

        <div class="items-grid" id="rolesGrid">
            @forelse($roles as $role)
            <div class="item-card" data-role-id="{{ $role->id }}">
                <div class="item-image-container">
                    <div class="item-image-placeholder">
                        <i class="fas fa-user-tag"></i>
                    </div>

                    <div class="status-badge">
                        <i class="fas fa-check-circle"></i>
                        Active
                    </div>

                    @if(canManageProducts())
                    <div class="action-overlay">
                        <div class="action-buttons">
                            <button type="button"
                                class="action-btn edit-btn"
                                title="Edit Role"
                                onclick="openEditRoleModal('{{ $role->id }}', {{ json_encode($role) }})">
                                <i class="fas fa-edit"></i>
                                <span>Edit</span>
                            </button>
                            <button type="button"
                                class="action-btn delete-btn"
                                title="Delete Role"
                                onclick="openDeleteRoleModal('{{ $role->id }}', {{ json_encode($role) }})">
                                <i class="fas fa-trash-alt"></i>
                                <span>Delete</span>
                            </button>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="item-content">
                    <h3 class="item-title" title="{{ $role->name }}">
                        {{ $role->name }}
                    </h3>

                    @if($role->description)
                    <div class="item-description">
                        {{ Str::limit($role->description, 100) }}
                    </div>
                    @endif

                    <div class="item-footer">
                        <div class="created-date">
                            <i class="fas fa-calendar-alt"></i>
                            Created {{ $role->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <div class="empty-content">
                    <i class="fas fa-user-shield empty-icon"></i>
                    <h3 class="empty-title">No Roles Found</h3>
                    <p class="empty-text">
                        You haven't created any roles yet. Start managing permissions by adding your first role.
                    </p>
                    @if(canManageProducts())
                    <button type="button" class="btn-add-first" data-bs-toggle="modal" data-bs-target="#addRoleModal">
                        <i class="fas fa-plus"></i>
                        Create Your First Role
                    </button>
                    @endif
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>

@include('roles.add')
@include('roles.update')
@include('roles.delete')

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Item card interactions
        const itemCards = document.querySelectorAll('.item-card');

        itemCards.forEach(card => {
            // Hover effects
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-8px) scale(1.02)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });

            // Click handling
            card.addEventListener('click', function(e) {
                if (!e.target.closest('.action-btn') && !e.target.closest('.action-overlay')) {
                    console.log('Role card clicked:', this.dataset.roleId);
                }
            });
        });

        // Keyboard shortcut for adding new role
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'n' && !e.shiftKey) {
                e.preventDefault();
                const addRoleModal = new bootstrap.Modal(document.getElementById('addRoleModal'));
                addRoleModal.show();
            }
        });
    });

    // Edit Role Modal Function
    function openEditRoleModal(roleId, roleData) {
        openUpdateModal(roleId, roleData);
    }

    // Delete Role Modal Function
    function openDeleteRoleModal(roleId, roleData) {
        openDeleteModal(roleId, roleData);
    }

    // Loading functions
    function showLoading() {
        const loadingState = document.getElementById('loadingState');
        const rolesGrid = document.getElementById('rolesGrid');

        if (loadingState && rolesGrid) {
            loadingState.classList.remove('d-none');
            rolesGrid.style.opacity = '0.3';
        }
    }

    function hideLoading() {
        const loadingState = document.getElementById('loadingState');
        const rolesGrid = document.getElementById('rolesGrid');

        if (loadingState && rolesGrid) {
            loadingState.classList.add('d-none');
            rolesGrid.style.opacity = '1';
        }
    }

    // Search functionality
    function filterRoles(searchTerm) {
        const cards = document.querySelectorAll('.item-card');
        let visibleCount = 0;

        cards.forEach(card => {
            const roleName = card.querySelector('.item-title').textContent.toLowerCase();
            const roleDescription = card.querySelector('.item-description')?.textContent.toLowerCase() || '';

            const isVisible = roleName.includes(searchTerm.toLowerCase()) ||
                              roleDescription.includes(searchTerm.toLowerCase());

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
    const addRoleModal = new bootstrap.Modal(document.getElementById('addRoleModal'));
    addRoleModal.show();
});
</script>
@endif

@if (session('update_errors'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    const updateRoleModal = new bootstrap.Modal(document.getElementById('updateRoleModal'));
    updateRoleModal.show();
});
</script>
@endif

@if (session('success'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    alert('{{ session('success') }}');
});
</script>
@endif
@endsection
