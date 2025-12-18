<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductExport implements FromCollection, WithHeadings, WithCustomStartCell, WithMapping
{
    /**
     * Định nghĩa các tiêu đề cột (Hàng đầu tiên trong Excel).
     * @return array
     */
	public function headings(): array
	{
	    return [
            'categoryid',
            'brandid',
            'salerid',
            'name',
            'slug',
            'sku', // Thêm cột SKU
            'description',
            'price',
            'stockquantity',
            'image_url', // Cột mới cho URL ảnh (từ ProductImage Model)
	    ];
	}

    /**
     * Ánh xạ dữ liệu từ Product Model sang hàng trong Excel.
     * @param Product $row
     * @return array
     */
	public function map($row): array
	{
        // Khởi tạo giá trị mặc định cho URL ảnh
        $imageUrl = 'N/A';
        
        // KIỂM TRA MỐI QUAN HỆ 'images' (TỪ ProductImage)
        // $row->images là Collection của ProductImage Models đã được tải trước.
        if ($row->images->isNotEmpty()) {
            // Lấy giá trị của cột 'url' từ bản ghi ProductImage đầu tiên.
            // (Giả định ProductImage có cột tên là 'url'.)
            $imageUrl = $row->images->first()->url; 
        }

	    return [
            $row->categoryid,
            $row->brandid,
            $row->salerid,
            $row->name,
            $row->slug,
            $row->sku, // Thêm giá trị SKU
            $row->description,
            $row->price,
            $row->stockquantity,
            $imageUrl, // Thêm URL ảnh (đã được lấy từ ProductImage)
	    ];
	}

    /**
     * Bắt đầu ghi dữ liệu từ ô A1
     * @return string
     */
	public function startCell(): string
	{
	    return 'A1';
	}

	/**
	 * Lấy tập hợp dữ liệu sản phẩm.
     * @return \Illuminate\Support\Collection
	 */
	public function collection()
	{
        // QUAN TRỌNG: EAGER LOAD (tải trước) mối quan hệ 'images' để lấy dữ liệu từ ProductImage.
        // Nếu không có with('images'), $row->images sẽ gây ra N+1 query hoặc lỗi.
	    return Product::with('images')->get();
	}
}