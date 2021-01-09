<?php

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    private $permissions = [
        'customer_management_access',
        'order_management_access',
        'categories_management_access',
        'cms_management_access',
        'coupon_management_access',
        'location_management_access',
        'manufactuers_management_access',
        'products_management_access',
        'courses_management_access',
        'queries_management_access',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->permissions as $row) {
            Permission::firstOrCreate([
                'title' => $row
            ]);
        }
    }
}
