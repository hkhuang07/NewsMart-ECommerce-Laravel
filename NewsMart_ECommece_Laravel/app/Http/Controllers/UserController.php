<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\PermissionController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Auth; 
use Illuminate\Validation\Rule;      


class UserController extends PermissionController
{
    public function getList(): View
    {
        if (!$this->canManageUsers()) {
            abort(403, 'You do not have permission to access user management.');
        }

        $roles = Role::orderBy('id', 'asc')->get();
        $users = User::with('role')->orderBy('id', 'asc')->get();
        return view('users.index', compact('users', 'roles'));
    }

    public function getAdd(): View
    {
        if (!$this->canManageUsers()) {
            abort(403, 'You do not have permission to add users.');
        }

        $roles = Role::orderBy('id', 'asc')->get();
        return view('users.add', compact('roles'));
    }

    public function postAdd(Request $request): RedirectResponse
    {
        if (!$this->canManageUsers()) {
            abort(403, 'You do not have permission to add users.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'roleid' => ['required', 'exists:roles,id'],
            'address' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'isactive' => ['nullable', 'boolean'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'background' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'jobs' => ['nullable', 'string', 'max:255'],
            'school' => ['nullable', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
        ]);

        // Xử lý Upload files
        $path_avt = null;
        if ($request->hasFile('avatar')) {
            $extension = $request->file('avatar')->extension();
            $filename = Str::slug($request->username, '-') . '-avt.' . $extension;
            $path_avt = Storage::disk('public')->putFileAs('avatar', $request->file('avatar'), $filename);
        }

        $path_bg = null;
        if ($request->hasFile('background')) {
            $extension = $request->file('background')->extension();
            $filename = Str::slug($request->username, '-') . '-bg.' . $extension;
            $path_bg = Storage::disk('public')->putFileAs('background', $request->file('background'), $filename);
        }

        $user = new User();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->roleid = $request->roleid;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->isactive = $request->has('isactive');
        $user->avatar = $path_avt;
        $user->background = $path_bg;
        $user->jobs = $request->jobs;
        $user->school = $request->school;
        $user->company = $request->company;

        $user->save();

        return redirect()->route('user')->with('success', 'User created successfully!');
    }

    public function getUpdate($id): View
    {
        if (!$this->canManageUsers()) {
            abort(403, 'You do not have permission to view this user.');
        }

        $user = User::findOrFail($id);
        $roles = Role::orderBy('id', 'asc')->get();

        return view('users.update', compact('user', 'roles'));
    }

    public function postUpdate(Request $request, $id): RedirectResponse
    {
        if (!$this->canManageUsers()) {
            abort(403, 'You do not have permission to update this user.');
        }

        $user = User::findOrFail($id);

        // Validation
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username,' . $id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'roleid' => ['required', 'exists:roles,id'],
            'address' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'isactive' => ['nullable', 'boolean'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'background' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'jobs' => ['nullable', 'string', 'max:255'],
            'school' => ['nullable', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
        ]);

        // Xử lý file upload
        $path_avt = $user->avatar;
        if ($request->hasFile('avatar')) {
            if (!empty($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $extension = $request->file('avatar')->extension();
            $filename = Str::slug($request->username, '-') . '-avt.' . $extension;
            $path_avt = Storage::disk('public')->putFileAs('avatar', $request->file('avatar'), $filename);
        }

        $path_bg = $user->background;
        if ($request->hasFile('background')) {
            if (!empty($user->background)) {
                Storage::disk('public')->delete($user->background);
            }
            $extension = $request->file('background')->extension();
            $filename = Str::slug($request->username, '-') . '-bg.' . $extension;
            $path_bg = Storage::disk('public')->putFileAs('background', $request->file('background'), $filename);
        }

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->roleid = $request->roleid;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->isactive = $request->has('isactive');
        $user->avatar = $path_avt;
        $user->background = $path_bg;
        $user->jobs = $request->jobs;
        $user->school = $request->school;
        $user->company = $request->company;

        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('user')->with('success', 'User updated successfully!');
    }

    public function getDelete($id)
    {
        if (!$this->canManageUsers()) {
            abort(403, 'You do not have permission to delete users.');
        }

        $user = User::findOrFail($id);

        if (!empty($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }
        if (!empty($user->background)) {
            Storage::disk('public')->delete($user->background);
        }

        $userName = $user->name;
        $user->delete();

        return redirect()->route('user')->with('success', "User '{$userName}' deleted successfully!");
    }

    public function getUsersData()
    {
        if (!$this->canManageUsers()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $users = User::select(['id', 'name', 'username', 'email', 'roleid', 'isactive', 'address', 'phone', 'avatar', 'jobs', 'company', 'created_at'])
            ->with('role')
            ->orderBy('id', 'asc')
            ->get();

        return response()->json($users);
    }

    public function searchUsers(Request $request): View
    {
        if (!$this->canManageUsers()) {
            abort(403, 'You do not have permission to search users.');
        }

        $query = $request->get('q', '');

        $users = User::where(function ($q) use ($query) {
            $q->where('name', 'LIKE', "%{$query}%")
                ->orWhere('username', 'LIKE', "%{$query}%")
                ->orWhere('email', 'LIKE', "%{$query}%")
                ->orWhere('address', 'LIKE', "%{$query}%")
                ->orWhere('phone', 'LIKE', "%{$query}%")
                ->orWhere('jobs', 'LIKE', "%{$query}%")
                ->orWhere('company', 'LIKE', "%{$query}%");
        })
            ->with('role')
            ->orderBy('name', 'asc')
            ->get();

        return view('users.index', compact('users'));
    }

    public function getProfile(): View
    {
        $user = Auth::user();
        return view('users.profile', compact('user'));
    }

    public function postProfileUpdate(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('users', 'username')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'address' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'jobs' => ['nullable', 'string', 'max:255'],
            'school' => ['nullable', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'avatar' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'background' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->jobs = $request->jobs;
        $user->school = $request->school;
        $user->company = $request->company;

        $path_avt = $user->avatar;
        if ($request->hasFile('avatar')) {
            if (!empty($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $extension = $request->file('avatar')->extension();
            $filename = Str::slug($request->username, '-') . '-avt.' . $extension;
            $path_avt = Storage::disk('public')->putFileAs('avatar', $request->file('avatar'), $filename);
        }
        $user->avatar = $path_avt;

        $path_bg = $user->background;
        if ($request->hasFile('background')) {
            if (!empty($user->background)) {
                Storage::disk('public')->delete($user->background);
            }
            $extension = $request->file('background')->extension();
            $filename = Str::slug($request->username, '-') . '-bg.' . $extension;
            $path_bg = Storage::disk('public')->putFileAs('background', $request->file('background'), $filename);
        }
        $user->background = $path_bg;

        $user->save();

        return redirect()->route('profile.view')->with('success', 'Profile updated successfully!');
    }

    public function getChangePasswordForm(): View
    {
        return view('users.change_password');
    }

    public function getChangePass($id): View
    {
        if (!$this->canManageUsers()) {
            abort(403, 'You do not have permission to view this user.');
        }

        $user = User::findOrFail($id);
        $roles = Role::orderBy('id', 'asc')->get();

        return view('users.changepass', compact('user', 'roles'));
    }

    public function postChangePassword(Request $request, $id): RedirectResponse
    {
        if (!$this->canManageUsers()) {
            abort(403, 'You do not have permission to update this user.');
        }

        $user = User::findOrFail($id);

        // Validation
        $request->validate([
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        if (!empty($request->password)) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('profile.view')->with('success', 'Password changed successfully!');
    }

    public function getPublicProfile(User $user): View
    {
        // ... logic
        return view('users.public_profile', compact('user'));
    }

    public function getPartnerRequests(): View
    {
        // ... logic
        return view('users.partner_requests');
    }
}
