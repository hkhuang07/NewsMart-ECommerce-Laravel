<?php

namespace App\Http\Controllers;

use App\Models\OrderStatus; 
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderStatusController extends PermissionController 
{

    public function getList()
    {
        if (!$this->canUpdateOrderStatus()) { 
            abort(403, 'You do not have permission to access order status management.');
        }

        $order_statuses = OrderStatus::orderBy('id', 'asc')->get();
        return view('admin.order_statuses.index', compact('order_statuses'));
    }

    public function getAdd()
    {
        if (!$this->canUpdateOrderStatus()) { 
            abort(403, 'You do not have permission to add order statuses.');
        }

        return view('admin.order_statuses.add');
    }

    public function postAdd(Request $request)
    {
        // SỬA: Dùng canUpdateOrderStatus()
        if (!$this->canUpdateOrderStatus()) {
            abort(403, 'You do not have permission to add order statuses.');
        }

        // 1️⃣ Validation
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:order_statuses'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        // 2️⃣ Lưu vào DB
        $orderStatus = new OrderStatus();
        $orderStatus->name = $request->name;
        $orderStatus->description = $request->description;
        $orderStatus->save();

        return redirect()->back();
    }

    public function postUpdate(Request $request, $id)
    {
        if (!$this->canUpdateOrderStatus()) {
            abort(403, 'You do not have permission to edit order statuses.');
        }

        $orderStatus = OrderStatus::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:order_statuses,name,' . $id],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $orderStatus->name = $request->name;
        $orderStatus->description = $request->description;
        $orderStatus->save();

        return redirect()->back();
    }

    public function getDelete($id)
    {
        // SỬA: Dùng canUpdateOrderStatus()
        if (!$this->canUpdateOrderStatus()) {
            abort(403, 'You do not have permission to delete order statuses.');
        }

        $orderStatus = OrderStatus::findOrFail($id);
        $orderStatus->delete();

        return redirect()->back();
    }

    public function getOrderStatusesData()
    {
        if (!$this->canUpdateOrderStatus()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $order_statuses = OrderStatus::select(['id', 'name', 'description', 'created_at', 'updated_at'])
            ->orderBy('id', 'asc')
            ->get();

        return response()->json($order_statuses);
    }

    public function searchOrderStatuses(Request $request)
    {
        if (!$this->canUpdateOrderStatus()) {
            abort(403, 'You do not have permission to search order statuses.');
        }

        $query = $request->get('q', '');

        $order_statuses = OrderStatus::where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->orderBy('id', 'asc')
            ->get();

        return view('admin.order_statuses.index', compact('order_statuses'));
    }
}