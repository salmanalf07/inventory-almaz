<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;

class AssignAdminRoleSeeder extends Seeder
{
    public function run()
    {
        $user = User::find(1);
        $role = Role::where('slug', 'administrator')->first();
        
        if ($user && $role) {
            $user->roles()->sync([$role->id]);
        }
    }
}
