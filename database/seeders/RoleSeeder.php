<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Create Administrator Role
        $admin = Role::updateOrCreate(
            ['slug' => 'administrator'],
            ['name' => 'Administrator', 'description' => 'Full system access']
        );

        // Assign all permissions to Administrator
        $allPermissions = Permission::all();
        $admin->permissions()->sync($allPermissions->pluck('id'));

        // Create User Role
        $user = Role::updateOrCreate(
            ['slug' => 'user'],
            ['name' => 'User', 'description' => 'Standard user access']
        );

        // Assign basic view permissions to User
        $viewPermissions = Permission::where('slug', 'like', 'view_%')->orWhere('group', 'Report')->get();
        $user->permissions()->sync($viewPermissions->pluck('id'));
    }
}
