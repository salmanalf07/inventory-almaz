<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    public function run()
    {

        $modules = [
            'ORDER' => 'Order',
            'INVOICE' => 'Invoice',
            'PARTIN' => 'Part In',
            'PRODUCTION' => 'Production',
            'PARTOUT' => 'Part Out',
            'CUSTOMER' => 'Customer',
            'PART' => 'Part',
            'USER' => 'User',
            'CAR' => 'Car',
            'DRIVER' => 'Driver',
            'APPLICATION' => 'Application',
            'PRODUCTION_STD' => 'Production Std',
            'BENSIN_TOL' => 'Bensin & Tol',
            'PETTY_CASH' => 'Petty Cash',
            'UANG_MAKAN' => 'Uang Makan',
            'EMPLOYEE_SALARY' => 'Employee Salary',
            'SET_DATE_SJ' => 'Set Date SJ',
        ];

        foreach ($modules as $slug => $name) {
            \Illuminate\Support\Facades\DB::table('permissions')->updateOrInsert(
                ['slug' => 'view_' . strtolower($slug)], 
                ['name' => 'View ' . $name, 'group' => 'Module', 'created_at' => now(), 'updated_at' => now()]
            );
            \Illuminate\Support\Facades\DB::table('permissions')->updateOrInsert(
                ['slug' => 'edit_' . strtolower($slug)], 
                ['name' => 'Edit ' . $name, 'group' => 'Module', 'created_at' => now(), 'updated_at' => now()]
            );
        }

        $reports = [
            'r_invsout' => 'In VS Out',
            'r_partin' => 'Part In',
            'r_partinn' => 'Summary In By Cust',
            'r_partoutt' => 'Part Out',
            'r_partout' => 'Summary Out By Cust',
            'r_sumpart' => 'Summary Out By Part',
            'r_sumpo' => 'Summary Out By PO',
            'r_sumng' => 'Summary NG',
            'r_order' => 'Order',
            'r_invoice' => 'Invoice',
            'r_production' => 'Production',
            'rekap_inv' => 'Rekap Invoice',
            'tracking_invoice' => 'Tracking Invoice',
            'r_topinv' => 'TOP Invoice',
            'r_sumprod' => 'Summary Production',
            'r_bensinTol' => 'Bensin & Tol',
            'r_pettyCash' => 'Petty Cash',
            'r_uMakan' => 'Uang Makan',
            'r_saldoAkhir' => 'Saldo Akhir',
            'REPORT_KAS' => 'Report Kas',
        ];

        foreach ($reports as $slug => $name) {
            \Illuminate\Support\Facades\DB::table('permissions')->updateOrInsert(
                ['slug' => $slug], 
                ['name' => $name, 'group' => 'Report', 'created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}
