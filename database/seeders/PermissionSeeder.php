<?php

namespace Database\Seeders;

use App\Traits\StorePermissionTrait;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    use StorePermissionTrait;
    /**
     * Run the database seeds.
     */
    final public function run(): void
    {
        $permissions = [
            'role_access',
            'role_create',
            'role_edit',
            'role_delete',
            'user_access',
            'user_create',
            'user_edit',
            'user_delete',
            'fiscalYear_access',
            'fiscalYear_create',
            'fiscalYear_edit',
            'fiscalYear_delete',
            'officeSetting_access',
            'officeSetting_edit',
            'invoice_access',
            'invoice_create',
            'invoice_edit',
            'invoice_delete',
            'revenue_access',
            'revenue_create',
            'revenue_edit',
            'revenue_delete',
            'taxPayer_access',
            'taxPayer_create',
            'taxPayer_edit',
            'taxPayer_delete',
            'taxPayerType_access',
            'taxPayerType_create',
            'taxPayerType_edit',
            'taxPayerType_delete',
            'revenueCategory_access',
            'revenueCategory_create',
            'revenueCategory_edit',
            'revenueCategory_delete',
            'revenueSetting_access',
            'revenueSetting_create',
        ];

        $this->storePermission($permissions);
    }
}
