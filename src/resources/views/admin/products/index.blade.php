@extends('layouts.app')

@section('title', 'Product Management')

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
                        Product Management
                    </h1>
                    <p clindass="page-subtitle">
                        Manage and organize your product products
                    </p>
                </div>
                <div class="header-right">
                    @if(canManageProducts())
                    <button type="button" class="btn-add-new" data-bs-toggle="modal" data-bs-target="#addProductModal">
                        <i class="fa-light fa-plus"></i>
                        Add New Product
                    </button>
					
					<a href="{{ route('admin.product.import') }}"  class="btn-add-new" data-bs-toggle="modal" data-bs-target="#importModal">
                        <i class="fa-light fa-upload"></i>
                        Import Excel
                    </a>
					<a href="{{ route('admin.product.export') }}"   class="btn-add-new">
                        <i class="fa-light fa-download"></i>
                        Export Excel
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>


    
    <div class="container mx-auto px-4 py-8">
        <div id="loadingState" class="loading-container d-none">
            <div class="loading-spinner"></div>
            <p class="loading-text">Loading products...</p>
        </div>

        <div class="items-grid" id="productsGrid">
            @forelse($products as $product)
			
            <div class="item-card" data-product-id="{{ $product->id }}">
                <div class="item-image-container">
                    @if($product->mainImage)
        {{-- 2. Dùng thuộc tính 'url' của đối tượng mainImage (từ bảng product_images) --}}
					<img src="{{ asset('storage/app/private/'.$product->mainImage->url) }}"
						 alt="{{ $product->name }}"
						 class="item-image"
						 loading="lazy">
					@else
						{{-- Nếu không có ảnh chính --}}
						<div class="item-image-placeholder">
							<i class="fas fa-box"></i> 
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
                                title="Edit Product"
                                onclick="openEditProductModal('{{ $product->id }}', {{ json_encode($product) }})">
                                <i class="fas fa-edit"></i>
                                <span>Edit</span>
                            </button>
                            <button type="button"
                                class="action-btn delete-btn"
                                title="Delete Product"
                                onclick="openDeleteProductModal('{{ $product->id }}', {{ json_encode($product) }})">
                                <i class="fas fa-trash-alt"></i>
                                <span>Delete</span>
                            </button>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="item-content">
                    <h3 class="item-title" title="{{ $product->name }}">
                        {{ $product->name }}
                    </h3>

                    <div class="item-info">
                       

                        @if($product->price)
                        <div class="info-item">
                            <i class="fas fa-money-bill-wave"></i>
                            <span class="info-label">Price:</span>
                            <span class="info-value" title="{{ $product->price }}">
                                ${{ Str::limit($product->price, 30) }}
                            </span>
                        </div>
                        @endif
						
                        
                        @if($product->description)
                        <div class="item-description">
                            {{ Str::limit($product->description, 100) }}
                        </div>
                        @endif
                    </div>

                    <div class="item-footer">
						@if($product->views >= 0)
                        <div>
                            <i class="fas fa-eye"></i>
                            <span class="info-label">views:</span>
                            <span class="info-value" title="{{ $product->price }}">
                                {{ Str::limit($product->views, 30) }}
                            </span>
                        </div>
                        @endif
						@if($product->favorites >= 0)
                        <div>
                            <i class="fas fa-heart"></i>
                            <span class="info-label">favorites:</span>
                            <span class="info-value" title="{{ $product->price }}">
                                {{ Str::limit($product->favorites, 30) }}
                            </span>
                        </div>
                        @endif
						@if($product->purchases)
                        <div>
                            <i class="fas fa-map-marker-alt"></i>
                            <span class="info-label">purchases:</span>
                            <span class="info-value" title="{{ $product->price }}">
                                {{ Str::limit($product->purases, 30) }}
                            </span>
                        </div>
                        @endif
                        <div class="created-date">
                            <i class="fas fa-calendar-alt"></i>
                            Created {{ $product->created_at->diffForHumans() }}
							
                        </div>
						
						
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <div class="empty-content">
                    <i class="fas fa-tags empty-icon"></i>
                    <h3 class="empty-title">No Products Found</h3>
                    <p class="empty-text">
                        You haven't added any products yet. Start building your product portfolio by creating your first product.
                    </p>
                    @if(canManageProducts())
                    <button type="button" class="btn-add-first" data-bs-toggle="modal" data-bs-target="#addProductModal">
                        <i class="fas fa-plus"></i>
                        Create Your First Product
                    </button>
                    @endif
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>

 
 <form action="{{ route('admin.product.import') }}" method="post" enctype="multipart/form-data">
	       @csrf

<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content item-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="addBrandModalLabel">
                    <i class="fa-light fa-upload"></i>
                    Import from Excel
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="modalMessages" class="mb-3" style="display: none;">
                    <div id="errorMessage" class="alert alert-danger" style="display: none;"></div>
                    <div id="successMessage" class="alert alert-success" style="display: none;"></div>
                </div>

                <form id="addBrandForm" action="{{ route('admin.product.add') }}" method="post" enctype="multipart/form-data">
             
                    <div class="form-group mb-4">
                        <label class="form-label" for="name">
                           
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
@include('admin.products.add')
@include('admin.products.update')
@include('admin.products.delete')

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
                    console.log('Product card clicked:', this.dataset.productId);
                }
            });
        });

        // Keyboard shortcut for adding new product
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'n' && !e.shiftKey) {
                e.preventDefault();
                const addProductModal = new bootstrap.Modal(document.getElementById('addProductModal'));
                addProductModal.show();
            }
        });
    });

    // Edit Product Modal Function
    function openEditProductModal(productId, productData) {
        // Use the function from update.blade.php
        openUpdateModal(productId, productData);
    }

    // Delete Product Modal Function
    function openDeleteProductModal(productId, productData) {
        // Use the function from delete.blade.php
        openDeleteModal(productId, productData);
    }

    // Loading functions
    function showLoading() {
        const loadingState = document.getElementById('loadingState');
        const productsGrid = document.getElementById('productsGrid');

        if (loadingState && productsGrid) {
            loadingState.classList.remove('d-none');
            productsGrid.style.opacity = '0.3';
        }
    }

    function hideLoading() {
        const loadingState = document.getElementById('loadingState');
        const productsGrid = document.getElementById('productsGrid');

        if (loadingState && productsGrid) {
            loadingState.classList.add('d-none');
            productsGrid.style.opacity = '1';
        }
    }

    // Search functionality
    function filterProducts(searchTerm) {
        const cards = document.querySelectorAll('.item-card');
        let visibleCount = 0;

        cards.forEach(card => {
            const productName = card.querySelector('.item-title').textContent.toLowerCase();
            const productDescription = card.querySelector('.item-description')?.textContent.toLowerCase() || '';
            const productEmail = card.querySelector('.info-value')?.textContent.toLowerCase() || '';

            const isVisible = productName.includes(searchTerm.toLowerCase()) ||
                productDescription.includes(searchTerm.toLowerCase()) ||
                productEmail.includes(searchTerm.toLowerCase());

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
    const addProductModal = new bootstrap.Modal(document.getElementById('addProductModal'));
    addProductModal.show();
    
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
    const updateProductModal = new bootstrap.Modal(document.getElementById('updateProductModal'));
    updateProductModal.show();
    
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