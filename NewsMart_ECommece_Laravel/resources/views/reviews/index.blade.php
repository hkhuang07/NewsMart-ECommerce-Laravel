@extends('layouts.app')

@section('title', 'Review Management')

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
                        <i class="fas fa-comments"></i>
                        Review Management
                    </h1>
                    <p class="page-subtitle">
                        Manage and moderate customer reviews
                    </p>
                </div>
                {{-- <div class="header-right">
                    @if(canManageProducts())
                    <button type="button" class="btn-add-new" data-bs-toggle="modal" data-bs-target="#addReviewModal">
                        <i class="fa-light fa-plus"></i>
                        Add New Review
                    </button>
                    @endif
                </div> --}}
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div id="loadingState" class="loading-container d-none">
            <div class="loading-spinner"></div>
            <p class="loading-text">Loading reviews...</p>
        </div>

        <div class="items-grid" id="reviewsGrid">
            @forelse($reviews as $review)
            <div class="item-card" data-review-id="{{ $review->id }}">
                <div class="item-image-container">
                    <div class="item-image-placeholder">
                        <i class="fas fa-user"></i>
                    </div>

                    <div class="status-badge {{ strtolower($review->status) }}">
                        <i class="fas fa-circle"></i>
                        {{ ucfirst($review->status) }}
                    </div>

                    @if(canManageProducts())
                    <div class="action-overlay">
                        <div class="action-buttons">
                            <button type="button" class="action-btn edit-btn" title="Edit Review"
                                onclick="openEditReviewModal('{{ $review->id }}', {{ json_encode($review) }})">
                                <i class="fas fa-edit"></i>
                                <span>Edit</span>
                            </button>
                            <button type="button" class="action-btn delete-btn" title="Delete Review"
                                onclick="openDeleteReviewModal('{{ $review->id }}', {{ json_encode($review) }})">
                                <i class="fas fa-trash-alt"></i>
                                <span>Delete</span>
                            </button>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="item-content">
                    <h3 class="item-title">
                        Review #{{ $review->id }}
                    </h3>

                    <div class="item-info">
                        <div class="info-item">
                            <i class="fas fa-user"></i>
                            <span class="info-label">User ID:</span>
                            <span class="info-value">{{ $review->userid }}</span>
                        </div>

                        <div class="info-item">
                            <i class="fas fa-box"></i>
                            <span class="info-label">Product ID:</span>
                            <span class="info-value">{{ $review->productid }}</span>
                        </div>

                        @if($review->orderid)
                        <div class="info-item">
                            <i class="fas fa-receipt"></i>
                            <span class="info-label">Order ID:</span>
                            <span class="info-value">{{ $review->orderid }}</span>
                        </div>
                        @endif

                        <div class="info-item">
                            <i class="fas fa-star text-yellow-500"></i>
                            <span class="info-label">Rating:</span>
                            <span class="info-value">{{ $review->rating }}/5</span>
                        </div>

                        @if($review->content)
                        <div class="item-description">
                            <i class="fas fa-comment-dots"></i>
                            {{ Str::limit($review->content, 100) }}
                        </div>
                        @endif
                    </div>

                    <div class="item-footer">
                        <div class="created-date">
                            <i class="fas fa-calendar-alt"></i>
                            Created {{ $review->created_at ? $review->created_at->diffForHumans() : 'N/A' }}
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <div class="empty-content">
                    <i class="fas fa-comments empty-icon"></i>
                    <h3 class="empty-title">No Reviews Found</h3>
                    <p class="empty-text">
                        You haven't received any reviews yet. Once customers leave feedback, it will appear here.
                    </p>
                    @if(canManageProducts())
                    <button type="button" class="btn-add-first" data-bs-toggle="modal" data-bs-target="#addReviewModal">
                        <i class="fas fa-plus"></i>
                        Create Sample Review
                    </button>
                    @endif
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>

@include('reviews.add')
@include('reviews.update')
@include('reviews.delete')

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
                console.log('Review card clicked:', this.dataset.reviewId);
            }
        });
    });

    // Keyboard shortcut to open Add Review
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'n' && !e.shiftKey) {
            e.preventDefault();
            const addReviewModal = new bootstrap.Modal(document.getElementById('addReviewModal'));
            addReviewModal.show();
        }
    });
});

function openEditReviewModal(reviewId, reviewData) {
    openUpdateReviewModal(reviewId, reviewData);
}

function openDeleteReviewModal(reviewId, reviewData) {
    openDeleteReviewModal(reviewId, reviewData);
}

function showLoading() {
    const loadingState = document.getElementById('loadingState');
    const reviewsGrid = document.getElementById('reviewsGrid');
    if (loadingState && reviewsGrid) {
        loadingState.classList.remove('d-none');
        reviewsGrid.style.opacity = '0.3';
    }
}

function hideLoading() {
    const loadingState = document.getElementById('loadingState');
    const reviewsGrid = document.getElementById('reviewsGrid');
    if (loadingState && reviewsGrid) {
        loadingState.classList.add('d-none');
        reviewsGrid.style.opacity = '1';
    }
}

// Simple search filter
function filterReviews(searchTerm) {
    const cards = document.querySelectorAll('.item-card');
    let visibleCount = 0;

    cards.forEach(card => {
        const content = card.querySelector('.item-description')?.textContent.toLowerCase() || '';
        const userId = card.querySelector('.info-value')?.textContent.toLowerCase() || '';
        const isVisible = content.includes(searchTerm.toLowerCase()) || userId.includes(searchTerm.toLowerCase());
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
    const addReviewModal = new bootstrap.Modal(document.getElementById('addReviewModal'));
    addReviewModal.show();
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
    const updateReviewModal = new bootstrap.Modal(document.getElementById('updateReviewModal'));
    updateReviewModal.show();
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
    const successMessage = document.getElementById('successMessage');
    const modalMessages = document.getElementById('modalMessages');
    if (successMessage && modalMessages) {
        successMessage.innerHTML = '<strong>{{ session('success') }}</strong>';
        successMessage.style.display = 'block';
        modalMessages.style.display = 'block';
        setTimeout(function() {
            successMessage.style.display = 'none';
            modalMessages.style.display = 'none';
        }, 3000);
    } else {
        alert('{{ session('success') }}');
    }
});
</script>
@endif
@endsection