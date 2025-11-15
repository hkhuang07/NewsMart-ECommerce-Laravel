<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content item-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="addProductModalLabel">
                    <i class="fa-light fa-plus-circle"></i>
                    Add New Product
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="modalMessages" class="mb-3" style="display: none;">
                    <div id="errorMessage" class="alert alert-danger" style="display: none;"></div>
                    <div id="successMessage" class="alert alert-success" style="display: none;"></div>
                </div>

                <form id="addProductForm" action="{{ route('admin.product.add') }}" method="post" enctype="multipart/form-data">
                    @csrf

					<div class="form-group mb-4">
						<label class="form-label" for="updatecategoryid">
							<i class="fa-light fa-layer-group"></i> Category
						</label>
						<select class="form-select @error('categoryid') is-invalid @enderror" id="categoryid" name="categoryid" required>
							<option value="">-- Choose --</option>
							@foreach($categories as $value)
								<option value="{{ $value->id }}">{{ $value->name }}</option>
							@endforeach
						</select>
						@error('categoryid')
							<div class="invalid-feedback"><strong>{{ $message }}</strong></div>
						@enderror
					</div>

					<div class="form-group mb-4">
						<label class="form-label" for="brandid">
							<i class="fa-light fa-copyright"></i> Brand
						</label>
						<select class="form-select @error('brandid') is-invalid @enderror" id="brandid" name="brandid" required>
							<option value="">-- Choose --</option>
							@foreach($brands as $value)
								<option value="{{ $value->id }}">{{ $value->name }}</option>
							@endforeach
						</select>
						@error('brandid')
							<div class="invalid-feedback"><strong>{{ $message }}</strong></div>
						@enderror
					</div>

					<div class="form-group mb-4">
						<label class="form-label" for="salerid">
							<i class="fa-light fa-user-tag"></i> Saler
						</label>
						<select class="form-select @error('salerid') is-invalid @enderror" id="salerid" name="salerid" required>
							<option value="">-- Choose --</option>
							@foreach($users as $value)
								<option value="{{ $value->id }}">{{ $value->name }}</option>
							@endforeach
						</select>
						@error('salerid')
							<div class="invalid-feedback"><strong>{{ $message }}</strong></div>
						@enderror
					</div>

					<div class="form-group mb-4">
						<label class="form-label" for="name">
							<i class="fa-light fa-box-open"></i> Product Name
						</label>
						<input
							type="text"
							class="form-control item-input @error('name') is-invalid @enderror"
							id="name"
							name="name"
							value="{{ old('name') }}"
							placeholder="Enter product name"
							required />
						@error('name')
						<div class="invalid-feedback">
							<strong>{{ $message }}</strong>
						</div>
						@enderror
					</div>

					<div class="form-group mb-4">
						<label class="form-label" for="sku">
							<i class="fa-light fa-barcode"></i> SKU
						</label>
						<input
							type="text"
							class="form-control item-input @error('sku') is-invalid @enderror"
							id="sku"
							name="sku"
							value="{{ old('sku') }}"
							placeholder="Enter product sku" />
						@error('sku')
						<div class="invalid-feedback">
							<strong>{{ $message }}</strong>
						</div>
						@enderror
					</div>

					<div class="form-group mb-4">
						<label class="form-label" for="description">
							<i class="fa-light fa-file-lines"></i> Product Description
						</label>
						<textarea
							class="form-control item-textarea @error('description') is-invalid @enderror"
							id="description"
							name="description"
							rows="4"
							placeholder="Enter product description">{{ old('description') }}</textarea>
						@error('description')
						<div class="invalid-feedback">
							<strong>{{ $message }}</strong>
						</div>
						@enderror
					</div>

					<div class="mb-3">
						<label class="form-label" for="price">
							<i class="fa-light fa-money-bill"></i> Price
						</label>
						<input type="number" min="0" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" required />
						@error('price')
							<div class="invalid-feedback"><strong>{{ $message }}</strong></div>
						@enderror
					</div>

					<div class="mb-3">
						<label class="form-label" for="stockquantity">
							<i class="fa-light fa-warehouse"></i> Stock Quantity
						</label>
						<input type="number" min="0" class="form-control @error('stockquantity') is-invalid @enderror" id="stockquantity" name="stockquantity" value="{{ old('stockquantity') }}" required />
						@error('stockquantity')
							<div class="invalid-feedback"><strong>{{ $message }}</strong></div>
						@enderror
					</div>

					<div class="mb-3">
						<label class="form-label" for="discount">
							<i class="fa-light fa-percentage"></i> Discount
						</label>
						<input type="number" step="0.01" class="form-control @error('discount') is-invalid @enderror" id="discount" name="discount" value="{{ old('discount') }}" required />
						@error('discount')
							<div class="invalid-feedback"><strong>{{ $message }}</strong></div>
						@enderror
					</div>

					<div class="mb-3">
						<label class="form-label" for="averragerate">
							<i class="fa-light fa-star"></i> Averragerate
						</label>
						<input type="number" step="0.1" min="0" max="5" class="form-control @error('averragerate') is-invalid @enderror" id="averragerate" name="averragerate" value="{{ old('averragerate') }}" required />
						@error('averragerate')
							<div class="invalid-feedback"><strong>{{ $message }}</strong></div>
						@enderror
					</div>
					
                   
					
					<div class="form-group mb-4">
						<div class="form-check form-switch">
							<input type="hidden" name="isactive" value="0">
							<input class="form-check-input" type="checkbox" id="isactive" name="isactive" value="1" {{ old('isactive', true) ? 'checked' : '' }}>
							<label class="form-check-label" for="isactive">Product Is Active</label>
						</div>
						@error('isactive')
							<div class="text-danger small mt-1"><strong>{{ $message }}</strong></div>
						@enderror
					</div>		
					
                </form>
            </div>

            <div class="modal-footer item-modal-footer">
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">
                    <i class="fa-light fa-times"></i>
                    Cancel
                </button>
                <button type="submit" form="addProductForm" class="btn btn-action" id="submitBtn">
                    <i class="fa-light fa-save"></i>
                    <span class="btn-text">Add Product</span>
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
        const addProductModal = document.getElementById('addProductModal');
        const addProductForm = document.getElementById('addProductForm');
        const submitBtn = document.getElementById('submitBtn');
        const btnText = submitBtn.querySelector('.btn-text');
        const btnLoading = submitBtn.querySelector('.btn-loading');

        // Reset form when modal is hidden
        addProductModal.addEventListener('hidden.bs.modal', function() {
            addProductForm.reset();

            const fileInput = document.getElementById('logo');
            if (fileInput) {
                fileInput.value = '';
            }

            // Clear validation errors
            const invalidInputs = addProductForm.querySelectorAll('.is-invalid');
            invalidInputs.forEach(input => {
                input.classList.remove('is-invalid');
            });
            const feedbacks = addProductForm.querySelectorAll('.invalid-feedback');
            feedbacks.forEach(feedback => {
                feedback.style.display = 'none';
            });
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
        addProductForm.addEventListener('submit', function(e) {
            // Show loading state
            submitBtn.disabled = true;
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline';
        });

        // Focus first input when modal is shown
        addProductModal.addEventListener('shown.bs.modal', function() {
            document.getElementById('name').focus();
        });
    });
</script>