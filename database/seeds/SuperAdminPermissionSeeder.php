<?php

use Illuminate\Database\Seeder;
use App\Models\{Permission,Admin,AdminPermission};

class SuperAdminPermissionSeeder extends Seeder
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
        $permissions = Permission::pluck('id')->toArray();
        $id = Admin::where('is_super', 1)->value('id');
        AdminPermission::where('admin_id', $id)->delete();
        $data = [];
        foreach ($permissions as $key => $value) {
            $data[] = ['admin_id'=>$id,'permission_id'=>$value]; 
        }
        if($data){
            AdminPermission::insert($data);
        }
    }
}
