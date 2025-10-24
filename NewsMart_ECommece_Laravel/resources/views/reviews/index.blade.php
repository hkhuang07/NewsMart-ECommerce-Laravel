@extends('layouts.app')

@section('title', 'Review Management')

@section('styles')
<link href="{{ asset('css/list.css') }}" rel="stylesheet">
<link href="{{ asset('css/form.css') }}" rel="stylesheet">
<style>
    .review-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 2rem;
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .review-table th,
    .review-table td {
        padding: 12px 16px;
        text-align: left;
        vertical-align: middle;
    }

    .review-table thead {
        background-color: #f4f6f8;
        color: #333;
        font-weight: 600;
    }

    .review-table tbody tr {
        border-bottom: 1px solid #eaeaea;
        transition: background 0.2s ease;
    }

    .review-table tbody tr:hover {
        background-color: #f9fafc;
    }

    .review-actions button {
        margin-right: 6px;
    }

    .empty-state {
        text-align: center;
        padding: 50px;
        color: #777;
    }
</style>
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
                        Manage and review customer feedback
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

    <div class="container mx-auto px-4 py-6">
        @if($reviews->isEmpty())
        <div class="empty-state">
            <i class="fas fa-comments fa-3x mb-3"></i>
            <h3>No Reviews Found</h3>
            {{-- <p>You haven't added any reviews yet. Start by creating one below.</p> --}}
            @if(canManageProducts())
            {{-- <button class="btn-add-first" data-bs-toggle="modal" data-bs-target="#addReviewModal">
                <i class="fas fa-plus"></i> Add Review
            </button> --}}
            @endif
        </div>
        @else
        <table class="review-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product</th>
                    <th>User</th>
                    <th>Rating</th>
                    <th>Comment</th>
                    <th>Status</th>
                    <th>Created</th>
                    @if(canManageProducts())
                    <th>Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($reviews as $review)
                <tr>
                    <td>#{{ $review->id }}</td>
                    <td>{{ $review->product->name ?? 'N/A' }}</td>
                    <td>{{ $review->user->name ?? 'Anonymous' }}</td>
                    <td>
                        @for($i = 1; $i <= 5; $i++) <i
                            class="fa{{ $i <= $review->rating ? 's' : 'r' }} fa-star text-warning"></i>
                            @endfor
                    </td>
                    <td>{{ Str::limit($review->comment, 50) }}</td>
                    <td>
                        @if($review->status === 'approved')
                        <span class="badge bg-success">Approved</span>
                        @elseif($review->status === 'pending')
                        <span class="badge bg-warning text-dark">Pending</span>
                        @else
                        <span class="badge bg-danger">Rejected</span>
                        @endif
                    </td>
                    <td>{{ $review->created_at->format('d/m/Y H:i') }}</td>
                    @if(canManageProducts())
                    <td class="review-actions">
                        <button class="btn btn-sm btn-outline-primary"
                            onclick="openEditReviewModal('{{ $review->id }}', {{ json_encode($review) }})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger"
                            onclick="openDeleteReviewModal('{{ $review->id }}', {{ json_encode($review) }})">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>

@include('reviews.add')
@include('reviews.update')
@include('reviews.delete')
@endsection

@section('scripts')
<script>
    function openEditReviewModal(reviewId, reviewData) {
        openUpdateModal(reviewId, reviewData);
    }

    function openDeleteReviewModal(reviewId, reviewData) {
        openDeleteModal(reviewId, reviewData);
    }
</script>

@if ($errors->any() && !session('update_errors') && !session('delete_errors'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const addReviewModal = new bootstrap.Modal(document.getElementById('addReviewModal'));
    addReviewModal.show();
});
</script>
@endif

@if (session('update_errors'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const updateReviewModal = new bootstrap.Modal(document.getElementById('updateReviewModal'));
    updateReviewModal.show();
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