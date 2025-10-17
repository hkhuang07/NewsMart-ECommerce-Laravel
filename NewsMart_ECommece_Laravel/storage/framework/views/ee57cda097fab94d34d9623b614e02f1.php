<div class="modal fade" id="addOrderStatusModal" tabindex="-1" aria-labelledby="addOrderStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content item-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="addOrderStatusModalLabel">
                    <i class="fa-light fa-plus-circle"></i>
                    Add New Order Status
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="modalMessages" class="mb-3" style="display: none;">
                    <div id="errorMessage" class="alert alert-danger" style="display: none;"></div>
                    <div id="successMessage" class="alert alert-success" style="display: none;"></div>
                </div>

                <form id="addOrderStatusForm" action="<?php echo e(route('order_statuses.add')); ?>" method="post">
                    <?php echo csrf_field(); ?>

                    <div class="form-group mb-4">
                        <label class="form-label" for="name">
                            <i class="fa-light fa-tag"></i>
                            Status Name
                        </label>
                        <input
                            type="text"
                            class="form-control item-input <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            id="name"
                            name="name"
                            value="<?php echo e(old('name')); ?>"
                            placeholder="Enter status name"
                            required />
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback">
                            <strong><?php echo e($message); ?></strong>
                        </div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="form-group mb-4">
                        <label class="form-label" for="description">
                            <i class="fa-light fa-file-text"></i>
                            Description
                        </label>
                        <textarea
                            class="form-control item-textarea <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            id="description"
                            name="description"
                            rows="4"
                            placeholder="Enter description (optional)"><?php echo e(old('description')); ?></textarea>
                        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback">
                            <strong><?php echo e($message); ?></strong>
                        </div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </form>
            </div>

            <div class="modal-footer item-modal-footer">
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">
                    <i class="fa-light fa-times"></i>
                    Cancel
                </button>
                <button type="submit" form="addOrderStatusForm" class="btn btn-action" id="submitBtn">
                    <i class="fa-light fa-save"></i>
                    <span class="btn-text">Add Status</span>
                    <span class="btn-loading" style="display: none;">
                        <i class="fa-light fa-spinner fa-spin"></i>
                        Adding...
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const addOrderStatusModal = document.getElementById('addOrderStatusModal');
    const addOrderStatusForm = document.getElementById('addOrderStatusForm');
    const submitBtn = document.getElementById('submitBtn');
    const btnText = submitBtn.querySelector('.btn-text');
    const btnLoading = submitBtn.querySelector('.btn-loading');

    // Reset form when modal is hidden
    addOrderStatusModal.addEventListener('hidden.bs.modal', function() {
        addOrderStatusForm.reset();

        // Clear validation errors
        const invalidInputs = addOrderStatusForm.querySelectorAll('.is-invalid');
        invalidInputs.forEach(input => input.classList.remove('is-invalid'));

        const feedbacks = addOrderStatusForm.querySelectorAll('.invalid-feedback');
        feedbacks.forEach(fb => fb.style.display = 'none');

        // Hide messages
        document.getElementById('modalMessages').style.display = 'none';
        document.getElementById('errorMessage').style.display = 'none';
        document.getElementById('successMessage').style.display = 'none';

        // Reset button state
        submitBtn.disabled = false;
        btnText.style.display = 'inline';
        btnLoading.style.display = 'none';
    });

    // Handle form submission
    addOrderStatusForm.addEventListener('submit', function(e) {
        // Show loading state
        submitBtn.disabled = true;
        btnText.style.display = 'none';
        btnLoading.style.display = 'inline';
    });

    // Focus first input when modal is shown
    addOrderStatusModal.addEventListener('shown.bs.modal', function() {
        document.getElementById('name').focus();
    });
});
</script>
<?php /**PATH C:\wamp64\www\Project\NewsMart_ECommece_Laravel\resources\views/order_statuses/add.blade.php ENDPATH**/ ?>