@extends('layouts.app')

@section('title', 'PostType Management')

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
                        PostType Management
                    </h1>
                    <p class="page-subtitle">
                        Manage and organize your product post_types
                    </p>
                </div>
                <div class="header-right">
                    @if(canManageProducts())
                    <button type="button" class="btn-add-new" data-bs-toggle="modal" data-bs-target="#addPostTypeModal">
                        <i class="fa-light fa-plus"></i>
                        Add New PostType
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div id="loadingState" class="loading-container d-none">
            <div class="loading-spinner"></div>
            <p class="loading-text">Loading post_types...</p>
        </div>

        <div class="items-grid" id="post_typesGrid">
            @forelse($post_types as $post_type)
            <div class="item-card" data-post_type-id="{{ $post_type->id }}">
					<div class="status-badge">
                        <i class="fas fa-check-circle"></i>
                        Active
                    </div>
             

                <div class="item-content">
                    <h3 class="item-title" title="{{ $post_type->name }}">
                        {{ $post_type->name }}
                    </h3>

                    <div class="item-info">
                        

                        @if($post_type->slug)
                        <div class="info-item">
                            <i class="fas fa-link"></i>
                            <span class="info-label">Slug:</span>
                            <span class="info-value" title="{{ $post_type->slug }}">
                                {{ Str::limit($post_type->slug, 20) }}
                            </span>
                        </div>
                        @endif

                        @if($post_type->description)
                        <div class="item-description">
                            {{ Str::limit($post_type->description, 100) }}
                        </div>
                        @endif
                    </div>
					@if(canManageProducts())
                    <div class="action-overlay">
                        <div class="action-buttons">
                            <button type="button"
                                class="action-btn edit-btn"
                                title="Edit PostType"
                                onclick="openEditPostTypeModal('{{ $post_type->id }}', {{ json_encode($post_type) }})">
                                <i class="fas fa-edit"></i>
                                <span>Edit</span>
                            </button>
                            <button type="button"
                                class="action-btn delete-btn"
                                title="Delete PostType"
                                onclick="openDeletePostTypeModal('{{ $post_type->id }}', {{ json_encode($post_type) }})">
                                <i class="fas fa-trash-alt"></i>
                                <span>Delete</span>
                            </button>
                        </div>
                    </div>
                    @endif
                    <div class="item-footer">
                        <div class="created-date">
                            <i class="fas fa-calendar-alt"></i>
                            Created {{ $post_type->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <div class="empty-content">
                    <i class="fas fa-tags empty-icon"></i>
                    <h3 class="empty-title">No PostTypes Found</h3>
                    <p class="empty-text">
                        You haven't added any post_types yet. Start building your post_type portfolio by creating your first post_type.
                    </p>
                    @if(canManageProducts())
                    <button type="button" class="btn-add-first" data-bs-toggle="modal" data-bs-target="#addPostTypeModal">
                        <i class="fas fa-plus"></i>
                        Create Your First PostType
                    </button>
                    @endif
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>

@include('post_types.add')
@include('post_types.update')
@include('post_types.delete')

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
                    console.log('PostType card clicked:', this.dataset.post_typeId);
                }
            });
        });

        // Keyboard shortcut for adding new post_type
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'n' && !e.shiftKey) {
                e.preventDefault();
                const addPostTypeModal = new bootstrap.Modal(document.getElementById('addPostTypeModal'));
                addPostTypeModal.show();
            }
        });
    });

    // Edit PostType Modal Function
    function openEditPostTypeModal(post_typeId, post_typeData) {
        // Use the function from update.blade.php
        openUpdateModal(post_typeId, post_typeData);
    }

    // Delete PostType Modal Function
    function openDeletePostTypeModal(post_typeId, post_typeData) {
        // Use the function from delete.blade.php
        openDeleteModal(post_typeId, post_typeData);
    }

    // Loading functions
    function showLoading() {
        const loadingState = document.getElementById('loadingState');
        const post_typesGrid = document.getElementById('post_typesGrid');

        if (loadingState && post_typesGrid) {
            loadingState.classList.remove('d-none');
            post_typesGrid.style.opacity = '0.3';
        }
    }

    function hideLoading() {
        const loadingState = document.getElementById('loadingState');
        const post_typesGrid = document.getElementById('post_typesGrid');

        if (loadingState && post_typesGrid) {
            loadingState.classList.add('d-none');
            post_typesGrid.style.opacity = '1';
        }
    }

    // Search functionality
    function filterPostTypes(searchTerm) {
        const cards = document.querySelectorAll('.item-card');
        let visibleCount = 0;

        cards.forEach(card => {
            const post_typeName = card.querySelector('.item-title').textContent.toLowerCase();
            const post_typeDescription = card.querySelector('.item-description')?.textContent.toLowerCase() || '';
            const post_typeEmail = card.querySelector('.info-value')?.textContent.toLowerCase() || '';

            const isVisible = post_typeName.includes(searchTerm.toLowerCase()) ||
                post_typeDescription.includes(searchTerm.toLowerCase()) ||
                post_typeEmail.includes(searchTerm.toLowerCase());

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
    const addPostTypeModal = new bootstrap.Modal(document.getElementById('addPostTypeModal'));
    addPostTypeModal.show();
    
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
    const updatePostTypeModal = new bootstrap.Modal(document.getElementById('updatePostTypeModal'));
    updatePostTypeModal.show();
    
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