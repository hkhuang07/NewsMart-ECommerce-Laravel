@extends('layouts.app')

@section('content')
<div class="item-header">
        <div class="container mx-auto px-4">
            <div class="header-content">
                <div class="header-left">
                    <h1 class="page-title">
                        <i class=""></i>
                        Newest Product
                    </h1>
                    <p clindass="page-subtitle">
                        Choose your best choice
                    </p>
                </div>
                
            </div>
        </div>
    </div>
<div class="container mx-auto px-4 py-8">
    
<!-- Brands -->
		<section class="container mb-2">
			<div class="overflow-auto" data-simplebar data-simplebar-auto-hide="false">
				<div class="row row-cols-6 g-0" style="min-width:960px">
				@foreach($brands as $brands)
				
					<div class="col">
						<a class="d-flex justify-content-center py-3 px-2 px-xl-3" href="#">
							<img src="{{ asset('storage/app/private/' . $brands->logo)}}" class="d-none-dark"  />
							<img src="{{ asset('storage/app/private/' . $brands->logo)}}" class="d-none d-block-dark"  />
						</a>
					</div>
				@endforeach	
				</div>
			</div>
		</section>
	
	
    {{-- Vòng lặp NGOÀI: Lặp qua TỪNG DANH MỤC --}}
    @forelse($categories as $category)
    
			
		   <div class="row mb-4">
				<div class="col-12">
					{{-- Hiển thị tên Danh mục --}}
					 <div class="category-header-line d-flex justify-content-between align-items-center pb-2">
					<h2 class="page-title">
						<i class=""></i>
		
						{{ $category->name ?? 'Không tên' }}
					</h2>
					<a class="nav-link animate-underline px-0 py-2" href="">
							<span class="animate-target">Xem tất cả ></span> <i class="ci-chevron-right fs-base ms-1"></i>
						</a>
					 </div>
				</div>
			</div>

        <div class="items-grid" id="productsGrid_{{ $category->id }}">
            
            {{-- Vòng lặp TRONG: Lặp qua SẢN PHẨM của DANH MỤC hiện tại --}}
            @forelse($category->products as $product)
            <div class="item-card" data-product-id="{{ $product->id }}">
                <div class="item-image-container">
                     @if($product->mainImage)
					<img src="{{ asset('storage/app/private/'.$product->mainImage->url) }}"
						 alt="{{ $product->name }}"
						 class="item-image"
						 loading="lazy">
					@else
						{{-- Nếu không có ảnh chính --}}
						<div class="item-image-placeholder">
							<i class="fas fa-box"></i> 
						</div>
					@endif

                    

                    <div class="status-badge">
                        <i class="fas fa-check-circle"></i> Active
                    </div>
					<div class="action-overlay">
                        <div class="action-buttons">
                            <button type="button"
                                class="action-btn edit-btn"
                                title="Edit Product"
                                >
                                <i class="fas fa-heart"></i>
                            </button>
							
                            <a href="{{route('frontend.cart.add',['slug' => $product->slug])}}" 
                                class="action-btn delete-btn"
                                title="Delete Product"
								>
                                <i class="fas fa-shopping-cart"></i>
                           </a>
						 </div>
                 </div>
                </div>
				
                <div class="item-content">
                    <h3 class="item-title" title="{{ $product->name }}">
                        {{ $product->name }}
                    </h3>

                    <div class="item-info">
                        @if($product->price)
                        <div class="info-item">
                            <i class="fas fa-money-bill-wave"></i>
                            <span class="info-label">Price:</span>
                            <span class="info-value" title="{{ number_format($product->price, 0, ',','.') }}">
                                ${{ Str::limit($product->price, 30) }}
                            </span>
                        </div>
                        @endif
                        @if($product->description)
                        <div class="item-description">
                            {{ Str::limit($product->description, 100) }}
                        </div>
                        @endif
                    </div>

                    <div class="item-footer">
                        {{-- Phần views, favorites, purchases --}}
                        @if($product->views >= 0)<div><i class="fas fa-eye"></i><span class="info-label">views: </span><span class="info-value">{{ Str::limit($product->views, 30) }}</span></div>@endif
                        @if($product->favorites >=0)<div><i class="fas fa-heart"></i><span class="info-label">favorites: </span><span class="info-value">{{ Str::limit($product->favorites, 30) }}</span></div>@endif
                        @if($product->purchases >= 0)<div><i class="fas fa-box-open"></i><span class="info-label">purchases: </span><span class="info-value">{{ Str::limit($product->purchases, 30) }}</span></div>@endif
                        
                       
                    </div>

                   
                </div>
            </div>
            @empty
            {{-- Trường hợp danh mục KHÔNG có sản phẩm --}}
            <div class="col-12 empty-state-category">
                <p class="empty-text">Danh mục **{{ $category->name ?? 'Này' }}** chưa có sản phẩm nào được thêm.</p>
            </div>
            @endforelse
        </div>
        
        <hr class="my-5">
        
    @empty
    {{-- Trường hợp KHÔNG có danh mục nào được tải --}}
    <div class="empty-state">
        <div class="empty-content">
            <i class="fas fa-tags empty-icon"></i>
            <h3 class="empty-title">Chưa có danh mục nào được thiết lập.</h3>
            <p class="empty-text">Vui lòng tạo danh mục để hiển thị sản phẩm.</p>
        </div>
    </div>
    @endforelse
    
</div>
@endsection