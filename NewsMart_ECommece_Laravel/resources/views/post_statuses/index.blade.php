@extends('layouts.app')

@section('title', 'PostStatus Management')

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
                        <i class="fas fa-tags"></i>
                        PostStatus Management
                    </h1>
                    <p class="page-subtitle">
                        Manage and organize your product post_statuses
                    </p>
                </div>
                <div class="header-right">
                    @if(canManageProducts())
                    <button type="button" class="btn-add-new" data-bs-toggle="modal" data-bs-target="#addPostStatusModal">
                        <i class="fa-light fa-plus"></i>
                        Add New PostStatus
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div id="loadingState" class="loading-container d-none">
            <div class="loading-spinner"></div>
            <p class="loading-text">Loading post_statuses...</p>
        </div>

        <div class="items-grid" id="post_statusesGrid">
            @forelse($post_statuses as $post_status)
            <div class="item-card" data-post_status-id="{{ $post_status->id }}">
     
				<div class="status-badge">
                        <i class="fas fa-check-circle"></i>
                        Active
                    </div>
                <div class="item-content">
                    <h3 class="item-title" title="{{ $post_status->name }}">
                        {{ $post_status->name }}
                    </h3>
                    <div class="item-info">       
                        @if($post_status->description)
                        <div class="item-description">
                            {{ Str::limit($post_status->description, 100) }}
                        </div>
                        @endif
                    </div>
                    @if(canManageProducts())
                    <div class="action-overlay">
                        <div class="action-buttons">
                            <button type="button"
                                class="action-btn edit-btn"
                                title="Edit PostStatus"
                                onclick="openEditPostStatusModal('{{ $post_status->id }}', {{ json_encode($post_status) }})">
                                <i class="fas fa-edit"></i>
                                <span>Edit</span>
                            </button>
                            <button type="button"
                                class="action-btn delete-btn"
                                title="Delete PostStatus"
                                onclick="openDeletePostStatusModal('{{ $post_status->id }}', {{ json_encode($post_status) }})">
                                <i class="fas fa-trash-alt"></i>
                                <span>Delete</span>
                            </button>
                        </div>
                    </div>
                    @endif
                    <div class="item-footer">
                        <div class="created-date">
                            <i class="fas fa-calendar-alt"></i>
                            Created {{ $post_status->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <div class="empty-content">
                    <i class="fas fa-tags empty-icon"></i>
                    <h3 class="empty-title">No PostStatuss Found</h3>
                    <p class="empty-text">
                        You haven't added any post_statuses yet. Start building your post_status portfolio by creating your first post_status.
                    </p>
                    @if(canManageProducts())
                    <button type="button" class="btn-add-first" data-bs-toggle="modal" data-bs-target="#addPostStatusModal">
                        <i class="fas fa-plus"></i>
                        Create Your First PostStatus
                    </button>
                    @endif
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>

@include('post_statuses.add')
@include('post_statuses.update')
@include('post_statuses.delete')

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
                    console.log('PostStatus card clicked:', this.dataset.post_statusId);
                }
            });
        });

        // Keyboard shortcut for adding new post_status
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'n' && !e.shiftKey) {
                e.preventDefault();
                const addPostStatusModal = new bootstrap.Modal(document.getElementById('addPostStatusModal'));
                addPostStatusModal.show();
            }
        });
    });

    // Edit PostStatus Modal Function
    function openEditPostStatusModal(post_statusId, post_statusData) {
        // Use the function from update.blade.php
        openUpdateModal(post_statusId, post_statusData);
    }

    // Delete PostStatus Modal Function
    function openDeletePostStatusModal(post_statusId, post_statusData) {
        // Use the function from delete.blade.php
        openDeleteModal(post_statusId, post_statusData);
    }

    // Loading functions
    function showLoading() {
        const loadingState = document.getElementById('loadingState');
        const post_statusesGrid = document.getElementById('post_statusesGrid');

        if (loadingState && post_statusesGrid) {
            loadingState.classList.remove('d-none');
            post_statusesGrid.style.opacity = '0.3';
        }
    }

    function hideLoading() {
        const loadingState = document.getElementById('loadingState');
        const post_statusesGrid = document.getElementById('post_statusesGrid');

        if (loadingState && post_statusesGrid) {
            loadingState.classList.add('d-none');
            post_statusesGrid.style.opacity = '1';
        }
    }

    // Search functionality
    function filterPostStatuss(searchTerm) {
        const cards = document.querySelectorAll('.item-card');
        let visibleCount = 0;

        cards.forEach(card => {
            const post_statusName = card.querySelector('.item-title').textContent.toLowerCase();
            const post_statusDescription = card.querySelector('.item-description')?.textContent.toLowerCase() || '';
            const post_statusEmail = card.querySelector('.info-value')?.textContent.toLowerCase() || '';

            const isVisible = post_statusName.includes(searchTerm.toLowerCase()) ||
                post_statusDescription.includes(searchTerm.toLowerCase()) ||
                post_statusEmail.includes(searchTerm.toLowerCase());

            if (isVisible) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Show/hide empty state
        const emptyState = document.querySelector('.empty-state');
        if (emptyState) {
            emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
        }
    }
</script>

@if ($errors->any() && !session('update_errors') && !session('delete_errors'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mở modal nếu có lỗi validation cho add form
    const addPostStatusModal = new bootstrap.Modal(document.getElementById('addPostStatusModal'));
    addPostStatusModal.show();
    
    // Hiển thị lỗi
    const errorMessage = document.getElementById('errorMessage');
    const modalMessages = document.getElementById('modalMessages');
    
    if (errorMessage && modalMessages) {
        errorMessage.innerHTML = '<strong>Please fix the following errors:</strong><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>';
        errorMessage.style.display = 'block';
        modalMessages.style.display = 'block';
    }
});
</script>
@endif

@if (session('update_errors'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Show update modal with errors
    const updatePostStatusModal = new bootstrap.Modal(document.getElementById('updatePostStatusModal'));
    updatePostStatusModal.show();
    
    // Display errors
    const errorMessage = document.getElementById('updateErrorMessage');
    const modalMessages = document.getElementById('updateModalMessages');
    
    if (errorMessage && modalMessages) {
        errorMessage.innerHTML = '<strong>Please fix the following errors:</strong><ul>@foreach (session('update_errors')->all() as $error)<li>{{ $error }}</li>@endforeach</ul>';
        errorMessage.style.display = 'block';
        modalMessages.style.display = 'block';
    }
});
</script>
@endif

@if (session('success'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Hiển thị success message
    const successMessage = document.getElementById('successMessage');
    const modalMessages = document.getElementById('modalMessages');
    
    if (successMessage && modalMessages) {
        successMessage.innerHTML = '<strong>{{ session('success') }}</strong>';
        successMessage.style.display = 'block';
        modalMessages.style.display = 'block';
        
        // Auto hide after 3 seconds
        setTimeout(function() {
            successMessage.style.display = 'none';
            modalMessages.style.display = 'none';
        }, 3000);
    } else {
        // Fallback alert
        alert('{{ session('success') }}');
    }
});
</script>
@endif
@endsection