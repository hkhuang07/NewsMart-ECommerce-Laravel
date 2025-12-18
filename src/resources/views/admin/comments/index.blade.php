@extends('layouts.app')

@section('title', 'Comments Management')

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
                        Comment Management
                    </h1>
                    <p class="page-subtitle">
                        View, manage and moderate user comments
                    </p>
                </div>

                <div class="header-right">
                    <button type="button" class="btn-add-new" data-bs-toggle="modal" data-bs-target="#addCommentModal">
                        <i class="fa-light fa-plus"></i>
                        Add New Comment
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div id="loadingState" class="loading-container d-none">
            <div class="loading-spinner"></div>
            <p class="loading-text">Loading comments...</p>
        </div>

        <div class="items-grid" id="commentsGrid">
            @forelse($comments as $comment)
            <div class="item-card" data-comment-id="{{ $comment->id }}">

                <div class="item-content comment-content">
                    <h3 class="item-title" title="Comment ID #{{ $comment->id }}">
                        Comment #{{ $comment->id }}
                    </h3>

                    <div class="item-info">

                        <div class="info-item">
                            <i class="fas fa-file-alt"></i>
                            <span class="info-label">Post ID:</span>
                            <span class="info-value">{{ $comment->postid }}</span>
                        </div>

                        <div class="info-item">
                            <i class="fas fa-user"></i>
                            <span class="info-label">User ID:</span>
                            <span class="info-value">{{ $comment->userid }}</span>
                        </div>

                        <div class="info-item">
                            <i class="fas fa-reply"></i>
                            <span class="info-label">Parent Comment:</span>
                            <span class="info-value">
                                {{ $comment->parentcommentid ?? 'None' }}
                            </span>
                        </div>

                        <div class="item-description">
                            {{ Str::limit($comment->content, 150) }}
                        </div>

                    </div>

                    <div class="item-footer">
                        <div class="created-date">
                            <i class="fas fa-calendar-alt"></i>
                            Created {{ $comment->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>

                <div class="action-overlay">
                    <div class="action-buttons">
                        <button type="button" class="action-btn edit-btn" title="Edit Comment"
                            onclick="openEditCommentModal('{{ $comment->id }}', {{ json_encode($comment) }})">
                            <i class="fas fa-edit"></i>
                            <span>Edit</span>
                        </button>

                        <button type="button" class="action-btn delete-btn" title="Delete Comment"
                            onclick="openDeleteCommentModal('{{ $comment->id }}', {{ json_encode($comment) }})">
                            <i class="fas fa-trash-alt"></i>
                            <span>Delete</span>
                        </button>
                    </div>
                </div>

            </div>
            @empty
            <div class="empty-state">
                <div class="empty-content">
                    <i class="fas fa-comments empty-icon"></i>
                    <h3 class="empty-title">No Comments Found</h3>
                    <p class="empty-text">
                        There are no comments yet.
                    </p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>

{{-- Include Modals --}}
@include('admin.comments.add')
@include('admin.comments.update')
@include('admin.comments.delete')

@endsection

@section('scripts')
<script>
    function openEditCommentModal(id, data) {
        openUpdateCommentModal(id, data);
    }

    function openDeleteCommentModal(id, data) {
        openDeleteCommentModalConfirm(id, data);
    }

    // Card Hover Interactions
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
    });
</script>
@endsection