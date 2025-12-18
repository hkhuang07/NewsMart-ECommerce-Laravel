<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;


class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getList()
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to access topics management.');
        }

        //$topics = Topic::orderBy('id', 'asc')->get();
       $topics = Topic::all();
        return view('admin.topics.index', compact('topics'));
    }

    public function getAdd()
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to add topics.');
        }

        return view('admin.topics.add');
    }

    public function postAdd(Request $request): RedirectResponse
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to add topics.');
        }

        // 1. Validation
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:topics'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:topics'],
            'description' => ['nullable', 'string', 'max:1000'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        $path = null;
        if ($request->hasFile('logo')) {
            $extension = $request->file('logo')->extension();
            $filename = Str::slug($request->name, '-') . '.' . $extension;
            $path = Storage::putFileAs('topics', $request->file('logo'), $filename);
        }

       $topic = new Topic();
       $topic->name = $request->name;
        $slug = Str::slug($request->name, '-');
       $topic->slug = $request->slug ?: $slug;
       $topic->description = $request->description;

       $topic->logo = $path ?? null;

       $topic->save();

        return redirect()->route('admin.topic')->with('success', 'Topic created successfully!');
    }

    public function postUpdate(Request $request, $id)
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to edit topics.');
        }

       $topic = Topic::findOrFail($id);

        // 1. Validation
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:topics,name,' . $id],
            'slug' => ['nullable', 'string', 'max:255', 'unique:topics,slug,' . $id],
            'description' => ['nullable', 'string', 'max:1000'],
            'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        $path = null;
        if ($request->hasFile('logo')) {
           $topic = Topic::find($id);
            if (!empty($orm->hinhanh)) Storage::delete($topic->logo);
            // Upload file mới
            $extension = $request->file('logo')->extension();
            $filename = Str::slug($request->name, '-') . '.' . $extension;
            $path = Storage::putFileAs('topics', $request->file('logo'), $filename);
        }

       $topic->name = $request->name;
        $slug = Str::slug($request->name, '-');
       $topic->slug = $request->slug ?: $slug;
       $topic->description = $request->description;
       $topic->logo = $path ??$topic->logo ?? null;

       $topic->save();

        return redirect()->route('admin.topic')->with('success', 'Topic updated successfully!');
    }

    public function getDelete($id)
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to delete topics.');
        }
       $topic = Topic::find($id);
        $topicName =$topic->name;
       $topic->delete();

        if(!empty($topic->logo)) Storage::delete($topic->logo);


        return redirect()->route('admin.topic')->with('success', "Topic '{$topicName}' deleted successfully!");
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

    public function getTopicsData()
    {
        if (!$this->canManageProducts()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

       $topics = Topic::select(['id', 'name', 'slug', 'description', 'logo', 'created_at'])
            ->orderBy('name', 'asc')
            ->get();

        return response()->json($topics);
    }

    public function searchTopics(Request $request)
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to search topics.');
        }

        $query = $request->get('q', '');

       $topics = Topic::where(function ($q) use ($query) {
            $q->where('name', 'LIKE', "%{$query}%")
                ->orWhere('description', 'LIKE', "%{$query}%");
        })
            ->orderBy('name', 'asc')
            ->get();

        return view('admin.topics.index', compact('topics'));
    }
}

