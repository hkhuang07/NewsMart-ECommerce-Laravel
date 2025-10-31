<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoleController extends PermissionController
{
    public function getList()
    {
        if (!$this->canManageRoles()) {
            abort(403, 'You do not have permission to access role management.');
        }

        $roles = Role::orderBy('id', 'asc')->get();
        return view('roles.index', compact('roles'));
    }

    public function getAdd()
    {
        if (!$this->canManageRoles()) {
            abort(403, 'You do not have permission to add roles.');
        }

        return view('roles.add');
    }

    public function postAdd(Request $request)
    {
        if (!$this->canManageRoles()) {
            abort(403, 'You do not have permission to add roles.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $role = new Role();
        $role->name = $request->name;
        $role->description = $request->description;
        $role->save();

        return redirect()->back();
    }

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

    public function getDelete($id)
    {
        if (!$this->canManageRoles()) {
             abort(403, 'You do not have permission to delete roles.');
        }
        
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->back();
    }

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

}