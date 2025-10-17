<?php $__env->startSection('title', 'Order Status Management'); ?>

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
                        <i class="fas fa-clipboard-list"></i>
                        Order Status Management
                    </h1>
                    <p class="page-subtitle">
                        Manage and organize order statuses
                    </p>
                </div>
                <div class="header-right">
                    <?php if(canManageOrders()): ?>
                    <button type="button" class="btn-add-new" data-bs-toggle="modal" data-bs-target="#addOrderStatusModal">
                        <i class="fa-light fa-plus"></i>
                        Add New Status
                    </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-8">
        <div id="loadingState" class="loading-container d-none">
            <div class="loading-spinner"></div>
            <p class="loading-text">Loading order statuses...</p>
        </div>

        <div class="items-grid" id="statusesGrid">
            <?php $__empty_1 = true; $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="item-card" data-status-id="<?php echo e($status->id); ?>">
                <div class="item-image-container status-icon">
                    <div class="item-image-placeholder">
                        <i class="fas fa-clipboard-check"></i>
                    </div>

                    <div class="status-badge">
                        <i class="fas fa-check-circle"></i>
                        Active
                    </div>

                    <?php if(canManageOrders()): ?>
                    <div class="action-overlay">
                        <div class="action-buttons">
                            <button type="button"
                                class="action-btn edit-btn"
                                title="Edit Status"
                                onclick="openEditStatusModal('<?php echo e($status->id); ?>', <?php echo e(json_encode($status)); ?>)">
                                <i class="fas fa-edit"></i>
                                <span>Edit</span>
                            </button>
                            <button type="button"
                                class="action-btn delete-btn"
                                title="Delete Status"
                                onclick="openDeleteStatusModal('<?php echo e($status->id); ?>', <?php echo e(json_encode($status)); ?>)">
                                <i class="fas fa-trash-alt"></i>
                                <span>Delete</span>
                            </button>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="item-content">
                    <h3 class="item-title" title="<?php echo e($status->name); ?>">
                        <?php echo e($status->name); ?>

                    </h3>

                    <?php if($status->description): ?>
                    <div class="item-description">
                        <?php echo e(Str::limit($status->description, 120)); ?>

                    </div>
                    <?php endif; ?>

                    <div class="item-footer">
                        <div class="created-date">
                            <i class="fas fa-calendar-alt"></i>
                            Created <?php echo e($status->created_at->diffForHumans()); ?>

                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="empty-state">
                <div class="empty-content">
                    <i class="fas fa-clipboard-list empty-icon"></i>
                    <h3 class="empty-title">No Order Status Found</h3>
                    <p class="empty-text">
                        You haven't added any order status yet. Create your first one to start tracking orders.
                    </p>
                    <?php if(canManageOrders()): ?>
                    <button type="button" class="btn-add-first" data-bs-toggle="modal" data-bs-target="#addOrderStatusModal">
                        <i class="fas fa-plus"></i>
                        Create Your First Status
                    </button>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php echo $__env->make('order_statuses.add', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('order_statuses.update', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('order_statuses.delete', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
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

        // Keyboard shortcut for adding
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'n' && !e.shiftKey) {
                e.preventDefault();
                const modal = new bootstrap.Modal(document.getElementById('addOrderStatusModal'));
                modal.show();
            }
        });
    });

    function openEditStatusModal(id, data) {
        openUpdateModal(id, data);
    }

    function openDeleteStatusModal(id, data) {
        window.openDeleteModal(id, data);
    }

    function showLoading() {
        document.getElementById('loadingState').classList.remove('d-none');
        document.getElementById('statusesGrid').style.opacity = '0.3';
    }

    function hideLoading() {
        document.getElementById('loadingState').classList.add('d-none');
        document.getElementById('statusesGrid').style.opacity = '1';
    }

    function filterStatuses(searchTerm) {
        const cards = document.querySelectorAll('.item-card');
        let visibleCount = 0;

        cards.forEach(card => {
            const name = card.querySelector('.item-title').textContent.toLowerCase();
            const description = card.querySelector('.item-description')?.textContent.toLowerCase() || '';
            const isVisible = name.includes(searchTerm.toLowerCase()) || description.includes(searchTerm.toLowerCase());
            card.style.display = isVisible ? 'block' : 'none';
            if (isVisible) visibleCount++;
        });

        const emptyState = document.querySelector('.empty-state');
        if (emptyState) emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
    }
</script>


<?php if($errors->any() && !session('update_errors') && !session('delete_errors')): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = new bootstrap.Modal(document.getElementById('addOrderStatusModal'));
    modal.show();
    const errorMessage = document.getElementById('errorMessage');
    if (errorMessage) {
        errorMessage.innerHTML = '<strong>Please fix the following errors:</strong><ul><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>';
        errorMessage.style.display = 'block';
    }
});
</script>
<?php endif; ?>

<?php if(session('update_errors')): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = new bootstrap.Modal(document.getElementById('updateOrderStatusModal'));
    modal.show();
    const errorMessage = document.getElementById('updateErrorMessage');
    if (errorMessage) {
        errorMessage.innerHTML = '<strong>Please fix the following errors:</strong><ul><?php $__currentLoopData = session('update_errors')->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul>';
        errorMessage.style.display = 'block';
    }
});
</script>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\wamp64\www\Project\NewsMart_ECommece_Laravel\resources\views/order_statuses/index.blade.php ENDPATH**/ ?>