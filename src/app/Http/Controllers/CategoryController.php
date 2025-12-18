<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View; 

class CategoryController extends PermissionController
{
    
    public function getList()
    {
        if (!$this->canManageCategories()) {
            abort(403, 'You do not have permission to access category management.');
        }
        
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function getAdd(): View
    {
        if (!$this->canManageCategories()) {
            abort(403, 'You do not have permission to add category.');
        }

        return view('admin.categories.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function postAdd(Request $request): RedirectResponse
    {
        if (!$this->canManageCategories()) {
            abort(403, 'You do not have permission to add categories.');
        }

        // 1. Validation
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories'], 
            'slug' => ['nullable', 'string', 'max:255', 'unique:categories'], 
            'description' => ['nullable', 'string', 'max:1000'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $extension = $request->file('image')->extension();
            $filename = Str::slug($request->name, '-') . '.' . $extension;
            $path = Storage::putFileAs('categories', $request->file('image'), $filename);
        }

        $categories = new Category();
        $categories->name = $request->name;
        $slug = Str::slug($request->name, '-');
        $categories->slug = $request->slug ?: $slug;

        $categories->description = $request->description;
        $categories->parentid = $request->parentid;
        $categories->image = $path ?? null;

        $categories->save();

        return redirect()->route('admin.category')->with('success', 'Category created successfully!');
    }

    public function postUpdate(Request $request, $id)
    {
        // THAY ĐỔI: Sử dụng canManageCategories()
        if (!$this->canManageCategories()) {
            abort(403, 'You do not have permission to edit categories.');
        }

        $categories = Category::findOrFail($id);

        // 1. Validation
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name,' . $id], 
            'slug' => ['nullable', 'string', 'max:255', 'unique:categories,slug,' . $id],
            'description' => ['nullable', 'string', 'max:1000'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        $path = null;
        if ($request->hasFile('image')) {
             // Xóa file cũ
            if (!empty($categories->image)) Storage::delete($categories->image);
             
            $extension = $request->file('image')->extension();
            $filename = Str::slug($request->name, '-') . '.' . $extension;
            $path = Storage::putFileAs('categories', $request->file('image'), $filename);
        }

        $categories->name = $request->name;
        $slug = Str::slug($request->name, '-');
        $categories->slug = $request->slug ?: $slug;

        $categories->description = $request->description;
        $categories->parentid = $request->parentid;
        $categories->image = $path ?? $categories->image ?? null;

        $categories->save();

        return redirect()->route('admin.category')->with('success', 'Category updated successfully!');
    }
    
    
    public function getDelete($id)
    {
        if (!$this->canManageCategories()) {
            abort(403, 'You do not have permission to delete categories.');
        }
        $categories = Category::find($id);
        $categoryName = $categories->name;
        
        // Xóa file ảnh trước khi xóa bản ghi
        if(!empty($categories->image)) Storage::delete($categories->image);

        $categories->delete();

        return redirect()->route('admin.category')->with('success', "Category '{$categoryName}' deleted successfully!");
    }

    public function getCategoryData()
    {
        if (!$this->canManageCategories()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $categories = Category::select(['id', 'name', 'slug', 'description', 'parentid','image' ,'created_at'])
            ->orderBy('name', 'asc')
            ->get();

        return response()->json($categories);
    }

    public function searchCategories(Request $request)
    {
        if (!$this->canManageCategories()) {
            abort(403, 'You do not have permission to search categories.');
        }

        $query = $request->get('q', '');

        $categories = Category::where(function ($q) use ($query) {
            $q->where('name', 'LIKE', "%{$query}%")
                ->orWhere('description', 'LIKE', "%{$query}%");
        })
            ->orderBy('name', 'asc')
            ->get();

        return view('admin.categories.index', compact('categories'));
    }
}