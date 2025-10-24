<?php

namespace App\Http\Controllers;

use App\Models\PostStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PostStatusController extends Controller
{

    public function getList()
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to access post_status management.');
        }

        //$post_statuses = PostStatus::orderBy('id', 'asc')->get();
        $post_statuses = PostStatus::all();
        return view('post_statuses.index', compact('post_statuses'));
    }

    public function getAdd()
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to add post_statuses.');
        }

        return view('post_statuses.add');
    }

    public function postAdd(Request $request)
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to add post_statuses.');
        }

        // 1. Validation
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:post_statuses'],
            'contact' => ['nullable', 'string', 'max:20'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $path = null;

        $post_status = new PostStatus();
        $post_status->name = $request->name;


        $post_status->description = $request->description;



        $post_status->save();

        return redirect()->route('post_status')->with('success', 'PostStatus created successfully!');
    }

    public function postUpdate(Request $request, $id)
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to edit post_statuses.');
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

        return redirect()->route('post_status')->with('success', 'PostStatus updated successfully!');
    }

    public function getDelete($id)
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to delete post_statuses.');
        }
        $post_status = PostStatus::find($id);
        $post_statusName = $post_status->name;
        $post_status->delete();

        if(!empty($post_status->logo)) Storage::delete($post_status->logo);


        return redirect()->route('post_status')->with('success', "PostStatus '{$post_statusName}' deleted successfully!");
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

    public function getPostStatussData()
    {
        if (!$this->canManageProducts()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $post_statuses = PostStatus::select(['id', 'name', 'description', 'created_at'])
            ->orderBy('name', 'asc')
            ->get();

        return response()->json($post_statuses);
    }

    public function searchPostStatuss(Request $request)
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to search post_statuses.');
        }

        $query = $request->get('q', '');

        $post_statuses = PostStatus::where(function ($q) use ($query) {
            $q->where('name', 'LIKE', "%{$query}%")
                ->orWhere('description', 'LIKE', "%{$query}%")
                ->orWhere('email', 'LIKE', "%{$query}%")
                ->orWhere('address', 'LIKE', "%{$query}%");
        })
            ->orderBy('name', 'asc')
            ->get();

        return view('post_statuses.index', compact('post_statuses'));
    }
}
