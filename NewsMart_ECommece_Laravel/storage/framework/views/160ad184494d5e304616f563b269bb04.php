<?php $__env->startSection('title', 'Role Management'); ?>

<?php $__env->startSection('styles'); ?>
<link href="<?php echo e(asset('css/list.css')); ?>" rel="stylesheet">
<link href="<?php echo e(asset('css/form.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="item-management-container">
    <div class="item-header">
        <div class="container mx-auto px-4">
            <div class="header-content">
                <div class="header-left">
                    <h1 class="page-title">
                        <i class="fas fa-user-shield"></i>
                        Role Management
                    </h1>
                    <p class="page-subtitle">
                        Manage and organize user roles and permissions
                    </p>
                </div>
                <div class="header-right">
                    <?php if(canManageProducts()): ?>
                    <button type="button" class="btn-add-new" data-bs-toggle="modal" data-bs-target="#addRoleModal">
                        <i class="fa-light fa-plus"></i>
                        Add New Role
                    </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div id="loadingState" class="loading-container d-none">
            <div class="loading-spinner"></div>
            <p class="loading-text">Loading roles...</p>
        </div>

        <div class="items-grid" id="rolesGrid">
            <?php $__empty_1 = true; $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="item-card" data-role-id="<?php echo e($role->id); ?>">
                <div class="item-image-container">
                    <div class="item-image-placeholder">
                        <i class="fas fa-user-tag"></i>
                    </div>

                    <div class="status-badge">
                        <i class="fas fa-check-circle"></i>
                        Active
                    </div>

                    <?php if(canManageProducts()): ?>
                    <div class="action-overlay">
                        <div class="action-buttons">
                            <button type="button"
                                class="action-btn edit-btn"
                                title="Edit Role"
                                onclick="openEditRoleModal('<?php echo e($role->id); ?>', <?php echo e(json_encode($role)); ?>)">
                                <i class="fas fa-edit"></i>
                                <span>Edit</span>
                            </button>
                            <button type="button"
                                class="action-btn delete-btn"
                                title="Delete Role"
                                onclick="openDeleteRoleModal('<?php echo e($role->id); ?>', <?php echo e(json_encode($role)); ?>)">
                                <i class="fas fa-trash-alt"></i>
                                <span>Delete</span>
                            </button>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="item-content">
                    <h3 class="item-title" title="<?php echo e($role->name); ?>">
                        <?php echo e($role->name); ?>

                    </h3>

                    <?php if($role->description): ?>
                    <div class="item-description">
                        <?php echo e(Str::limit($role->description, 100)); ?>

                    </div>
                    <?php endif; ?>

                    <div class="item-footer">
                        <div class="created-date">
                            <i class="fas fa-calendar-alt"></i>
                            Created <?php echo e($role->created_at->diffForHumans()); ?>

                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="empty-state">
                <div class="empty-content">
                    <i class="fas fa-user-shield empty-icon"></i>
                    <h3 class="empty-title">No Roles Found</h3>
                    <p class="empty-text">
                        You haven't created any roles yet. Start managing permissions by adding your first role.
                    </p>
                    <?php if(canManageProducts()): ?>
                    <button type="button" class="btn-add-first" data-bs-toggle="modal" data-bs-target="#addRoleModal">
                        <i class="fas fa-plus"></i>
                        Create Your First Role
                    </button>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php echo $__env->make('roles.add', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('roles.update', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('roles.delete', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
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
                    console.log('Role card clicked:', this.dataset.roleId);
                }
            });
        });

        // Keyboard shortcut for adding new role
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'n' && !e.shiftKey) {
                e.preventDefault();
                const addRoleModal = new bootstrap.Modal(document.getElementById('addRoleModal'));
                addRoleModal.show();
            }
        });
    });

    // Edit Role Modal Function
    function openEditRoleModal(roleId, roleData) {
        openUpdateModal(roleId, roleData);
    }

    // Delete Role Modal Function
    function openDeleteRoleModal(roleId, roleData) {
        openDeleteModal(roleId, roleData);
    }

    // Loading functions
    function showLoading() {
        const loadingState = document.getElementById('loadingState');
        const rolesGrid = document.getElementById('rolesGrid');

        if (loadingState && rolesGrid) {
            loadingState.classList.remove('d-none');
            rolesGrid.style.opacity = '0.3';
        }
    }

    function hideLoading() {
        const loadingState = document.getElementById('loadingState');
        const rolesGrid = document.getElementById('rolesGrid');

        if (loadingState && rolesGrid) {
            loadingState.classList.add('d-none');
            rolesGrid.style.opacity = '1';
        }
    }

    // Search functionality
    function filterRoles(searchTerm) {
        const cards = document.querySelectorAll('.item-card');
        let visibleCount = 0;

        cards.forEach(card => {
            const roleName = card.querySelector('.item-title').textContent.toLowerCase();
            const roleDescription = card.querySelector('.item-description')?.textContent.toLowerCase() || '';

            const isVisible = roleName.includes(searchTerm.toLowerCase()) ||
                              roleDescription.includes(searchTerm.toLowerCase());

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

<?php if($errors->any() && !session('update_errors') && !session('delete_errors')): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const addRoleModal = new bootstrap.Modal(document.getElementById('addRoleModal'));
    addRoleModal.show();
});
</script>
<?php endif; ?>

<?php if(session('update_errors')): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const updateRoleModal = new bootstrap.Modal(document.getElementById('updateRoleModal'));
    updateRoleModal.show();
});
</script>
<?php endif; ?>

<?php if(session('success')): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    alert('<?php echo e(session('success')); ?>');
});
</script>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\Project\NewsMart_ECommece_Laravel\resources\views/roles/index.blade.php ENDPATH**/ ?>