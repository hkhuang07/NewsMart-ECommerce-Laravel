<?php

namespace App\Http\Controllers;

use App\Models\OrderStatus; // Đổi từ Role sang OrderStatus
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderStatusController extends Controller
{
    // ================== DANH SÁCH TRẠNG THÁI ĐƠN HÀNG ==================
    public function getList()
    {
        if (!$this->canManageOrderStatuses()) {
            abort(403, 'You do not have permission to access order status management.');
        }

        $order_statuses = OrderStatus::orderBy('id', 'asc')->get();
        return view('order_statuses.index', compact('order_statuses'));
    }

    // ================== FORM THÊM TRẠNG THÁI ĐƠN HÀNG ==================
    public function getAdd()
    {
        if (!$this->canManageOrderStatuses()) {
            abort(403, 'You do not have permission to add order statuses.');
        }

        return view('order_statuses.add');
    }

    // ================== XỬ LÝ THÊM TRẠNG THÁI ĐƠN HÀNG ==================
    public function postAdd(Request $request)
    {
        if (!$this->canManageOrderStatuses()) {
            abort(403, 'You do not have permission to add order statuses.');
        }

        // 1️⃣ Validation
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:order_statuses'], // Đổi bảng 'roles' -> 'order_statuses'
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        // 2️⃣ Lưu vào DB
        $orderStatus = new OrderStatus();
        $orderStatus->name = $request->name;
        $orderStatus->description = $request->description;
        $orderStatus->save();

        // ✅ Không hiển thị thông báo, chỉ load lại trang hiện tại
        return redirect()->back();
    }

    // ================== CẬP NHẬT TRẠNG THÁI ĐƠN HÀNG ==================
    public function postUpdate(Request $request, $id)
    {
        if (!$this->canManageOrderStatuses()) {
            abort(403, 'You do not have permission to edit order statuses.');
        }

        $orderStatus = OrderStatus::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:order_statuses,name,' . $id], // Đổi bảng 'roles' -> 'order_statuses'
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $orderStatus->name = $request->name;
        $orderStatus->description = $request->description;
        $orderStatus->save();

        return redirect()->back();
    }

    // ================== XÓA TRẠNG THÁI ĐƠN HÀNG ==================
    public function getDelete($id)
    {
        // Thêm kiểm tra quyền cho nhất quán (vì RoleController cũng kiểm tra ở các hàm khác)
        if (!$this->canManageOrderStatuses()) {
            abort(403, 'You do not have permission to delete order statuses.');
        }

        $orderStatus = OrderStatus::findOrFail($id);
        $orderStatus->delete();

        // Không cần thông báo, chỉ load lại trang
        return redirect()->back();
    }

    // ================== LẤY DỮ LIỆU JSON ==================
    public function getOrderStatusesData()
    {
        if (!$this->canManageOrderStatuses()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $order_statuses = OrderStatus::select(['id', 'name', 'description', 'created_at', 'updated_at'])
            ->orderBy('id', 'asc')
            ->get();

        return response()->json($order_statuses);
    }

    // ================== TÌM KIẾM TRẠNG THÁI ĐƠN HÀNG ==================
    public function searchOrderStatuses(Request $request)
    {
        if (!$this->canManageOrderStatuses()) {
            abort(403, 'You do not have permission to search order statuses.');
        }

        $query = $request->get('q', '');

        $order_statuses = OrderStatus::where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->orderBy('id', 'asc')
            ->get();

        return view('order_statuses.index', compact('order_statuses'));
    }

    // ================== KIỂM TRA QUYỀN ==================
    private function canManageOrderStatuses()
    {
        if (!auth()->check()) {
            return false;
        }

        try {
            // Giả định rằng quyền quản lý OrderStatus giống như Role (admin, manager)
            $userRole = auth()->user()->role->name ?? 'User';
            return in_array(strtolower($userRole), ['admin', 'manager']);
        } catch (\Exception $e) {
            return false;
        }
    }
}
