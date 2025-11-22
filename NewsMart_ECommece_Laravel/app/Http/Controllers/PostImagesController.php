<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse; 

class ProductImageController extends PermissionController 
{

    public function getList()
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to access product_image management.');
        }
		$products = Product::all();
        $product_images = ProductImage::all();
        return view('admin.product_images.index', compact('product_images','products'));
    }

    public function getAdd()
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to add product_images.');
        }


        return view('admin.product_images.add');
    }

    public function postAdd(Request $request): RedirectResponse
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to add product_images.');
        }

        // 1. Validation
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:product_images'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:product_images'],
            'address' => ['nullable', 'string', 'max:500'],
            'email' => ['nullable', 'string', 'email', 'max:255'],
            'contact' => ['nullable', 'string', 'max:20'],
            'description' => ['nullable', 'string', 'max:1000'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        $path = null;
        if ($request->hasFile('logo')) {
            $extension = $request->file('logo')->extension();
            $filename = Str::slug($request->name, '-') . '.' . $extension;
            $path = Storage::putFileAs('product_images', $request->file('logo'), $filename);
        }

        $product_image = new ProductImage();
        $product_image->name = $request->name;
        $slug = Str::slug($request->name, '-');
        $product_image->slug = $request->slug ?: $slug;

        $product_image->address = $request->address;
        $product_image->email = $request->email;
        $product_image->contact = $request->contact;
        $product_image->description = $request->description;

        $product_image->logo = $path ?? null;

        $product_image->save();

        return redirect()->route('admin.product_image')->with('success', 'ProductImage created successfully!');
    }

    public function postUpdate(Request $request, $id)
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to edit product_images.');
        }

        $product_image = ProductImage::findOrFail($id);

        // 1. Validation
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:product_images,name,' . $id],
            'slug' => ['nullable', 'string', 'max:255', 'unique:product_images,slug,' . $id],
            'address' => ['nullable', 'string', 'max:500'],
            'email' => ['nullable', 'string', 'email', 'max:255'],
            'contact' => ['nullable', 'string', 'max:20'],
            'description' => ['nullable', 'string', 'max:1000'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        $path = null;
        if ($request->hasFile('logo')) {
            // Xóa file cũ nếu có
            if (!empty($product_image->logo)) Storage::delete($product_image->logo);
            
            // Upload file mới
            $extension = $request->file('logo')->extension();
            $filename = Str::slug($request->name, '-') . '.' . $extension;
            $path = Storage::putFileAs('product_images', $request->file('logo'), $filename);
        }

        $product_image->name = $request->name;
        $slug = Str::slug($request->name, '-');
        $product_image->slug = $request->slug ?: $slug;
        $product_image->address = $request->address;
        $product_image->email = $request->email;
        $product_image->contact = $request->contact;
        $product_image->description = $request->description;
        $product_image->logo = $path ?? $product_image->logo ?? null; 

        $product_image->save();

        return redirect()->route('admin.product_image')->with('success', 'ProductImage updated successfully!');
    }

    public function getDelete($id)
    {
        if (!$this->canManageProducts()) {
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
        if (!$this->canManageProducts()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $product_images = ProductImage::select(['id', 'name', 'slug', 'email', 'address', 'contact', 'description', 'logo', 'created_at'])
            ->orderBy('name', 'asc')
            ->get();

        return response()->json($product_images);
    }

    public function searchProductImages(Request $request)
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to search product_images.');
        }

        $query = $request->get('q', '');

        $product_images = ProductImage::where(function ($q) use ($query) {
            $q->where('name', 'LIKE', "%{$query}%")
                ->orWhere('description', 'LIKE', "%{$query}%")
                ->orWhere('email', 'LIKE', "%{$query}%")
                ->orWhere('address', 'LIKE', "%{$query}%");
        })
            ->orderBy('name', 'asc')
            ->get();

        return view('admin.product_images.index', compact('product_images'));
    }
}