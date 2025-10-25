<?php

namespace App\Http\Controllers;

use App\Models\OrderStatus;
use Illuminate\Http\Request;

class OrderStatusController extends Controller
{
    /**
     * Hiển thị danh sách trạng thái đơn hàng
     */
    public function getList()
    {
        if (!$this->canManageOrders()) {
            abort(403, 'You do not have permission to access order status management.');
        }

        $statuses = OrderStatus::orderBy('id', 'asc')->get();
        return view('order_statuses.index', compact('statuses'));
    }

    /**
     * Hiển thị form thêm mới
     */
    public function getAdd()
    {
        if (!$this->canManageOrders()) {
            abort(403, 'You do not have permission to add order statuses.');
        }

        return view('order_statuses.add');
    }

    /**
     * Xử lý thêm mới
     */
    public function postAdd(Request $request)
    {
        if (!$this->canManageOrders()) {
            abort(403, 'You do not have permission to add order statuses.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:order_statuses'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $status = new OrderStatus();
        $status->name = $request->name;
        $status->description = $request->description;
        $status->save();

        // ❌ Không thông báo, chỉ reload lại trang hiện tại
        return redirect()->back();
    }

    /**
     * Xử lý cập nhật
     */
    public function postUpdate(Request $request, $id)
    {
        if (!$this->canManageOrders()) {
            abort(403, 'You do not have permission to edit order statuses.');
        }

        $status = OrderStatus::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:order_statuses,name,' . $id],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $status->name = $request->name;
        $status->description = $request->description;
        $status->save();

        // ❌ Không thông báo, chỉ reload lại trang hiện tại
        return redirect()->back();
    }

    /**
     * Xử lý xóa
     */
    public function getDelete($id)
    {
        if (!$this->canManageOrders()) {
            abort(403, 'You do not have permission to delete order statuses.');
        }

        $status = OrderStatus::findOrFail($id);
        $status->delete();

        // ❌ Không thông báo, chỉ reload lại trang hiện tại
        return redirect()->back();
    }

    /**
     * Kiểm tra quyền người dùng
     */
    private function canManageOrders()
    {
        if (!auth()->check()) {
            return false;
        }

        try {
            $userRole = strtolower(auth()->user()->role->name ?? 'user');
            return in_array($userRole, ['admin', 'manager']);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * API lấy dữ liệu JSON
     */
    public function getOrderStatusesData()
    {
        if (!$this->canManageOrders()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $statuses = OrderStatus::select(['id', 'name', 'description', 'created_at', 'updated_at'])
            ->orderBy('id', 'asc')
            ->get();

        return response()->json($statuses);
    }

    /**
     * Tìm kiếm trạng thái đơn hàng
     */
    public function searchOrderStatuses(Request $request)
    {
        if (!$this->canManageOrders()) {
            abort(403, 'You do not have permission to search order statuses.');
        }

        $query = $request->get('q', '');

        $statuses = OrderStatus::where(function ($q) use ($query) {
            $q->where('name', 'LIKE', "%{$query}%")
              ->orWhere('description', 'LIKE', "%{$query}%");
        })
            ->orderBy('name', 'asc')
            ->get();

        return view('order_statuses.index', compact('statuses'));
    }
}
