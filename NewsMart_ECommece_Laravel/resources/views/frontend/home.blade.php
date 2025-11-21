@extends('layouts.app')

@section('content')

<div class="container mx-auto px-4 py-8">
    
    {{-- Vòng lặp NGOÀI: Lặp qua TỪNG DANH MỤC --}}
    @forelse($categories as $category)
    
        <div class="row mb-5">
            <div class="col-12">
                {{-- Hiển thị tên Danh mục --}}
                   <h2 class="page-title">
					<i class="fas fa-tags"></i>
                    {{-- Ví dụ: Smartphone --}}
                     {{ $category->name ?? 'Không tên' }}
                </h2>
            </div>
        </div>

        <div class="items-grid" id="productsGrid_{{ $category->id }}">
            
            {{-- Vòng lặp TRONG: Lặp qua SẢN PHẨM của DANH MỤC hiện tại --}}
            @forelse($category->products as $product)
            <div class="item-card" data-product-id="{{ $product->id }}">
                <div class="item-image-container">
                    @if(isset($product->logo) && $product->logo)
                    <img src="{{ asset('storage/app/private/'.$product->logo) }}"
                        alt="{{ $product->name }}"
                        class="item-image"
                        loading="lazy">
                    @else
                    <div class="item-image-placeholder">
                        <i class="fas fa-building"></i>
                    </div>
                    @endif

                    <div class="status-badge">
                        <i class="fas fa-check-circle"></i> Active
                    </div>
                    {{-- Đã loại bỏ Action Overlay (Edit/Delete) --}}
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
                            <span class="info-value" title="{{ $product->price }}">
                                {{ Str::limit($product->price, 30) }}
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
                        @if($product->views)<div><i class="fas fa-eye"></i><span class="info-label">views:</span><span class="info-value">{{ Str::limit($product->views, 30) }}</span></div>@endif
                        @if($product->favorites)<div><i class="fas fa-heart"></i><span class="info-label">favorites:</span><span class="info-value">{{ Str::limit($product->favorites, 30) }}</span></div>@endif
                        @if($product->purchases)<div><i class="fas fa-box-open"></i><span class="info-label">purchases:</span><span class="info-value">{{ Str::limit($product->purchases, 30) }}</span></div>@endif
                        
                        <div class="created-date">
                            <i class="fas fa-calendar-alt"></i>
                            Created {{ $product->created_at->diffForHumans() }}
                        </div>
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