<?php

use Illuminate\Database\Seeder;

use App\Models\{
    Admin, Role
};
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::updateOrCreate([
            'email' => 'admin@gmail.com',
            'role_id' => Role::where('name', 'admin')->value('id'),
            'is_super'=>true
        ],[
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin@123'),
            'role_id' => Role::where('name', 'admin')->value('id'),
            'status' => 1,
            'is_super'=>true
        ]);
    }
}
