@extends('layouts.app')

@section('title', 'Configuration Management')

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
                        <i class="fas fa-cogs"></i>
                        Configuration Management
                    </h1>
                    <p class="page-subtitle">
                        Manage and customize system configurations
                    </p>
                </div>
                <div class="header-right">
                    @if(canManageConfigurations())
                    <button type="button" class="btn-add-new" data-bs-toggle="modal"
                        data-bs-target="#addConfigurationModal">
                        <i class="fa-light fa-plus"></i>
                        Add New Configuration
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div id="loadingState" class="loading-container d-none">
            <div class="loading-spinner"></div>
            <p class="loading-text">Loading configurations...</p>
        </div>

        <div class="items-grid" id="configsGrid">
            @forelse($configurations as $config)
            <div class="item-card" data-config-key="{{ $config->settingkey }}">
                <div class="item-image-container">
                    <div class="item-image-placeholder">
                        <i class="fas fa-sliders-h"></i>
                    </div>

                    <div class="status-badge">
                        <i class="fas fa-check-circle"></i>
                        Active
                    </div>

                    @if(canManageConfigurations())
                    <div class="action-overlay">
                        <div class="action-buttons">
                            <button type="button" class="action-btn edit-btn" title="Edit Configuration"
                                onclick="openEditConfigModal('{{ $config->settingkey }}', {{ json_encode($config) }})">
                                <i class="fas fa-edit"></i>
                                <span>Edit</span>
                            </button>
                            <button type="button" class="action-btn delete-btn" title="Delete Configuration"
                                onclick="openDeleteConfigModal('{{ $config->settingkey }}', {{ json_encode($config) }})">
                                <i class="fas fa-trash-alt"></i>
                                <span>Delete</span>
                            </button>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="item-content">
                    <h3 class="item-title" title="{{ $config->settingkey }}">
                        {{ $config->settingkey }}
                    </h3>

                    <div class="item-info">
                        @if($config->settingvalue)
                        <div class="info-item">
                            <i class="fas fa-database"></i>
                            <span class="info-label">Value:</span>
                            <span class="info-value" title="{{ $config->settingvalue }}">
                                {{ Str::limit($config->settingvalue, 50) }}
                            </span>
                        </div>
                        @endif

                        @if($config->description)
                        <div class="item-description">
                            {{ Str::limit($config->description, 100) }}
                        </div>
                        @endif
                    </div>

                    <div class="item-footer">
                        <div class="created-date">
                            <i class="fas fa-calendar-alt"></i>
                            Created {{ $config->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <div class="empty-content">
                    <i class="fas fa-cogs empty-icon"></i>
                    <h3 class="empty-title">No Configurations Found</h3>
                    <p class="empty-text">
                        You haven't added any configurations yet. Start by creating your first system setting.
                    </p>
                    @if(canManageConfigurations())
                    <button type="button" class="btn-add-first" data-bs-toggle="modal"
                        data-bs-target="#addConfigurationModal">
                        <i class="fas fa-plus"></i>
                        Create Your First Configuration
                    </button>
                    @endif
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>

@include('configurations.add')
@include('configurations.update')
@include('configurations.delete')

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

        // Ctrl + N shortcut
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'n' && !e.shiftKey) {
                e.preventDefault();
                const addConfigModal = new bootstrap.Modal(document.getElementById('addConfigModal'));
                addConfigModal.show();
            }
        });
    });

    function openEditConfigModal(key, data) {
        openUpdateModal(key, data);
    }

    // function openDeleteConfigModal(key, data) {
    //     openDeleteModal(key, data);
    // }

    function openDeleteConfigModal(key, data) {
    // Gọi đúng hàm trong file delete.blade.php
    document.getElementById('deleteConfigKeyToDelete').textContent = key;

    const deleteBtn = document.getElementById('deleteConfirmDeleteConfigBtn');
    deleteBtn.href = `{{ route('configuration.delete', ['settingkey' => '__KEY__']) }}`.replace('__KEY__', key);

    document.getElementById('deleteConfigValue').textContent = data.settingvalue || 'N/A';
    document.getElementById('deleteConfigDescription').textContent = data.description || 'N/A';
    document.getElementById('deleteConfigCreatedAt').textContent = data.created_at || 'N/A';
    document.getElementById('deleteConfigUpdatedAt').textContent = data.updated_at || 'N/A';

    const deleteModal = new bootstrap.Modal(document.getElementById('deleteConfigurationModal'));
    deleteModal.show();
}


    function showLoading() {
        const loadingState = document.getElementById('loadingState');
        const grid = document.getElementById('configsGrid');
        if (loadingState && grid) {
            loadingState.classList.remove('d-none');
            grid.style.opacity = '0.3';
        }
    }

    function hideLoading() {
        const loadingState = document.getElementById('loadingState');
        const grid = document.getElementById('configsGrid');
        if (loadingState && grid) {
            loadingState.classList.add('d-none');
            grid.style.opacity = '1';
        }
    }

    function filterConfigs(searchTerm) {
        const cards = document.querySelectorAll('.item-card');
        let visibleCount = 0;

        cards.forEach(card => {
            const key = card.querySelector('.item-title').textContent.toLowerCase();
            const value = card.querySelector('.info-value')?.textContent.toLowerCase() || '';
            const desc = card.querySelector('.item-description')?.textContent.toLowerCase() || '';

            const visible = key.includes(searchTerm.toLowerCase()) ||
                value.includes(searchTerm.toLowerCase()) ||
                desc.includes(searchTerm.toLowerCase());

            card.style.display = visible ? 'block' : 'none';
            if (visible) visibleCount++;
        });

        const emptyState = document.querySelector('.empty-state');
        if (emptyState) emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
    }
</script>

@if ($errors->any() && !session('update_errors') && !session('delete_errors'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const addModal = new bootstrap.Modal(document.getElementById('addConfigModal'));
    addModal.show();
});
</script>
@endif

@if (session('update_errors'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const updateModal = new bootstrap.Modal(document.getElementById('updateConfigModal'));
    updateModal.show();
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