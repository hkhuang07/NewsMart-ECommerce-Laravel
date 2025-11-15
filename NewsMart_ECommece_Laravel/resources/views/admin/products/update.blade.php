<div class="modal fade" id="updateProductModal" tabindex="-1" aria-labelledby="updateProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content item-modal">
            <div class="modal-header item-modal-header">
                <h5 class="modal-title" id="updateProductModalLabel">
                    <i class="fa-light fa-edit"></i>
                    Edit Product
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="updateModalMessages" class="mb-3" style="display: none;">
                    <div id="updateErrorMessage" class="alert alert-danger" style="display: none;"></div>
                    <div id="updateSuccessMessage" class="alert alert-success" style="display: none;"></div>
                </div>

                <form id="updateProductForm" action="" method="post" enctype="multipart/form-data">
                    @csrf
					<input type="hidden" id="updateProductId" name="product_id" value="">
					<div class="form-group mb-4">
						<label class="form-label" for="categoryid">
							<i class="fa-light fa-layer-group"></i> Category
						</label>
						<select class="form-select @error('categoryid') is-invalid @enderror" id="updateCategoryId" name="categoryid" required>
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
						<select class="form-select @error('brandid') is-invalid @enderror" id="updateBrandId" name="brandid" required>
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
						<select class="form-select @error('salerid') is-invalid @enderror" id="updateSalerId" name="salerid" required>
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
                        <label class="form-label" for="updateName">
                            <i class="fa-light fa-tag"></i>
                            Product Name
                        </label>
                        <input
                            type="text"
                            class="form-control item-input"
                            id="updateName"
                            name="name"
                            placeholder="Enter brand name"
                            required />
                        <div class="invalid-feedback"></div>
                    </div>

					<div class="form-group mb-4">
						<label class="form-label" for="sku">
							<i class="fa-light fa-barcode"></i> SKU
						</label>
						<input
							type="text"
							class="form-control item-input @error('sku') is-invalid @enderror"
							id="updateSku"
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
							id="updateDescription"
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
						<input type="number" min="0" class="form-control @error('price') is-invalid @enderror" id="updatePrice" name="price" value="{{ old('price') }}" required />
						@error('price')
							<div class="invalid-feedback"><strong>{{ $message }}</strong></div>
						@enderror
					</div>

					<div class="mb-3">
						<label class="form-label" for="stockquantity">
							<i class="fa-light fa-warehouse"></i> Stock Quantity
						</label>
						<input type="number" min="0" class="form-control @error('stockquantity') is-invalid @enderror" id="updateStockQuantity" name="stockquantity" value="{{ old('stockquantity') }}" required />
						@error('stockquantity')
							<div class="invalid-feedback"><strong>{{ $message }}</strong></div>
						@enderror
					</div>

					<div class="mb-3">
						<label class="form-label" for="discount">
							<i class="fa-light fa-percentage"></i> Discount
						</label>
						<input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="updateDiscount" name="discount" value="{{ old('discount') }}" required />
						@error('discount')
							<div class="invalid-feedback"><strong>{{ $message }}</strong></div>
						@enderror
					</div>

					<div class="mb-3">
						<label class="form-label" for="averragerate">
							<i class="fa-light fa-star"></i> Averragerate
						</label>
						<input type="number" step="0.1" min="0" max="5" class="form-control @error('averragerate') is-invalid @enderror" id="updateAverragerate" name="averragerate" value="{{ old('averragerate') }}" required />
						@error('averragerate')
							<div class="invalid-feedback"><strong>{{ $message }}</strong></div>
						@enderror
					</div>
					
                   
					
					<div class="form-group mb-4">
						<div class="form-check form-switch">
							<input type="hidden" name="isactive" value="0">
							<input class="form-check-input" type="checkbox" id="updateIsActive" name="isactive" value="1" {{ old('isactive', true) ? 'checked' : '' }}>
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
                <button type="submit" form="updateProductForm" class="btn btn-action" id="updateSubmitBtn">
                    <i class="fa-light fa-save"></i>
                    <span class="btn-text">Update Product</span>
                    <span class="btn-loading" style="display: none;">
                        <i class="fa-light fa-spinner fa-spin"></i>
                        Updating...
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>



