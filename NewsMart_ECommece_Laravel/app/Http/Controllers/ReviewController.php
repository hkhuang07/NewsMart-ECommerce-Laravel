<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Danh sách review
    public function getList()
    {
        if (!$this->canManageReviews()) {
            abort(403, 'You do not have permission to access review management.');
        }

        $reviews = Review::with(['user', 'product'])->orderBy('id', 'desc')->get();
        return view('reviews.index', compact('reviews'));
    }

    // Form thêm review
    public function getAdd()
    {
        if (!$this->canManageReviews()) {
            abort(403, 'You do not have permission to add reviews.');
        }

        return view('reviews.add');
    }

    // Xử lý thêm review
    public function postAdd(Request $request)
    {
        if (!$this->canManageReviews()) {
            abort(403, 'You do not have permission to add reviews.');
        }

        $request->validate([
            'userid' => 'required|integer|exists:users,id',
            'productid' => 'required|integer|exists:products,id',
            'orderid' => 'nullable|integer|exists:orders,id',
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'nullable|string|max:1000',
            'status' => 'nullable|string|in:Pending,Approved,Rejected',
        ]);

        $review = new Review();
        $review->userid = $request->userid;
        $review->productid = $request->productid;
        $review->orderid = $request->orderid;
        $review->rating = $request->rating;
        $review->content = $request->content;
        $review->status = $request->status ?? 'Pending';
        $review->save();

        return redirect()->route('reviews')->with('success', 'Review created successfully!');
    }

    // Cập nhật review
    public function postUpdate(Request $request, $id)
    {
        if (!$this->canManageReviews()) {
            abort(403, 'You do not have permission to edit reviews.');
        }

        $review = Review::findOrFail($id);

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'nullable|string|max:1000',
            'status' => 'nullable|string|in:Pending,Approved,Rejected',
        ]);

        $review->rating = $request->rating;
        $review->content = $request->content;
        $review->status = $request->status ?? $review->status;
        $review->save();

        return redirect()->route('reviews')->with('success', 'Review updated successfully!');
    }

    // Xóa review
    public function getDelete($id)
    {
        if (!$this->canManageReviews()) {
            abort(403, 'You do not have permission to delete reviews.');
        }

        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()->route('reviews')->with('success', 'Review deleted successfully!');
    }

    // Kiểm tra quyền quản lý
    private function canManageReviews()
    {
        if (!Auth::check()) return false;

        try {
            $role = strtolower(Auth::user()->role->name ?? 'user');
            return in_array($role, ['admin', 'manager', 'saler']);
        } catch (\Exception $e) {
            return false;
        }
    }

    // API lấy dữ liệu review
    public function getReviewsData()
    {
        if (!$this->canManageReviews()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $reviews = Review::select([
            'id',
            'userid',
            'productid',
            'orderid',
            'rating',
            'content',
            'status',
            'created_at'
        ])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($reviews);
    }

    // Tìm kiếm review
    public function searchReviews(Request $request)
    {
        if (!$this->canManageReviews()) {
            abort(403, 'You do not have permission to search reviews.');
        }

        $query = $request->get('q', '');

        $reviews = Review::where('content', 'LIKE', "%{$query}%")
            ->orWhere('status', 'LIKE', "%{$query}%")
            ->orderBy('created_at', 'desc')
            ->get();

        return view('reviews.index', compact('reviews'));
    }
}
