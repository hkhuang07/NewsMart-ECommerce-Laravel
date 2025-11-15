@php
use App\Helpers\PermissionHelper;
use Illuminate\Support\Str;
@endphp

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
                        <i class="fas fa-cog"></i>
                        Configuration Management
                    </h1>
                    <p class="page-subtitle">
                        Manage and customize your system settings
                    </p>
                </div>
                <div class="header-right">
                    {{-- Dùng hàm helper cục bộ trong Controller --}}
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
        {{-- Status Alert Area --}}
        <div id="generalMessageArea" class="mt-3">
            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger" role="alert">
                    <i class="fas fa-exclamation-triangle"></i> {{ session('error') }}
                </div>
            @endif
        </div>
        
        <div id="loadingState" class="loading-container d-none">
            <div class="loading-spinner"></div>
            <p class="loading-text">Loading configurations...</p>
        </div>

        <div class="items-grid" id="configurationsGrid">
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
                                onclick="openEditConfigurationModal('{{ $config->settingkey }}', {{ json_encode($config) }})">
                                <i class="fas fa-edit"></i>
                                <span>Edit</span>
                            </button>
                            <button type="button" class="action-btn delete-btn"
                                onclick="openDeleteConfigurationModalWrapper('{{ $config->settingkey }}', {{ json_encode($config) }})">
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
                            <i class="fas fa-align-left"></i>
                            <span class="info-label">Value:</span>
                            <span class="info-value" title="{{ $config->settingvalue }}">
                                {{ Str::limit($config->settingvalue, 80) }}
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
                            Created {{ $config->created_at ? $config->created_at->diffForHumans() : 'N/A' }}
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="empty-state">
                <div class="empty-content">
                    <i class="fas fa-cog empty-icon"></i>
                    <h3 class="empty-title">No Configurations Found</h3>
                    <p class="empty-text">
                        You haven't added any configurations yet. Start customizing your system by creating your first
                        setting.
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
                card.style.transform = 'translateY(0) scale(1)';
            });

            card.addEventListener('click', function(e) {
                if (!e.target.closest('.action-btn') && !e.target.closest('.action-overlay')) {
                    console.log('Configuration clicked:', this.dataset.configKey);
                }
            });
        });

        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'n' && !e.shiftKey) {
                e.preventDefault();
                const addConfigModal = new bootstrap.Modal(document.getElementById('addConfigurationModal'));
                addConfigModal.show();
            }
        });
        
        // Hide general message area after 3 seconds
        setTimeout(() => {
            const generalMessageArea = document.getElementById('generalMessageArea');
            if (generalMessageArea) {
                generalMessageArea.innerHTML = '';
            }
        }, 3000);
    });

    // Edit Configuration Modal
    function openEditConfigurationModal(settingkey, configData) {
        openUpdateConfigurationModal(settingkey, configData);
    }

    // Delete Configuration Modal
    function openDeleteConfigurationModalWrapper(settingkey, configData) {
        openDeleteConfigurationModal(settingkey, configData);
    }

    // ... (rest of the JS functions: showLoading, hideLoading, filterConfigurations) ...
</script>

{{-- LỖI KHẮC PHỤC: Logic mở Modal chỉ chạy khi có session errors cụ thể --}}

@if ($errors->any() && !session('update_errors') && !session('delete_errors'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const addConfigModal = new bootstrap.Modal(document.getElementById('addConfigurationModal'));
    addConfigModal.show();

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
    const updateConfigModal = new bootstrap.Modal(document.getElementById('updateConfigurationModal'));
    updateConfigModal.show();

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
    // Logic hiển thị thông báo thành công (Giữ nguyên)
    });
</script>
@endif
@endsection