<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class CommentController extends PermissionController
{
    /**
     * Danh sách tất cả comment
     */
    public function getList()
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to access comment management.');
        }

        $comments = Comment::with(['user', 'post'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('comments.index', compact('comments'));
    }

    /**
     * Form thêm comment (nếu có giao diện riêng)
     */
    public function getAdd()
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to add comments.');
        }

        return view('comments.add');
    }

    /**
     * Xử lý thêm comment mới
     */
    public function postAdd(Request $request): RedirectResponse
    {
        // Ai cũng có thể bình luận (nếu muốn giới hạn admin thì bật check permission)
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to add comments.');
        }

        $request->validate([
            'postid' => ['required', 'integer', 'exists:posts,id'],
            'content' => ['required', 'string', 'max:5000'],
            'parentcommentid' => ['nullable', 'integer', 'exists:comments,id'],
        ]);

        $comment = new Comment();
        $comment->postid = $request->postid;
        $comment->userid = auth()->id(); // người đang đăng nhập
        $comment->parentcommentid = $request->parentcommentid ?? null;
        $comment->content = $request->content;
        $comment->created_at = now();
        $comment->updated_at = now();

        $comment->save();

        return redirect()->back()->with('success', 'Comment added successfully!');
    }

    /**
     * Chỉnh sửa comment
     */
    public function getEdit($id)
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to edit comments.');
        }

        $comment = Comment::findOrFail($id);
        return view('comments.edit', compact('comment'));
    }

    /**
     * Cập nhật comment
     */
    public function postUpdate(Request $request, $id)
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to edit comments.');
        }

        $comment = Comment::findOrFail($id);

        $request->validate([
            'content' => ['required', 'string', 'max:5000'],
        ]);

        $comment->content = $request->content;
        $comment->updated_at = now();
        $comment->save();

        return redirect()->route('comments')->with('success', 'Comment updated successfully!');
    }

    /**
     * Xóa comment
     */
    public function getDelete($id)
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to delete comments.');
        }

        $comment = Comment::findOrFail($id);
        $contentPreview = mb_substr($comment->content, 0, 50) . (mb_strlen($comment->content) > 50 ? '...' : '');

        // Xóa tất cả comment con (nếu có)
        Comment::where('parentcommentid', $comment->id)->delete();

        $comment->delete();

        return redirect()->route('comments')->with('success', "Comment '{$contentPreview}' deleted successfully!");
    }

    /**
     * API lấy danh sách comment (ví dụ cho AJAX)
     */
    public function getCommentsData()
    {
        if (!$this->canManageProducts()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $comments = Comment::with(['user', 'post'])
            ->select(['id', 'postid', 'userid', 'parentcommentid', 'content', 'created_at'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($comments);
    }

    /**
     * Tìm kiếm comment
     */
    public function searchComments(Request $request)
    {
        if (!$this->canManageProducts()) {
            abort(403, 'You do not have permission to search comments.');
        }

        $query = $request->get('q', '');

        $comments = Comment::with(['user', 'post'])
            ->where('content', 'LIKE', "%{$query}%")
            ->orderBy('created_at', 'desc')
            ->get();

        return view('comments.index', compact('comments'));
    }
}
