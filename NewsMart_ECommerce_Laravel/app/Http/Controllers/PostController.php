<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;

class PostController extends PermissionController
{
    public function getList()
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to access post management.');
        }

        $posts = Post::orderBy('created_at', 'desc')->get();
        return view('admin.posts.index', compact('posts'));
    }

    public function getAdd()
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to add posts.');
        }

        return view('admin.posts.add');
    }

    public function postAdd(Request $request): RedirectResponse
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to add posts.');
        }

        // Validate
        $request->validate([
            'title' => ['required', 'string', 'max:255', 'unique:posts'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:posts'],
            'content' => ['required', 'string'],
            'status' => ['nullable', 'string', 'max:50'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'productid' => ['nullable', 'integer'],
            'topicid' => ['nullable', 'integer'],
            'posttypeid' => ['nullable', 'integer'],
        ]);

        // Handle image upload
        $path = null;
        if ($request->hasFile('image')) {
            $extension = $request->file('image')->extension();
            $filename = Str::slug($request->title, '-') . '.' . $extension;
            $path = Storage::putFileAs('posts', $request->file('image'), $filename);
        }

        // Create post
        $post = new Post();
        $post->authorid = auth()->id();
        $post->productid = $request->productid;
        $post->posttypeid = $request->posttypeid;
        $post->topicid = $request->topicid;
        $post->title = $request->title;
        $post->slug = $request->slug ?: Str::slug($request->title, '-');
        $post->content = $request->content;
        $post->status = $request->status ?: 'Pending';
        $post->image = $path;
        $post->views = 0;
        $post->created_at = now();
        $post->updated_at = now();

        $post->save();

        return redirect()->route('admin.posts')->with('success', 'Post created successfully!');
    }

    public function getEdit($id)
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to edit posts.');
        }

        $post = Post::findOrFail($id);
        return view('admin.posts.edit', compact('post'));
    }

    public function postUpdate(Request $request, $id)
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to edit posts.');
        }

        $post = Post::findOrFail($id);

        // Validate
        $request->validate([
            'title' => ['required', 'string', 'max:255', 'unique:posts,title,' . $id],
            'slug' => ['nullable', 'string', 'max:255', 'unique:posts,slug,' . $id],
            'content' => ['required', 'string'],
            'status' => ['nullable', 'string', 'max:50'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'productid' => ['nullable', 'integer'],
            'topicid' => ['nullable', 'integer'],
            'posttypeid' => ['nullable', 'integer'],
        ]);

        // Handle image upload
        $path = $post->image;
        if ($request->hasFile('image')) {
            if (!empty($post->image)) Storage::delete($post->image);
            $extension = $request->file('image')->extension();
            $filename = Str::slug($request->title, '-') . '.' . $extension;
            $path = Storage::putFileAs('posts', $request->file('image'), $filename);
        }

        // Update fields
        $post->productid = $request->productid;
        $post->posttypeid = $request->posttypeid;
        $post->topicid = $request->topicid;
        $post->title = $request->title;
        $post->slug = $request->slug ?: Str::slug($requests->title, '-');
        $post->content = $request->content;
        $post->status = $request->status ?: $post->status;
        $post->image = $path;
        $post->updated_at = now();

        $post->save();

        return redirect()->route('admin.posts')->with('success', 'Post updated successfully!');
    }

    public function getDelete($id)
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to delete posts.');
        }

        $post = Post::findOrFail($id);
        $title = $post->title;

        if (!empty($post->image)) Storage::delete($post->image);

        $post->delete();

        return redirect()->route('admin.posts')->with('success', "Post '{$title}' deleted successfully!");
    }

    public function getPostsData()
    {
        if (!$this->canManageProducts()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $posts = Post::select([
            'id',
            'authorid',
            'productid',
            'posttypeid',
            'topicid',
            'title',
            'slug',
            'status',
            'image',
            'views',
            'created_at'
        ])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($posts);
    }

    public function searchPosts(Request $request)
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to search posts.');
        }

        $query = $request->get('q', '');

        $posts = Post::where(function ($q) use ($query) {
            $q->where('title', 'LIKE', "%{$query}%")
                ->orWhere('content', 'LIKE', "%{$query}%")
                ->orWhere('slug', 'LIKE', "%{$query}%");
        })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.posts.index', compact('posts'));
    }
}
