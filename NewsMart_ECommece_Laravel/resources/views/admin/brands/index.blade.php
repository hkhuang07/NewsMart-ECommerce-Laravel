@extends('layouts.app')

@section('title', 'Brand Management')

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
                        Brand Management
                    </h1>
                    <p clindass="page-subtitle">
                        Manage and organize your product brands
                    </p>
                </div>
                <div class="header-right">
                    @if(canManageProducts())
                    <button type="button" class="btn-add-new" data-bs-toggle="modal" data-bs-target="#addBrandModal">
                        <i class="fa-light fa-plus"></i>
                        Add New Brand
                    </button>
					<a href="{{ route('admin.brand.import') }}"  class="btn-add-new" data-bs-toggle="modal" data-bs-target="#importModal">
                        <i class="fa-light fa-upload"></i>
                        Import Excel
                    </a>
					<a href="{{ route('admin.brand.export') }}"   class="btn-add-new">
                        <i class="fa-light fa-download"></i>
                        Export Excel
                    </a>
		
                    @endif
                </div>
            </div>
        </div>
    </div>
	
<form action="{{ route('admin.brand.import') }}" method="post" enctype="multipart/form-data">
	       @csrf

<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content item-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="addBrandModalLabel">
                    <i class="fa-light fa-plus-circle"></i>
                    Import from Excel
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="modalMessages" class="mb-3" style="display: none;">
                    <div id="errorMessage" class="alert alert-danger" style="display: none;"></div>
                    <div id="successMessage" class="alert alert-success" style="display: none;"></div>
                </div>

                <form id="addBrandForm" action="{{ route('admin.brand.add') }}" method="post" enctype="multipart/form-data">
             
                    <div class="form-group mb-4">
                        <label class="form-label" for="name">
                            <i class="fa-light fa-upload"></i>
                            Choose file Excel
                        </label>
                         <input type="file" class="form-control" id="file_excel" name="file_excel" required />
                        
                    </div>

                  
                </form>
            </div>
				<div class="modal-footer item-modal-footer">
               
				<button type="button" class="btn btn-cancel" data-bs-dismiss="modal">
				<i class="fa-light fa-times"></i> 
				Cancel</button>
				<button type="submit" class="btn btn-action"><i class="fa-light fa-upload"></i> Import Data</button>
            </div>
           
        </div>
    </div>
