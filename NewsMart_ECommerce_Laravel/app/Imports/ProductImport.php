<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\ProductImage;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class ProductImport implements ToModel,   WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
	
    public function model(array $row)
    {
		$imageUrlString = $row['url'] ?? null;
        $product = Product::create([
            'categoryid' => $row['categoryid'],
            'brandid' => $row['brandid'] , 
			'salerid' => $row['salerid'], 
            'name' => $row['name'],
            'slug' => $row['slug'],
			'sku' => $row['slug'],
			'description' => $row['slug'],
            'price' => $row['price'],
            'stockquantity' => $row['stockquantity'],
            // Thêm các trường khác của Product tại đây
        ]);
		
		
		$trimmedUrl = trim($imageUrlString);
        if (!empty($trimmedUrl) && $product) {
            
            // TẠO MỘT BẢN GHI ProductImage DUY NHẤT
            ProductImage::create([
                'productid' => $product->id, // Gán ID sản phẩm vừa tạo
                'url' => $trimmedUrl,         // Lưu chuỗi URL nguyên vẹn
                'ismainimage' => true,            // Giả định đây là ảnh chính
            ]);
        }
		return null;
    }
}
