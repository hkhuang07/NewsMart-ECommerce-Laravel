@extends('layouts.app')

@section('title', 'Order Status Management')

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
                        <i class="fas fa-clipboard-check"></i>
                        Order Status Management
                    </h1>
                    <p class="page-subtitle">
                        Manage and organize order statuses
                    </p>
                </div>
                <div class="header-right">
                    @if(canUpdateOrderStatus())
                    <button type="button" class="btn-add-new" data-bs-toggle="modal" data-bs-target="#addOrderStatusModal">
                        <i class="fa-light fa-plus"></i>
                        Add New Status
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div id="loadingState" class="loading-container d-none">
            <div class="loading-spinner"></div>
            <p class="loading-text">Loading statuses...</p>
        </div>

        <div class="items-grid" id="statusesGrid">
            @forelse($order_statuses as $status)
            <div class="item-card" data-status-id="{{ $status->id }}">

                <div class="status-badge">
                    <i class="fas fa-check-circle"></i>
                    Active
                </div>


                <div class="item-content">
                    <h3 class="item-title" title="{{ $status->name }}">
                        {{ $status->name }}
                    </h3>

                    <div class="item-info">

                        @if($status->description)
                        <div class="item-description">
                            {{ Str::limit($status->description, 100) }}
                        </div>
                        @endif
                    </div>

                    @if(canUpdateOrderStatus())
                    <div class="action-overlay">
                        <div class="action-buttons">
                            <button type="button"
                                class="action-btn edit-btn"
                                title="Edit Status"
                                onclick="openEditOrderStatusModal('{{ $status->id }}', {{ json_encode($status) }})">
                                <i class="fas fa-edit"></i>
                                <span>Edit</span>
                            </button>
                            <button type="button"
                                class="action-btn delete-btn"
                                title="Delete Status"
                                onclick="openDeleteOrderStatusModal('{{ $status->id }}', {{ json_encode($status) }})">
                                <i class="fas fa-trash-alt"></i>
                                <span>Delete</span>
                            </button>
                        </div>
                    </div>
                    @endif

                    <div class="item-footer">
                        <div class="created-date">
                            <i class="fas fa-calendar-alt"></i>
                            Created {{ $status->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <div class="empty-content">
                    <i class="fas fa-clipboard-check empty-icon"></i>
                    <h3 class="empty-title">No Statuses Found</h3>
                    <p class="empty-text">
                        You haven't created any statuses yet. Start managing statuses by adding your first one.
                    </p>
                    @if(canUpdateOrderStatus())
                    <button type="button" class="btn-add-first" data-bs-toggle="modal" data-bs-target="#addOrderStatusModal">
                        <i class="fas fa-plus"></i>
                        Create Your First Status
                    </button>
                    @endif
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>

@include('admin.order_statuses.add')
@include('admin.order_statuses.update')
@include('admin.order_statuses.delete')

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
                    console.log('Status card clicked:', this.dataset.statusId);
                }
            });
        });

        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'n' && !e.shiftKey) {
                e.preventDefault();
                const addOrderStatusModal = new bootstrap.Modal(document.getElementById('addOrderStatusModal'));
                addOrderStatusModal.show();
            }
        });
    });

    function openEditOrderStatusModal(statusId, statusData) {
        openUpdateStatusModal(statusId, statusData);
    }

    function openDeleteOrderStatusModal(statusId, statusData) {
        openDeleteStatusModal(statusId, statusData);
    }

    function showLoading() {
        const loadingState = document.getElementById('loadingState');
        const statusesGrid = document.getElementById('statusesGrid');

        if (loadingState && statusesGrid) {
            loadingState.classList.remove('d-none');
            statusesGrid.style.opacity = '0.3';
        }
    }

    function hideLoading() {
        const loadingState = document.getElementById('loadingState');
        const statusesGrid = document.getElementById('statusesGrid');

        if (loadingState && statusesGrid) {
            loadingState.classList.add('d-none');
            statusesGrid.style.opacity = '1';
        }
    }

    function filterStatuses(searchTerm) {
        const cards = document.querySelectorAll('.item-card');
        let visibleCount = 0;

        cards.forEach(card => {
            const statusName = card.querySelector('.item-title').textContent.toLowerCase();
            const statusDescription = card.querySelector('.item-description')?.textContent.toLowerCase() || '';

            const isVisible = statusName.includes(searchTerm.toLowerCase()) ||
                statusDescription.includes(searchTerm.toLowerCase());

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
        const addOrderStatusModal = new bootstrap.Modal(document.getElementById('addOrderStatusModal'));
        addOrderStatusModal.show();
    });
</script>
@endif

@if (session('update_errors'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const updateOrderStatusModal = new bootstrap.Modal(document.getElementById('updateOrderStatusModal'));
        updateOrderStatusModal.show();
    });
</script>
@endif

@if (session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        alert('{{ session('
            success ') }}');
    });
</script>
@endif
@endsection