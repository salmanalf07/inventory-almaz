<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = \App\Models\Role::create(['name' => 'Administrator', 'slug' => 'admin', 'description' => 'Full access']);
        $userRole = \App\Models\Role::create(['name' => 'User', 'slug' => 'user', 'description' => 'Limited access']);

        $viewPrices = \App\Models\Permission::create(['name' => 'View Prices', 'slug' => 'view_prices', 'group' => 'PartIn']);
        $editPrices = \App\Models\Permission::create(['name' => 'Edit Prices', 'slug' => 'edit_prices', 'group' => 'PartIn']);

        $adminRole->permissions()->attach([$viewPrices->id, $editPrices->id]);
    }
}
