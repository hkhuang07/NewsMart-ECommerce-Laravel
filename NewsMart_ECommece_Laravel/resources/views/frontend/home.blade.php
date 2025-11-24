@extends('layouts.app')

@section('content')
	
<div class="container mx-auto px-4 py-8">
<!-- Page content -->
<!-- Hero slider -->
		<section class="container pt-3 mb-4">
			<div class="row">
				<div class="col-12">
					<div class="position-relative">
						<span class="position-absolute top-0 start-0 w-100 h-100 rounded-5 d-none-dark rtl-flip" style="background:linear-gradient(90deg, var(--primary-light) 0%, var(--primary-lighter) 100%)"></span>
						<span class="position-absolute top-0 start-0 w-100 h-100 rounded-5 d-none d-block-dark rtl-flip" style="background:linear-gradient(90deg, var(--accent-dark) 0%, var(--primary-super-dark) 100%)"></span>
						<div class="row justify-content-center position-relative z-2">
							<div class="col-xl-5 col-xxl-4 offset-xxl-1 d-flex align-items-center mt-xl-n3">
								<!-- Text content master slider -->
								<div class="swiper px-5 pe-xl-0 ps-xxl-0 me-xl-n5" data-swiper='{"spaceBetween": 64, "loop": true, "speed": 400, "controlSlider": "#sliderImages", "autoplay": {"delay": 5500, "disableOnInteraction": false}, "scrollbar": {"el": ".swiper-scrollbar"}}'>
									<div class="swiper-wrapper">
										<div class="swiper-slide text-center text-xl-start pt-5 py-xl-5">
											<p class="text-body">Feel the True Sound</p>
											<h2 class="display-4 pb-2 pb-xl-4">Headphones ProMax</h2>
											<a class="btn btn-lg btn-dark w-100 rounded-pill" href="#">
												Mua ngay <i class="ci-arrow-up-right fs-lg ms-2 me-n1"></i>
											</a>
										</div>
										
									</div>
								</div>
							</div>
							<div class="col-9 col-sm-7 col-md-6 col-lg-5 col-xl-7">
								<!-- Binded images (controlled slider) -->
								<div class="swiper user-select-none" id="sliderImages" data-swiper='{"allowTouchMove": false, "loop": true, "effect": "fade", "fadeEffect": {"crossFade": true}}'>
									<div class="swiper-wrapper">
										<div class="swiper-slide d-flex justify-content-end">
											<div class="ratio rtl-flip" style="max-width:475px; --cz-aspect-ratio:calc(464 / 495 * 100%)">
												<img src="public/assets/img/slider/01.png" alt="Image" />
											</div>
										</div>
										
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	
	<section class="container mb-2">
    <div id="brands-wrapper" class="position-relative"> 
        
        <button id="scroll-left-btn" type="button" class="scroll-btn scroll-left position-absolute top-50 start-0 translate-middle-y d-none">
            <i class="ci-arrow-left"></i>
        </button>

        <div id="brands-scroll-container" class="overflow-auto" data-simplebar data-simplebar-auto-hide="false">
            <div class="d-flex flex-row flex-nowrap g-0" style="min-width: 960px;"> 
            @foreach($brands as $brand)
                <div class="flex-shrink-0" style="width: 160px;"> 
                    <a class="d-flex justify-content-center py-3 px-2 px-xl-3" href="#">
                        <img src="{{ asset('storage/app/private/' . $brand->logo)}}" class="d-none-dark"  />
                        <img src="{{ asset('storage/app/private/' . $brand->logo)}}" class="d-none d-block-dark"  />
                    </a>
                </div>
            @endforeach 
            </div>
        </div>

        <button id="scroll-right-btn" type="button" class="scroll-btn scroll-right position-absolute top-50 end-0 translate-middle-y">
            <i class="ci-arrow-right"></i>
        </button>

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