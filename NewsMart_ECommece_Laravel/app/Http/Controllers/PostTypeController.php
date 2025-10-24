<?php

namespace App\Http\Controllers;

use App\Models\PostType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PostTypeController extends Controller
{

    public function getList()
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to access post_type management.');
        }

        //$post_types = PostType::orderBy('id', 'asc')->get();
        $post_types = PostType::all();
        return view('post_types.index', compact('post_types'));
    }

    public function getAdd()
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to add post_types.');
        }

        return view('post_types.add');
    }

    public function postAdd(Request $request)
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to add post_types.');
        }

        // 1. Validation
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:post_types'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:post_types'],
            'contact' => ['nullable', 'string', 'max:20'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $path = null;

        $post_type = new PostType();
        $post_type->name = $request->name;
        $slug = Str::slug($request->name, '-');
        $post_type->slug = $request->slug ?: $slug;


        $post_type->description = $request->description;



        $post_type->save();

        return redirect()->route('post_type')->with('success', 'PostType created successfully!');
    }

    public function postUpdate(Request $request, $id)
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to edit post_types.');
        }

        $post_type = PostType::findOrFail($id);

        // 1. Validation
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:post_types,name,' . $id],
            'slug' => ['nullable', 'string', 'max:255', 'unique:post_types,slug,' . $id],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);


        $post_type->name = $request->name;
        $slug = Str::slug($request->name, '-');
        $post_type->slug = $request->slug ?: $slug;
        $post_type->description = $request->description;

        $post_type->save();

        return redirect()->route('post_type')->with('success', 'PostType updated successfully!');
    }

    public function getDelete($id)
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to delete post_types.');
        }
        $post_type = PostType::find($id);
        $post_typeName = $post_type->name;
        $post_type->delete();

        if(!empty($post_type->logo)) Storage::delete($post_type->logo);


        return redirect()->route('post_type')->with('success', "PostType '{$post_typeName}' deleted successfully!");
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

    public function getPostTypesData()
    {
        if (!$this->canManageProducts()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $post_types = PostType::select(['id', 'name', 'slug', 'description', 'created_at'])
            ->orderBy('name', 'asc')
            ->get();

        return response()->json($post_types);
    }

    public function searchPostTypes(Request $request)
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to search post_types.');
        }

        $query = $request->get('q', '');

        $post_types = PostType::where(function ($q) use ($query) {
            $q->where('name', 'LIKE', "%{$query}%")
                ->orWhere('description', 'LIKE', "%{$query}%")
                ->orWhere('email', 'LIKE', "%{$query}%")
                ->orWhere('address', 'LIKE', "%{$query}%");
        })
            ->orderBy('name', 'asc')
            ->get();

        return view('post_types.index', compact('post_types'));
    }
}
