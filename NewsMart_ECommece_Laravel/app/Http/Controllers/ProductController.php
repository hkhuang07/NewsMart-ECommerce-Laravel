<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category; // IMPORT CẦN THIẾT
use App\Models\Brand;    // IMPORT CẦN THIẾT
use App\Models\User;     // IMPORT CẦN THIẾT
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse; 
use App\Models\ProductImage;

class ProductController extends PermissionController 
{

    public function getList()
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to access product management.');
        }
	    $categories = Category::all(); 
        $brands = Brand::all();    
        $users = User::where('roleid', 3)->get();
        
		$products = Product::with('mainImage')->get();
        return view('admin.products.index', compact('products', 'categories', 'brands', 'users'));
    }

    public function getAdd()
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to add products.');
        }

		return view('admin.products.add', compact('categories', 'brands' , 'users','product_imagess'));
       
    }

    public function postAdd(Request $request): RedirectResponse
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to add products.');
        }
		$id = null;
        // 1. Validation
        $request->validate([
			'categoryid' => ['required'],
			'brandid' => ['required'],
			'salerid' => ['required'],
            'name' => ['required', 'string', 'max:255', 'unique:products,name,'. $id],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,name,'. $id],
            'sku' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'max:1000'],
			'price' => ['required', 'numeric'],
			'stockquantity' => ['required', 'integer', 'min:0'], // CSDL: integer
            'discount' => ['nullable', 'numeric', 'min:0', 'max:99.99'], // CSDL: decimal(5,2)
			'averragerate' => ['nullable', 'numeric', 'min:0', 'max:5'], // decimal(2,1), max 5.0
			'favorites' => ['nullable', 'integer', 'min:0'], // integer, default 0
			'purchases' => ['nullable', 'integer', 'min:0'], // integer, default 0
			'views' => ['nullable', 'integer', 'min:0'], // integer, default 0
			'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
			'isactive' => ['nullable', 'boolean'], // boolean, default trues
			]);
		$path = null;
		if ($request->hasFile('logo')) {
			
            $extension = $request->file('logo')->extension();
            $filename = Str::slug($request->name, '-') . '.' . $extension;
            $path = Storage::putFileAs('product_images', $request->file('logo'), $filename);
		}
        $product = new Product();
		$product->categoryid = $request->categoryid;
		$product->brandid = $request->brandid;
		$product->salerid = $request->salerid;
        $product->name = $request->name;
        $slug = Str::slug($request->name, '-');
        $product->slug = $request->slug ?: $slug;

        $product->sku = $request->sku;
        $product->description = $request->description;
        $product->price = $request->price ?? 0;
        $product->stockquantity = $request->stockquantity;
        $product->discount = $request->discount ?? 0.00;
        $product->averragerate = $request->averragerate ?? 0.0;
        $product->favorites = $request->favorites ?? 0;
        $product->purchases = $request->purchases ?? 0;
        $product->views = $request->views ?? 0;
        $product->isactive = $request->isactive;
		
        $product->save();
		// 4. Lưu Hình Ảnh Chính (Logo) vào bảng product_images
    if ($path) {
        ProductImage::create([
            'productid' => $product->id, // Sử dụng ID vừa được tạo
            'url' => $path, // Sử dụng URL công khai
            'ismainimage' => true, // Đặt là ảnh chính (logo)
        ]);
    }
        return redirect()->route('admin.product')->with('success', 'Product created successfully!');
    }

    public function postUpdate(Request $request, $id)
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to edit products.');
        }

        $product = Product::findOrFail($id);

        // 1. Validation
        $request->validate([
			'categoryid' => ['required'],
			'brandid' => ['required'],
			'salerid' => ['required'],
            'name' => ['required', 'string', 'max:255', 'unique:products,name,'. $id],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,name,'. $id],
            'sku' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string', 'max:1000'],
			'price' => ['required', 'numeric'],
			'stockquantity' => ['required', 'integer', 'min:0'], // CSDL: integer
            'discount' => ['nullable', 'numeric', 'min:0', 'max:99.99'], // CSDL: decimal(5,2)
			'averragerate' => ['nullable', 'numeric', 'min:0', 'max:5'], // decimal(2,1), max 5.0
			'favorites' => ['nullable', 'integer', 'min:0'], // integer, default 0
			'purchases' => ['nullable', 'integer', 'min:0'], // integer, default 0
			'views' => ['nullable', 'integer', 'min:0'], // integer, default 0
			'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
			'isactive' => ['nullable', 'boolean'], // boolean, default trues
        ]);

		$path = null;
		
		if ($request->hasFile('logo')) {
			
			$currentMainImage = ProductImage::where('productid', $product->id)
                                    ->where('ismainimage', true)
                                    ->first();

			// 2. Xóa file cũ nếu tìm thấy
			if ($currentMainImage) {
				// Xóa file trên Storage
				Storage::delete($currentMainImage->url);
			}
            $extension = $request->file('logo')->extension();
            $filename = Str::slug($request->name, '-') . '.' . $extension;
            $path = Storage::putFileAs('product_images', $request->file('logo'), $filename);
        }
        $product->name = $request->name;
        $slug = Str::slug($request->name, '-');
        $product->slug = $request->slug ?: $slug;
		
        $product->sku = $request->sku;
        $product->description = $request->description;
        $product->price = $request->price ?? 0;
        $product->stockquantity = $request->stockquantity;
        $product->discount = $request->discount ?? 0.00;
        $product->averragerate = $request->averragerate ?? 0.0;
        $product->favorites = $request->favorites ?? 0;
        $product->purchases = $request->purchases ?? 0;
        $product->views = $request->views ?? 0;
        $product->isactive = $request->isactive;
        $product->save();
		if ($path) {
        ProductImage::create([
            'productid' => $product->id, // Sử dụng ID vừa được tạo
            'url' => $path, // Sử dụng URL công khai
            'ismainimage' => true, // Đặt là ảnh chính (logo)
        ]);
    }
        return redirect()->route('admin.product')->with('success', 'Product updated successfully!');
    }

    public function getDelete($id)
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to delete products.');
        }
        $product = Product::find($id);
        $productName = $product->name;
        
        // Xóa file logo trước khi xóa bản ghi
        if(!empty($product->logo)) Storage::delete($product->logo);
        
        $product->delete();

        return redirect()->route('admin.product')->with('success', "Product '{$productName}' deleted successfully!");
    }


    public function getProductsData()
    {
        if (!$this->canManageProducts()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $products = Product::select(['id', 'categoryid','brandid','salerid',
		'name', 'slug', 'sku', 'address', 'contact', 'description','price','stockquantity','discount','averragerate','favorites','purchases','views','isactive', 'created_at'])
            ->orderBy('name', 'asc')
            ->get();

        return response()->json($products);
    }

    public function searchProducts(Request $request)
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to search products.');
        }

        $query = $request->get('q', '');

        $products = Product::where(function ($q) use ($query) {
            $q->where('name', 'LIKE', "%{$query}%")
                ->orWhere('description', 'LIKE', "%{$query}%")
                ->orWhere('email', 'LIKE', "%{$query}%")
                ->orWhere('address', 'LIKE', "%{$query}%");
        })
            ->orderBy('name', 'asc')
            ->get();

        return view('admin.products.index', compact('products'));
    }
}