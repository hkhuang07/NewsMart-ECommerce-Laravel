<?php

namespace App\Http\Controllers;

use App\Models\PostStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PostStatusController extends PermissionController
{

    public function getList()
    {
        if (!$this->canManagePosts()) {
            abort(403, 'You do not have permission to access post status management.');
        }

        $post_statuses = PostStatus::all();
        return view('admin.post_statuses.index', compact('post_statuses'));
    }

    public function getAdd()
    {
        if (!$this->canManagePosts()) {
            abort(403, 'You do not have permission to add post statuses.');
        }

        return view('admin.post_statuses.add');
    }

    public function postAdd(Request $request)
    {
        if (!$this->canManagePosts()) {
            abort(403, 'You do not have permission to add post statuses.');
        }

        // 1. Validation
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:post_statuses'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $post_status = new PostStatus();
        $post_status->name = $request->name;
        $post_status->description = $request->description;

        $post_status->save();

        return redirect()->route('admin.post_status')->with('success', 'PostStatus created successfully!');
    }

    public function postUpdate(Request $request, $id)
    {
        if (!$this->canManagePosts()) {
            abort(403, 'You do not have permission to edit post statuses.');
        }

        $post_status = PostStatus::findOrFail($id);

        // 1. Validation
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:post_statuses,name,' . $id],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $post_status->name = $request->name;
        $post_status->description = $request->description;

        $post_status->save();

        return redirect()->route('admin.post_status')->with('success', 'PostStatus updated successfully!');
    }

    public function getDelete($id)
    {
        if (!$this->canManagePosts()) {
            abort(403, 'You do not have permission to delete post statuses.');
        }
        $post_status = PostStatus::find($id);
        $post_statusName = $post_status->name;
        $post_status->delete();

        return redirect()->route('admin.post_status')->with('success', "PostStatus '{$post_statusName}' deleted successfully!");
    }


    public function getPostStatussData()
    {
        if (!$this->canManagePosts()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $post_statuses = PostStatus::select(['id', 'name', 'description', 'created_at'])
            ->orderBy('name', 'asc')
            ->get();

        return response()->json($post_statuses);
    }

    public function searchPostStatuss(Request $request)
    {
        if (!$this->canManagePosts()) {
            abort(403, 'You do not have permission to search post statuses.');
        }

        $query = $request->get('q', '');

        $post_statuses = PostStatus::where(function ($q) use ($query) {
            $q->where('name', 'LIKE', "%{$query}%")
                ->orWhere('description', 'LIKE', "%{$query}%");
        })
            ->orderBy('name', 'asc')
            ->get();

        return view('admin.post_statuses.index', compact('post_statuses'));
    }
}