<script>
document.addEventListener('DOMContentLoaded', function() {
    const updateProductModal = document.getElementById('updateProductModal');
    const updateProductForm = document.getElementById('updateProductForm');
    const updateSubmitBtn = document.getElementById('updateSubmitBtn');
    const btnText = updateSubmitBtn.querySelector('.btn-text');
    const btnLoading = updateSubmitBtn.querySelector('.btn-loading');

    updateProductModal.addEventListener('hidden.bs.modal', function() {
        updateProductForm.reset();

        const invalidInputs = updateProductForm.querySelectorAll('.is-invalid');
        invalidInputs.forEach(input => {
            input.classList.remove('is-invalid');
        });
        const feedbacks = updateProductForm.querySelectorAll('.invalid-feedback');
        feedbacks.forEach(feedback => {
            feedback.style.display = 'none';
            feedback.textContent = '';
        });

        document.getElementById('updateModalMessages').style.display = 'none';
        document.getElementById('updateErrorMessage').style.display = 'none';
        document.getElementById('updateSuccessMessage').style.display = 'none';
        
        updateSubmitBtn.disabled = false;
        btnText.style.display = 'inline';
        btnLoading.style.display = 'none';
    });

    updateProductForm.addEventListener('submit', function(e) {
        // Show loading state
        updateSubmitBtn.disabled = true;
        btnText.style.display = 'none';
        btnLoading.style.display = 'inline';
    });

    updateProductModal.addEventListener('shown.bs.modal', function() {
        // *** ĐÃ SỬA: Focus vào ID đã được cập nhật là updateName ***
        document.getElementById('updateName').focus(); 
    });
});

/**
 * Mở modal chỉnh sửa và điền dữ liệu sản phẩm
 * @param {number} productId ID của sản phẩm
 * @param {Object} productData Dữ liệu chi tiết của sản phẩm (từ Laravel Blade: json_encode($product))
 */
function openUpdateModal(productId, productData) {
    const updateForm = document.getElementById('updateProductForm');
    
    // 1. Cập nhật Action Form
    updateForm.action = `{{ route('admin.product.update', ['id' => '__ID__']) }}`.replace('__ID__', productId);
    
    // 2. Cập nhật Product ID
    document.getElementById('updateProductId').value = productId;
    
    // 3. Điền dữ liệu cho các trường Input/Textarea (Sử dụng ID có tiền tố 'update')
    document.getElementById('updateName').value = productData.name || '';
    document.getElementById('updateSku').value = productData.sku || '';
    document.getElementById('updateDescription').value = productData.description || '';
    document.getElementById('updatePrice').value = productData.price || 0;
    document.getElementById('updateStockQuantity').value = productData.stockquantity || 0;
    document.getElementById('updateDiscount').value = productData.discount || 0;
    document.getElementById('updateAverragerate').value = productData.averragerate || 0;
    
    // 4. Điền dữ liệu cho các Select Box (Sử dụng ID có tiền tố 'update' và key dữ liệu khớp với tên cột)
    if (productData.categoryid) { // Giả định key trong DB là 'categoryid'
        document.getElementById('updateCategoryId').value = productData.categoryid;
    }
    if (productData.brandid) { // Giả định key trong DB là 'brandid'
        document.getElementById('updateBrandId').value = productData.brandid;
    }
    if (productData.salerid) { // Giả định key trong DB là 'salerid'
        document.getElementById('updateSalerId').value = productData.salerid;
    }

    // 5. Cập nhật Checkbox 
    const isactiveCheckbox = document.getElementById('updateIsActive');
    if (isactiveCheckbox) {
         isactiveCheckbox.checked = (productData.isactive == 1);
    }
    
    // 6. Xóa các lỗi cũ (nếu có)
    const invalidInputs = updateForm.querySelectorAll('.is-invalid');
    invalidInputs.forEach(input => {
        input.classList.remove('is-invalid');
    });
    
    // 7. Hiển thị Modal bằng Bootstrap API
    const updateModal = new bootstrap.Modal(document.getElementById('updateProductModal'));
    updateModal.show();
}
</script>