</div>



    
    <div class="container mx-auto px-4 py-8">
        <div id="loadingState" class="loading-container d-none">
            <div class="loading-spinner"></div>
            <p class="loading-text">Loading brands...</p>
        </div>

        <div class="items-grid" id="brandsGrid">
            @forelse($brands as $brand)
            <div class="item-card" data-brand-id="{{ $brand->id }}">
                <div class="item-image-container">
                    @if(isset($brand->logo) && $brand->logo)
                    <img src="{{ asset('storage/app/private/'.$brand->logo) }}"
                        alt="{{ $brand->name }}"
                        class="item-image"
                        loading="lazy">
                    @else
                    <div class="item-image-placeholder">
                        <i class="fas fa-building"></i>
                    </div>
                    @endif

                    <div class="status-badge">
                        <i class="fas fa-check-circle"></i>
                        Active
                    </div>

                    @if(canManageProducts())
                    <div class="action-overlay">
                        <div class="action-buttons">
                            <button type="button"
                                class="action-btn edit-btn"
                                title="Edit Brand"
                                onclick="openEditBrandModal('{{ $brand->id }}', {{ json_encode($brand) }})">
                                <i class="fas fa-edit"></i>
                                <span>Edit</span>
                            </button>
                            <button type="button"
                                class="action-btn delete-btn"
                                title="Delete Brand"
                                onclick="openDeleteBrandModal('{{ $brand->id }}', {{ json_encode($brand) }})">
                                <i class="fas fa-trash-alt"></i>
                                <span>Delete</span>
                            </button>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="item-content">
                    <h3 class="item-title" title="{{ $brand->name }}">
                        {{ $brand->name }}
                    </h3>

                    <div class="item-info">
                        @if($brand->email)
                        <div class="info-item">
                            <i class="fas fa-envelope"></i>
                            <span class="info-label">Email:</span>
                            <span class="info-value" title="{{ $brand->email }}">
                                {{ Str::limit($brand->email, 25) }}
                            </span>
                        </div>
                        @endif

                        @if($brand->address)
                        <div class="info-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span class="info-label">Address:</span>
                            <span class="info-value" title="{{ $brand->address }}">
                                {{ Str::limit($brand->address, 30) }}
                            </span>
                        </div>
                        @endif

                        @if($brand->contact)
                        <div class="info-item">
                            <i class="fas fa-phone"></i>
                            <span class="info-label">Phone:</span>
                            <span class="info-value">{{ $brand->contact }}</span>
                        </div>
                        @endif

                        @if($brand->slug)
                        <div class="info-item">
                            <i class="fas fa-link"></i>
                            <span class="info-label">Slug:</span>
                            <span class="info-value" title="{{ $brand->slug }}">
                                {{ Str::limit($brand->slug, 20) }}
                            </span>
                        </div>
                        @endif

                        @if($brand->description)
                        <div class="item-description">
                            {{ Str::limit($brand->description, 100) }}
                        </div>
                        @endif
                    </div>

                    <div class="item-footer">
                        <div class="created-date">
                            <i class="fas fa-calendar-alt"></i>
                            Created {{ $brand->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <div class="empty-content">
                    <i class="fas fa-tags empty-icon"></i>
                    <h3 class="empty-title">No Brands Found</h3>
                    <p class="empty-text">
                        You haven't added any brands yet. Start building your brand portfolio by creating your first brand.
                    </p>
                    @if(canManageProducts())
                    <button type="button" class="btn-add-first" data-bs-toggle="modal" data-bs-target="#addBrandModal">
                        <i class="fas fa-plus"></i>
                        Create Your First Brand
                    </button>
                    @endif
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>

@include('admin.brands.add')
@include('admin.brands.update')
@include('admin.brands.delete')

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
                    console.log('Brand card clicked:', this.dataset.brandId);
                }
            });
        });

        // Keyboard shortcut for adding new brand
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'n' && !e.shiftKey) {
                e.preventDefault();
                const addBrandModal = new bootstrap.Modal(document.getElementById('addBrandModal'));
                addBrandModal.show();
            }
        });
    });

    // Edit Brand Modal Function
    function openEditBrandModal(brandId, brandData) {
        // Use the function from update.blade.php
        openUpdateModal(brandId, brandData);
    }

    // Delete Brand Modal Function
    function openDeleteBrandModal(brandId, brandData) {
        // Use the function from delete.blade.php
        openDeleteModal(brandId, brandData);
    }

    // Loading functions
    function showLoading() {
        const loadingState = document.getElementById('loadingState');
        const brandsGrid = document.getElementById('brandsGrid');

        if (loadingState && brandsGrid) {
            loadingState.classList.remove('d-none');
            brandsGrid.style.opacity = '0.3';
        }
    }

    function hideLoading() {
        const loadingState = document.getElementById('loadingState');
        const brandsGrid = document.getElementById('brandsGrid');

        if (loadingState && brandsGrid) {
            loadingState.classList.add('d-none');
            brandsGrid.style.opacity = '1';
        }
    }

    // Search functionality
    function filterBrands(searchTerm) {
        const cards = document.querySelectorAll('.item-card');
        let visibleCount = 0;

        cards.forEach(card => {
            const brandName = card.querySelector('.item-title').textContent.toLowerCase();
            const brandDescription = card.querySelector('.item-description')?.textContent.toLowerCase() || '';
            const brandEmail = card.querySelector('.info-value')?.textContent.toLowerCase() || '';

            const isVisible = brandName.includes(searchTerm.toLowerCase()) ||
                brandDescription.includes(searchTerm.toLowerCase()) ||
                brandEmail.includes(searchTerm.toLowerCase());

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
    const addBrandModal = new bootstrap.Modal(document.getElementById('addBrandModal'));
    addBrandModal.show();
    
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
    const updateBrandModal = new bootstrap.Modal(document.getElementById('updateBrandModal'));
    updateBrandModal.show();
    
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