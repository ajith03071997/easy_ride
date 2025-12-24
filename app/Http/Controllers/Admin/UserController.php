<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['roles', 'vendor'])->get();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::whereIn('name', ['admin', 'vendor', 'driver'])->get();
        $vendors = Vendor::orderBy('company_name')->get();

        return view('admin.users.create', compact('roles', 'vendors'));
    }

    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();

        $password = $data['password'] ?? str()->password(10);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'vendor_id' => $data['vendor_id'] ?? null,
            'status' => $data['status'],
            'password' => Hash::make($password),
        ]);

        $user->assignRole($data['role']);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $roles = Role::whereIn('name', ['admin', 'vendor', 'driver'])->get();
        $vendors = Vendor::orderBy('company_name')->get();

        return view('admin.users.edit', compact('user', 'roles', 'vendors'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();

        $update = [
            'name' => $data['name'],
            'email' => $data['email'],
            'vendor_id' => $data['vendor_id'] ?? null,
            'status' => $data['status'],
        ];

        if (!empty($data['password'])) {
            $update['password'] = Hash::make($data['password']);
        }

        $user->update($update);

        $user->syncRoles([$data['role']]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }
}


