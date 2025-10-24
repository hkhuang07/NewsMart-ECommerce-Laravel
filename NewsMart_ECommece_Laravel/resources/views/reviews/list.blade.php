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
                        Manage and moderate user product reviews
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
                <div class="item-content">
                    <h3 class="item-title">
                        <i class="fas fa-user"></i> User ID: {{ $review->userid }}
                    </h3>

                    <div class="item-info">
                        <div class="info-item">
                            <i class="fas fa-box"></i>
                            <span class="info-label">Product ID:</span>
                            <span class="info-value">{{ $review->productid }}</span>
                        </div>

                        @if($review->orderid)
                        <div class="info-item">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="info-label">Order ID:</span>
                            <span class="info-value">{{ $review->orderid }}</span>
                        </div>
                        @endif

                        <div class="info-item">
                            <i class="fas fa-star"></i>
                            <span class="info-label">Rating:</span>
                            <span class="info-value">{{ $review->rating }}/5</span>
                        </div>

                        @if($review->content)
                        <div class="info-item">
                            <i class="fas fa-comment"></i>
                            <span class="info-label">Content:</span>
                            <span class="info-value">{{ Str::limit($review->content, 100) }}</span>
                        </div>
                        @endif

                        <div class="info-item">
                            <i class="fas fa-circle"></i>
                            <span class="info-label">Status:</span>
                            <span class="info-value {{ strtolower($review->status) }}">
                                {{ ucfirst($review->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="item-footer">
                        <div class="created-date">
                            <i class="fas fa-calendar-alt"></i>
                            Created {{ $review->created_at->diffForHumans() }}
                        </div>
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
            </div>
            @empty
            <div class="empty-state">
                <div class="empty-content">
                    <i class="fas fa-comments empty-icon"></i>
                    <h3 class="empty-title">No Reviews Found</h3>
                    <p class="empty-text">
                        You haven’t added any reviews yet. Create one to get started.
                    </p>
                    @if(canManageProducts())
                    <button type="button" class="btn-add-first" data-bs-toggle="modal" data-bs-target="#addReviewModal">
                        <i class="fas fa-plus"></i>
                        Create Your First Review
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
        });

        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'n' && !e.shiftKey) {
                e.preventDefault();
                const addReviewModal = new bootstrap.Modal(document.getElementById('addReviewModal'));
                addReviewModal.show();
            }
        });
    });

    function openEditReviewModal(id, data) {
        openUpdateModal(id, data);
    }

    function openDeleteReviewModal(id, data) {
        openDeleteModal(id, data);
    }
</script>
@endsection