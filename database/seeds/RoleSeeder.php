<?php

use Illuminate\Database\Seeder;

use App\Models\Role;
use App\Models\Permission;

class RoleSeeder extends Seeder
{
    private $roles = [
        'individual'=>'web',
        'corporate'=>'web',
        'admin'=>'admin',
        'sub_admin'=>'admin',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->roles as $key=>$value) {
            Role::firstOrCreate([
                'name' => $key,
                'status' => 1,
                'guard'=>$value,
            ]);
        }
    }
}
