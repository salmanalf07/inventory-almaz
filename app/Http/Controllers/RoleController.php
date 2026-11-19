<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public function index()
    {
        $judul = 'Role & Permission Matrix';
        $permissions = Permission::orderBy('group')->orderBy('name')->get()->groupBy(function ($permission) {
            return $permission->group ?: 'Lainnya';
        });
        $roles = Role::with('permissions:id')->orderBy('name')->get();
        $rolePermissionIds = [];
        foreach ($roles as $role) {
            $rolePermissionIds[$role->id] = $role->permissions->pluck('id')->reduce(function ($carry, $id) {
                $carry[(int)$id] = true;
                return $carry;
            }, []);
        }

        return view('manage.roles', compact('judul', 'permissions', 'roles', 'rolePermissionIds'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:roles',
            'slug' => 'required|string|max:255|unique:roles',
            'description' => 'nullable|string',
            'permissions' => 'sometimes|array',
            'permissions.*' => 'integer|exists:permissions,id',
        ]);

        $role = Role::create([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'description' => $validated['description'] ?? null,
        ]);
        $role->permissions()->sync($validated['permissions'] ?? []);

        return response()->json(['success' => 'Role created successfully.']);
    }

    public function edit(Request $request)
    {
        $role = Role::with('permissions')->findOrFail($request->id);
        return response()->json($role);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('roles')->ignore($id)],
            'slug' => ['required', 'string', 'max:255', Rule::unique('roles')->ignore($id)],
            'description' => 'nullable|string',
            'permissions' => 'sometimes|array',
            'permissions.*' => 'integer|exists:permissions,id',
        ]);

        $role = Role::findOrFail($id);
        $role->update([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'description' => $validated['description'] ?? null,
        ]);
        $role->permissions()->sync($validated['permissions'] ?? []);

        return response()->json(['success' => 'Role updated successfully.']);
    }

    public function togglePermission(Request $request)
    {
        $validated = $request->validate([
            'role_id' => 'required|integer|exists:roles,id',
            'permission_id' => 'required|integer|exists:permissions,id',
            'enabled' => 'required|boolean',
        ]);

        $role = Role::findOrFail($validated['role_id']);
        if ($validated['enabled']) {
            $role->permissions()->syncWithoutDetaching([$validated['permission_id']]);
        } else {
            $role->permissions()->detach($validated['permission_id']);
        }

        return response()->json(['success' => true]);
    }

    public function storePermission(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:permissions,slug',
            'description' => 'nullable|string',
            'group' => 'required|string|max:255',
            'roles' => 'sometimes|array',
            'roles.*' => 'integer|exists:roles,id',
        ]);

        $permission = Permission::create([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'description' => $validated['description'] ?? null,
            'group' => $validated['group'],
        ]);
        $permission->roles()->sync($validated['roles'] ?? []);

        return response()->json(['success' => true, 'permission' => $permission]);
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        DB::transaction(function () use ($role) {
            $role->permissions()->detach();
            $role->delete();
        });

        return response()->json(['success' => 'Role deleted successfully.']);
    }
}
