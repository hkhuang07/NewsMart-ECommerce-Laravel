@extends('layouts.app')

@section('title', 'Post Management')

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
                        <i class="fas fa-newspaper"></i>
                        Post Management
                    </h1>
                    <p class="page-subtitle">
                        Manage and organize all blog posts
                    </p>
                </div>
                <div class="header-right">
                    @if(canManagePosts())
                    <button type="button" class="btn-add-new" data-bs-toggle="modal" data-bs-target="#addPostModal">
                        <i class="fa-light fa-plus"></i>
                        Add New Post
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div id="loadingState" class="loading-container d-none">
            <div class="loading-spinner"></div>
            <p class="loading-text">Loading posts...</p>
        </div>

        <div class="items-grid" id="postsGrid">
            @forelse($posts as $post)
            <div class="item-card" data-post-id="{{ $post->id }}">
                <div class="status-badge {{ $post->status === 'Published' ? 'bg-success' : 'bg-secondary' }}">
                    <i class="fas fa-circle"></i>
                    {{ ucfirst($post->status) }}
                </div>

                <div class="item-content">
                    <h3 class="item-title" title="{{ $post->title }}">
                        {{ Str::limit($post->title, 50) }}
                    </h3>

                    @if($post->image)
                    <div class="item-image mb-3">
                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
                            class="img-fluid rounded">
                    </div>
                    @endif

                    <div class="item-info">
                        <div class="item-description">
                            {{ Str::limit(strip_tags($post->content), 120) }}
                        </div>
                    </div>

                    @if(canManagePosts())
                    <div class="action-overlay">
                        <div class="action-buttons">
                            <button type="button" class="action-btn edit-btn" title="Edit Post"
                                onclick="openEditPostModal('{{ $post->id }}', {{ json_encode($post) }})">
                                <i class="fas fa-edit"></i>
                                <span>Edit</span>
                            </button>
                            <button type="button" class="action-btn delete-btn" title="Delete Post"
                                onclick="openDeletePostModal('{{ $post->id }}', {{ json_encode($post) }})">
                                <i class="fas fa-trash-alt"></i>
                                <span>Delete</span>
                            </button>
                        </div>
                    </div>
                    @endif

                    <div class="item-footer">
                        <div class="created-date">
                            <i class="fas fa-calendar-alt"></i>
                            Created {{ $post->created_at->diffForHumans() }}
                        </div>
                        <div class="views-count">
                            <i class="fas fa-eye"></i>
                            {{ $post->views }} views
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <div class="empty-content">
                    <i class="fas fa-newspaper empty-icon"></i>
                    <h3 class="empty-title">No Posts Found</h3>
                    <p class="empty-text">
                        You haven’t published any posts yet. Start managing your content by creating your first one.
                    </p>
                    @if(canManagePosts())
                    <button type="button" class="btn-add-first" data-bs-toggle="modal" data-bs-target="#addPostModal">
                        <i class="fas fa-plus"></i>
                        Create Your First Post
                    </button>
                    @endif
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>

@include('posts.add')
@include('posts.update')
@include('posts.delete')

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
                    console.log('Post card clicked:', this.dataset.postId);
                }
            });
        });

        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'n' && !e.shiftKey) {
                e.preventDefault();
                const addPostModal = new bootstrap.Modal(document.getElementById('addPostModal'));
                addPostModal.show();
            }
        });
    });

    function openEditPostModal(postId, postData) {
        openUpdatePostModal(postId, postData);
    }

    function openDeletePostModal(postId, postData) {
        openDeletePostModal(postId, postData);
    }

    function showLoading() {
        const loadingState = document.getElementById('loadingState');
        const postsGrid = document.getElementById('postsGrid');
        if (loadingState && postsGrid) {
            loadingState.classList.remove('d-none');
            postsGrid.style.opacity = '0.3';
        }
    }

    function hideLoading() {
        const loadingState = document.getElementById('loadingState');
        const postsGrid = document.getElementById('postsGrid');
        if (loadingState && postsGrid) {
            loadingState.classList.add('d-none');
            postsGrid.style.opacity = '1';
        }
    }

    function filterPosts(searchTerm) {
        const cards = document.querySelectorAll('.item-card');
        let visibleCount = 0;

        cards.forEach(card => {
            const postTitle = card.querySelector('.item-title').textContent.toLowerCase();
            const postContent = card.querySelector('.item-description')?.textContent.toLowerCase() || '';

            const isVisible = postTitle.includes(searchTerm.toLowerCase()) || postContent.includes(searchTerm.toLowerCase());

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
        const addPostModal = new bootstrap.Modal(document.getElementById('addPostModal'));
        addPostModal.show();
    });
</script>
@endif

@if (session('update_errors'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const updatePostModal = new bootstrap.Modal(document.getElementById('updatePostModal'));
        updatePostModal.show();
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