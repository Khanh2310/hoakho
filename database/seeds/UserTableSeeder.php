<?php

use Illuminate\Database\Seeder;
use App\Admin;
use App\Roles;
class UserTableSeeder extends Seeder
{

    public function run()
    {

        // Admin::truncate();

        // DB::table('admin_roles')->truncate();
        // $adminRoles = Roles::where('name','admin')->first();
        // $managerRoles = Roles::where('name','manager')->first();
        // $employeeRoles = Roles::where('name','employee')->first();
        // $deliveryRoles = Roles::where('name','delivery')->first();

        // $admin = Admin::create([
        //     'admin_name' => 'admin',
        //     'admin_email' => 'admin123@gmail.com',
        //     'admin_phone' => '0368038738',
        //     'password' => md5('123456'),
        //     'admin_gender' => 'Nam',
        //     'admin_address' => 'Thành phố Hà Nội, Quận Ba Đình, Phường Phúc Xá',
        //     'admin_birthday' => '2000-08-07'
        // ]);
        // $manager = Admin::create([
        //     'admin_name' => 'Khánh manager',
        //     'admin_email' => 'employee@gmail.com',
        //     'admin_phone' => '0368038730',
        //     'password' => md5('123456'),
        //     'admin_gender' => 'Nam',
        //     'admin_address' => 'Thành phố Hà Nội, Quận Ba Đình, Phường Phúc Xá',
        //     'admin_birthday' => '2000-08-07'
        // ]);
        // $employee = Admin::create([
        //     'admin_name' => 'khanh employee',
        //     'admin_email' => 'employee@gmail.com',
        //     'admin_phone' => '0368038731',
        //     'password' => md5('123456'),
        //     'admin_gender' => 'Nam',
        //     'admin_address' => 'Thành phố Hà Nội, Quận Ba Đình, Phường Phúc Xá',
        //     'admin_birthday' => '2000-08-07'
        // ]);
        // $delivery = Admin::create([
        //     'admin_name' => 'khanh delivery',
        //     'admin_email' => 'delivery@gmail.com',
        //     'admin_phone' => '0368038732',
        //     'password' => md5('123456'),
        //     'admin_gender' => 'Nam',
        //     'admin_address' => 'Thành phố Hà Nội, Quận Ba Đình, Phường Phúc Xá',
        //     'admin_birthday' => '2000-08-07'
        // ]);

        // $admin->roles()->attach($adminRoles);
        // $manager->roles()->attach($managerRoles);
        // $employee->roles()->attach($employeeRoles);
        // $delivery->roles()->attach($deliveryRoles);
        // factory(App\Admin::class,10)->create();
    }
}
