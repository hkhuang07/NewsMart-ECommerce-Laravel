<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{

    public function getList()
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to access brand management.');
        }

        //$brands = Brand::orderBy('id', 'asc')->get();
        $brands = Brand::all();
        return view('brands.index', compact('brands'));
    }

    public function getAdd()
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to add brands.');
        }

        return view('brands.add');
    }

    public function postAdd(Request $request)
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to add brands.');
        }

        // 1. Validation
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:brands'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:brands'],
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
            $path = Storage::putFileAs('brands', $request->file('logo'), $filename);
        }

        $brand = new Brand();
        $brand->name = $request->name;
        $slug = Str::slug($request->name, '-');
        $brand->slug = $request->slug ?: $slug;

        $brand->address = $request->address;
        $brand->email = $request->email;
        $brand->contact = $request->contact;
        $brand->description = $request->description;

        $brand->logo = $path ?? null;

        $brand->save();

        return redirect()->route('brand')->with('success', 'Brand created successfully!');
    }

    public function postUpdate(Request $request, $id)
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to edit brands.');
        }

        $brand = Brand::findOrFail($id);

        // 1. Validation
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:brands,name,' . $id],
            'slug' => ['nullable', 'string', 'max:255', 'unique:brands,slug,' . $id],
            'address' => ['nullable', 'string', 'max:500'],
            'email' => ['nullable', 'string', 'email', 'max:255'],
            'contact' => ['nullable', 'string', 'max:20'],
            'description' => ['nullable', 'string', 'max:1000'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        $path = null;
        if ($request->hasFile('logo')) {
            $brand = Brand::find($id);
            if (!empty($orm->hinhanh)) Storage::delete($brand->logo);
            // Upload file mới
            $extension = $request->file('logo')->extension();
            $filename = Str::slug($request->name, '-') . '.' . $extension;
            $path = Storage::putFileAs('brands', $request->file('logo'), $filename);
        }

        $brand->name = $request->name;
        $slug = Str::slug($request->name, '-');
        $brand->slug = $request->slug ?: $slug;
        $brand->address = $request->address;
        $brand->email = $request->email;
        $brand->contact = $request->contact;
        $brand->description = $request->description;
        $brand->logo = $path ?? $brand->logo ?? null;

        $brand->save();

        return redirect()->route('brand')->with('success', 'Brand updated successfully!');
    }

    public function getDelete($id)
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to delete brands.');
        }
        $brand = Brand::find($id);
        $brandName = $brand->name;
        $brand->delete();

        if(!empty($brand->logo)) Storage::delete($brand->logo);


        return redirect()->route('brand')->with('success', "Brand '{$brandName}' deleted successfully!");
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

    public function getBrandsData()
    {
        if (!$this->canManageProducts()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $brands = Brand::select(['id', 'name', 'slug', 'email', 'address', 'contact', 'description', 'logo', 'created_at'])
            ->orderBy('name', 'asc')
            ->get();

        return response()->json($brands);
    }

    public function searchBrands(Request $request)
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to search brands.');
        }

        $query = $request->get('q', '');

        $brands = Brand::where(function ($q) use ($query) {
            $q->where('name', 'LIKE', "%{$query}%")
                ->orWhere('description', 'LIKE', "%{$query}%")
                ->orWhere('email', 'LIKE', "%{$query}%")
                ->orWhere('address', 'LIKE', "%{$query}%");
        })
            ->orderBy('name', 'asc')
            ->get();

        return view('brands.index', compact('brands'));
    }
}
