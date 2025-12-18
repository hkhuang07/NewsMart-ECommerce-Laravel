<?php

namespace App\Http\Controllers;

use App\Models\PostInteraction;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class PostInteractionController extends PermissionController
{
    /**
     * Danh sách tất cả các tương tác bài viết
     */
    public function getList()
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to access post interactions.');
        }

        $interactions = PostInteraction::with(['user', 'post'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('post_interactions.index', compact('interactions'));
    }

    /**
     * Thêm một tương tác mới
     */
    public function postAdd(Request $request): RedirectResponse
    {
        // Người dùng thường cũng có thể tương tác
        $request->validate([
            'postid' => ['required', 'integer', 'exists:posts,id'],
            'interactiontype' => ['required', 'string', 'max:50'],
        ]);

        $userId = auth()->id();

        // Kiểm tra nếu người dùng đã tương tác kiểu này rồi
        $existing = PostInteraction::where('postid', $request->postid)
            ->where('userid', $userId)
            ->where('interactiontype', $request->interactiontype)
            ->first();

        if ($existing) {
            // Nếu đã tồn tại => xóa (toggle)
            $existing->delete();
            return redirect()->back()->with('success', 'Interaction removed successfully!');
        }

        // Thêm mới
        $interaction = new PostInteraction();
        $interaction->postid = $request->postid;
        $interaction->userid = $userId;
        $interaction->interactiontype = $request->interactiontype;
        $interaction->created_at = now();
        $interaction->updated_at = now();
        $interaction->save();

        return redirect()->back()->with('success', 'Interaction added successfully!');
    }

    /**
     * Xóa một tương tác cụ thể
     */
    public function getDelete($id)
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to delete interactions.');
        }

        $interaction = PostInteraction::findOrFail($id);
        $type = $interaction->interactiontype;

        $interaction->delete();

        return redirect()->route('post-interactions')->with('success', "Interaction '{$type}' deleted successfully!");
    }

    /**
     * API trả về danh sách tương tác
     */
    public function getInteractionsData()
    {
        if (!$this->canManageProducts()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $interactions = PostInteraction::with(['user', 'post'])
            ->select(['id', 'postid', 'userid', 'interactiontype', 'created_at'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($interactions);
    }

    /**
     * Tìm kiếm tương tác theo loại hoặc người dùng
     */
    public function searchInteractions(Request $request)
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to search interactions.');
        }

        $query = $request->get('q', '');

        $interactions = PostInteraction::with(['user', 'post'])
            ->where('interactiontype', 'LIKE', "%{$query}%")
            ->orWhereHas('user', function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%");
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('post_interactions.index', compact('interactions'));
    }

    /**
     * Toggle tương tác (API / AJAX)
     * Ví dụ: like/unlike bài viết
     */
    public function toggleInteraction(Request $request)
    {
        $request->validate([
            'postid' => ['required', 'integer', 'exists:posts,id'],
            'interactiontype' => ['required', 'string', 'max:50'],
        ]);

        $userId = auth()->id();

        $existing = PostInteraction::where('postid', $request->postid)
            ->where('userid', $userId)
            ->where('interactiontype', $request->interactiontype)
            ->first();

        if ($existing) {
            $existing->delete();
            return response()->json(['status' => 'removed']);
        }

        PostInteraction::create([
            'postid' => $request->postid,
            'userid' => $userId,
            'interactiontype' => $request->interactiontype,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['status' => 'added']);
    }
}
