<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getList()
    {
         
		 }

    public function getAdd()
    {
           
    }

    public function postAdd(Request $request): RedirectResponse
    {
         }

    public function postUpdate(Request $request, $id)
    {
        }

    public function getDelete($id)
    {
        if (!$this->canManageProductImages()) {
            abort(403, 'You do not have permission to delete product_images.');
        }
        $product_image = ProductImage::find($id);
        $product_imageName = $product_image->name;
        
        // Xóa file logo trước khi xóa bản ghi
        if(!empty($product_image->logo)) Storage::delete($product_image->logo);
        
        $product_image->delete();

        return redirect()->route('admin.product_image')->with('success', "ProductImage '{$product_imageName}' deleted successfully!");
    }


    public function getProductImagesData()
    {
        if (!$this->canManageProductImages()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $product_images = ProductImage::select(['id', 'categoryid','brandid','salerid',
		'name', 'slug', 'sku', 'address', 'contact', 'description','price','stockquantity','discount','averragerate','favorites','purchases','views','isactive', 'created_at'])
            ->orderBy('name', 'asc')
            ->get();

        return response()->json($product_images);
    }

}
