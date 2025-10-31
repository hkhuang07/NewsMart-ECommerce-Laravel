<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class ReviewController extends Controller
{
    // ======================
    //  LIST ALL REVIEWS
    // ======================
    public function getList()
    {
        if (!$this->canManageReviews()) {
            abort(403, 'You do not have permission to access review management.');
        }

        $reviews = Review::with(['user', 'product'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('reviews.index', compact('reviews'));
    }

    // ======================
    //  ADD REVIEW (GET FORM)
    // ======================
    public function getAdd()
    {
        if (!$this->canManageReviews()) {
            abort(403, 'You do not have permission to add reviews.');
        }

        return view('reviews.add');
    }

    // ======================
    //  ADD REVIEW (POST)
    // ======================
    public function postAdd(Request $request): RedirectResponse
    {
        if (!$this->canManageReviews()) {
            abort(403, 'You do not have permission to add reviews.');
        }

        $request->validate([
            'userid' => ['required', 'integer', 'exists:users,id'],
            'productid' => ['required', 'integer', 'exists:products,id'],
            'orderid' => ['nullable', 'integer', 'exists:orders,id'],
            'rating' => ['required', 'integer', 'between:1,5'],
            'content' => ['nullable', 'string'],
            'status' => ['required', 'string', 'in:Pending,Approved,Rejected'],
        ]);

        $review = new Review();
        $review->userid = $request->userid;
        $review->productid = $request->productid;
        $review->orderid = $request->orderid;
        $review->rating = $request->rating;
        $review->content = $request->content;
        $review->status = $request->status ?? 'Pending';

        $review->save();

        return redirect()->route('review')->with('success', 'Review created successfully!');
    }

    // ======================
    //  UPDATE REVIEW
    // ======================
    public function postUpdate(Request $request, $id)
    {
        if (!$this->canManageReviews()) {
            abort(403, 'You do not have permission to edit reviews.');
        }

        $review = Review::findOrFail($id);

        $request->validate([
            'userid' => ['required', 'integer', 'exists:users,id'],
            'productid' => ['required', 'integer', 'exists:products,id'],
            'orderid' => ['nullable', 'integer', 'exists:orders,id'],
            'rating' => ['required', 'integer', 'between:1,5'],
            'content' => ['nullable', 'string'],
            'status' => ['required', 'string', 'in:Pending,Approved,Rejected'],
        ]);

        $review->userid = $request->userid;
        $review->productid = $request->productid;
        $review->orderid = $request->orderid;
        $review->rating = $request->rating;
        $review->content = $request->content;
        $review->status = $request->status;

        $review->save();

        return redirect()->route('review')->with('success', 'Review updated successfully!');
    }

    // ======================
    //  DELETE REVIEW
    // ======================
    public function getDelete($id)
    {
        if (!$this->canManageReviews()) {
            abort(403, 'You do not have permission to delete reviews.');
        }

        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()->route('review')->with('success', 'Review deleted successfully!');
    }

    // ======================
    //  CHECK PERMISSION
    // ======================
    private function canManageReviews()
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

    // ======================
    //  JSON DATA API
    // ======================
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

    // ======================
    //  SEARCH REVIEWS
    // ======================
    public function searchReviews(Request $request)
    {
        if (!$this->canManageReviews()) {
            abort(403, 'You do not have permission to search reviews.');
        }

        $query = $request->get('q', '');

        $reviews = Review::where(function ($q) use ($query) {
            $q->where('content', 'LIKE', "%{$query}%")
                ->orWhere('status', 'LIKE', "%{$query}%");
        })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('reviews.index', compact('reviews'));
    }
}
