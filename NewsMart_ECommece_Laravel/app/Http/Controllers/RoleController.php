<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    // ================== DANH SÁCH ROLE ==================
    public function getList()
    {
        if (!$this->canManageRoles()) {
            abort(403, 'You do not have permission to access role management.');
        }

        $roles = Role::orderBy('id', 'asc')->get();
        return view('roles.index', compact('roles'));
    }

    // ================== FORM THÊM ROLE ==================
    public function getAdd()
    {
        if (!$this->canManageRoles()) {
            abort(403, 'You do not have permission to add roles.');
        }

        return view('roles.add');
    }

    // ================== XỬ LÝ THÊM ROLE ==================
    public function postAdd(Request $request)
    {
        if (!$this->canManageRoles()) {
        abort(403, 'You do not have permission to add roles.');
        }

        // 1️⃣ Validation
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        // 2️⃣ Lưu vào DB
        $role = new Role();
        $role->name = $request->name;
        $role->description = $request->description;
        $role->save();

        // ✅ Không hiển thị thông báo, chỉ load lại trang hiện tại
        return redirect()->back();
    }

    // ================== CẬP NHẬT ROLE ==================
    public function postUpdate(Request $request, $id)
    {
        if (!$this->canManageRoles()) {
        abort(403, 'You do not have permission to edit roles.');
    }

    $role = Role::findOrFail($id);

    $request->validate([
        'name' => ['required', 'string', 'max:255', 'unique:roles,name,' . $id],
        'description' => ['nullable', 'string', 'max:1000'],
    ]);

    $role->name = $request->name;
    $role->description = $request->description;
    $role->save();


    return redirect()->back();

    }

    // ================== XÓA ROLE ==================
    public function getDelete($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        // Không cần thông báo, chỉ load lại trang
        return redirect()->back();
    }

    // ================== LẤY DỮ LIỆU JSON ==================
    public function getRolesData()
    {
        if (!$this->canManageRoles()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $roles = Role::select(['id', 'name', 'description', 'created_at', 'updated_at'])
            ->orderBy('id', 'asc')
            ->get();

        return response()->json($roles);
    }

    // ================== TÌM KIẾM ROLE ==================
    public function searchRoles(Request $request)
    {
        if (!$this->canManageRoles()) {
            abort(403, 'You do not have permission to search roles.');
        }

        $query = $request->get('q', '');

        $roles = Role::where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->orderBy('id', 'asc')
            ->get();

        return view('roles.index', compact('roles'));
    }

    // ================== KIỂM TRA QUYỀN ==================
    private function canManageRoles()
    {
        if (!auth()->check()) {
            return false;
        }

        try {
            $userRole = auth()->user()->role->name ?? 'User';
            return in_array(strtolower($userRole), ['admin', 'manager']);
        } catch (\Exception $e) {
            return false;
        }
    }
}
