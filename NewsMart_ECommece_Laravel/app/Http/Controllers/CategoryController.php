<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getList()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function getAdd(): View
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to add category.');
        }

        return view('categories.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function postAdd(Request $request): RedirectResponse
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to add brands.');
        }

        // 1. Validation
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:brands'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:brands'],
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

        return redirect()->route('category')->with('success', 'Category created successfully!');
    }

    public function postUpdate(Request $request, $id)
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to edit brands.');
        }

        $categories = Category::findOrFail($id);

        // 1. Validation
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:brands'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:brands'],
            'description' => ['nullable', 'string', 'max:1000'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $extension = $request->file('image')->extension();
            $filename = Str::slug($request->name, '-') . '.' . $extension;
            $path = Storage::putFileAs('categories', $request->file('image'), $filename);
        }

        $categories->name = $request->name;
        $slug = Str::slug($request->name, '-');
        $categories->slug = $request->slug ?: $slug;

        $categories->description = $request->description;

        $categories->parentid = $request->parentid;

        $categories->image = $path ?? null;

        $categories->save();

        return redirect()->route('category')->with('success', 'Category updated successfully!');
    }
    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
    public function getDelete($id)
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to delete brands.');
        }
        $categories = Category::find($id);
        $categoryName = $categories->name;
        $categories->delete();

        if(!empty($categories->image)) Storage::delete($categories->image);


        return redirect()->route('category')->with('success', "Category '{$categoryName}' deleted successfully!");
    }

    private function canManageProducts()
    {
        if (!auth()->check()) {
            return false;
        }

        try {
            $userRole = auth()->user()->role->name ?? 'User';

            return in_array(strtolower($userRole), ['admin', 'manager', 'saler']);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getCategoryData()
    {
        if (!$this->canManageProducts()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $categories = Category::select(['id', 'name', 'slug', 'description', 'logo','parentid','image' ,'created_at'])
            ->orderBy('name', 'asc')
            ->get();

        return response()->json($categories);
    }

    public function searchCategories(Request $request)
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to search brands.');
        }

        $query = $request->get('q', '');

        $categories = Category::where(function ($q) use ($query) {
            $q->where('name', 'LIKE', "%{$query}%")
                ->orWhere('description', 'LIKE', "%{$query}%");
        })
            ->orderBy('name', 'asc')
            ->get();

        return view('categories.index', compact('categories'));
    }
}
