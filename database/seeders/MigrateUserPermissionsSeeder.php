<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class MigrateUserPermissionsSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();

        foreach ($users as $user) {
            // 1. Create or get role based on user's legacy role
            $roleName = $user->role ?: 'User';
            $role = Role::firstOrCreate(
                ['name' => $roleName],
                ['slug' => strtolower(str_replace(' ', '_', $roleName)), 'description' => 'Migrated role']
            );

            // 2. Assign role to user
            $user->roles()->syncWithoutDetaching([$role->id]);

            // 3. Map legacy permissions (module + phone) to new permissions
            $legacyPermissions = explode(',', $user->module . ',' . $user->phone);
            $legacyPermissions = array_filter(array_map('trim', $legacyPermissions));

            $permissionIds = Permission::whereIn('slug', $legacyPermissions)->pluck('id')->toArray();

            // 4. Assign permissions to the role
            $role->permissions()->syncWithoutDetaching($permissionIds);
        }
    }
}
