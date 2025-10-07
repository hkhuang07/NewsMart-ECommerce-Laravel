@extends('layouts.app')

@section('title', 'Brand Management')

@section('styles')
<link href="{{ asset('css/brand.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="brand-container">
    <!-- Brand Header -->
    <div class="brand-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="brand-page-title">
                        <i class="fas fa-tags me-3"></i>Brand Management
                    </h1>
                    <p class="brand-page-subtitle mb-0">
                        Manage and organize your product brands
                    </p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    @if(canManageProducts())
                    <a href="{{ route('brand.add') }}" class="btn btn-brand-primary">
                        <i class="fas fa-plus me-2"></i>Add New Brand
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container">
        <!-- Loading State -->
        <div id="loadingState" class="brand-loading d-none">
            <div class="brand-spinner mx-auto"></div>
            <p class="loading-text">Loading brands...</p>
        </div>

        <!-- Brands Grid -->
        <div class="brands-grid" id="brandsGrid">
            @forelse($brands as $brand)
            <div class="brand-card" data-brand-id="{{ $brand->id }}">
                <!-- Brand Image -->
                <div class="brand-card-image">
                    @if(isset($brand->logo) && $brand->logo)
                    <img src="{{ asset('storage/' . $brand->logo) }}"
                        alt="{{ $brand->name }}"
                        loading="lazy">
                    @else
                    <div class="brand-image-placeholder">
                        <i class="fas fa-building brand-placeholder-icon"></i>
                    </div>
                    @endif

                    <!-- Brand Status Badge -->
                    <div class="brand-status-badge">
                        <i class="fas fa-check-circle me-1"></i>Active
                    </div>

                    <!-- Action Overlay -->
                    @if(canManageProducts())
                    <div class="brand-card-overlay">
                        <div class="brand-overlay-actions">
                            <a href="{{ route('brand.edit', ['id' => $brand->id]) }}"
                                class="btn btn-brand-action btn-brand-edit"
                                title="Edit Brand">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button type="button"
                                class="btn btn-brand-action btn-brand-delete"
                                title="Delete Brand"
                                onclick="confirmDelete('{{ $brand->id }}', '{{ addslashes($brand->name) }}')">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Brand Content -->
                <div class="brand-card-content">
                    <h3 class="brand-card-title" title="{{ $brand->name }}">
                        {{ $brand->name }}
                    </h3>

                    <div class="brand-card-info">
                        @if($brand->email)
                        <div class="brand-info-item">
                            <i class="fas fa-envelope"></i>
                            <strong>Email:</strong>
                            <span title="{{ $brand->email }}">{{ Str::limit($brand->email, 25) }}</span>
                        </div>
                        @endif

                        @if($brand->address)
                        <div class="brand-info-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <strong>Address:</strong>
                            <span title="{{ $brand->address }}">{{ Str::limit($brand->address, 30) }}</span>
                        </div>
                        @endif

                        @if($brand->contact)
                        <div class="brand-info-item">
                            <i class="fas fa-phone"></i>
                            <strong>Phone:</strong>
                            <span>{{ $brand->contact }}</span>
                        </div>
                        @endif

                        @if($brand->slug)
                        <div class="brand-info-item">
                            <i class="fas fa-link"></i>
                            <strong>Slug:</strong>
                            <span title="{{ $brand->slug }}">{{ Str::limit($brand->slug, 20) }}</span>
                        </div>
                        @endif

                        @if($brand->description)
                        <div class="brand-description">
                            {{ $brand->description }}
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Brand Footer -->
                <div class="brand-card-footer">
                    <div class="brand-created-date">
                        <i class="fas fa-calendar-alt me-1"></i>
                        Created {{ $brand->created_at->diffForHumans() }}
                    </div>
                </div>
            </div>
            @empty
            <div class="brand-empty-state">
                <i class="fas fa-tags brand-empty-icon"></i>
                <h3 class="brand-empty-title">No Brands Found</h3>
                <p class="brand-empty-text">
                    You haven't added any brands yet. Start building your brand portfolio by creating your first brand.
                </p>
                @if(canManageProducts())
                <a href="{{ route('brand.add') }}" class="btn btn-brand-primary">
                    <i class="fas fa-plus me-2"></i>Create Your First Brand
                </a>
                @endif
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade brand-modal" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Confirm Delete Brand
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <i class="fas fa-trash-alt text-danger mb-3" style="font-size: 3rem;"></i>
                    <h4>Are you sure?</h4>
                    <p class="mb-0">
                        Do you really want to delete the brand <strong id="brandNameToDelete"></strong>?
                    </p>
                    <small class="text-muted">
                        This action cannot be undone and may affect related products.
                    </small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-brand-cancel" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancel
                </button>
                <a href="#" id="confirmDeleteBtn" class="btn btn-brand-confirm-delete">
                    <i class="fas fa-trash-alt me-1"></i>Yes, Delete It
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Brand card hover effects
        const brandCards = document.querySelectorAll('.brand-card');

        brandCards.forEach(card => {
            // Add smooth transitions
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-10px) scale(1.03)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });

            // Add click effect (optional - for card clicking)
            card.addEventListener('click', function(e) {
                // Only if not clicking on action buttons
                if (!e.target.closest('.btn-brand-action') && !e.target.closest('.brand-card-overlay')) {
                    // You can add card click functionality here
                    console.log('Brand card clicked:', this.dataset.brandId);
                }
            });
        });

        // Add loading simulation (optional)
        showLoading();
        setTimeout(hideLoading, 800);
    });

    // Delete confirmation function
    function confirmDelete(brandId, brandName) {
        const brandNameElement = document.getElementById('brandNameToDelete');
        const confirmBtn = document.getElementById('confirmDeleteBtn');

        if (brandNameElement && confirmBtn) {
            brandNameElement.textContent = brandName;
            confirmBtn.href = `{{ route('brand.delete', ['id' => '__ID__']) }}`.replace('__ID__', brandId);

            const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
            deleteModal.show();
        }
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

    // Search functionality (if you want to add search later)
    function filterBrands(searchTerm) {
        const cards = document.querySelectorAll('.brand-card');
        let visibleCount = 0;

        cards.forEach(card => {
            const brandName = card.querySelector('.brand-card-title').textContent.toLowerCase();
            const brandDescription = card.querySelector('.brand-description')?.textContent.toLowerCase() || '';
            const brandEmail = card.querySelector('.brand-info-item span')?.textContent.toLowerCase() || '';

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

        // Show/hide empty state based on visible cards
        const emptyState = document.querySelector('.brand-empty-state');
        if (emptyState) {
            emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
        }
    }

    // Keyboard shortcuts (optional enhancement)
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + N to add new brand
        if ((e.ctrlKey || e.metaKey) && e.key === 'n' && !e.shiftKey) {
            e.preventDefault();
            const addBtn = document.querySelector('a[href*="brand.add"]');
            if (addBtn) {
                window.location.href = addBtn.href;
            }
        }
    });

    // Optional: Add tooltip initialization if using Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
</script>
@endsection