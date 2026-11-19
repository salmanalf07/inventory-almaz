<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class MigrateGranularPermissionsSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();

        foreach ($users as $user) {
            $role = $user->roles()->first();
            if (!$role) continue;

            // Map old permissions to new granular ones
            $legacyPermissions = explode(',', $user->module . ',' . $user->phone);
            $legacyPermissions = array_filter(array_map('trim', $legacyPermissions));

            $newPermissions = [];
            foreach ($legacyPermissions as $lp) {
                // If legacy permission matches a module slug, add view and edit
                $viewPerm = Permission::where('slug', 'view_' . strtolower($lp))->first();
                if ($viewPerm) $newPermissions[] = $viewPerm->id;
                
                $editPerm = Permission::where('slug', 'edit_' . strtolower($lp))->first();
                if ($editPerm) $newPermissions[] = $editPerm->id;

                // Also keep report permissions
                $reportPerm = Permission::where('slug', $lp)->first();
                if ($reportPerm) $newPermissions[] = $reportPerm->id;
            }

            $role->permissions()->syncWithoutDetaching(array_unique($newPermissions));
        }
    }
}
