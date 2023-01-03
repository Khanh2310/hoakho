<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Admin;
use App\Roles;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Admin::class, function (Faker $faker) {
    return [
        'admin_name' => $faker->name,
        'admin_phone' => '0123456789',
        'admin_email' => $faker->unique()->safeEmail,
        'password' => 'e10adc3949ba59abbe56e057f20f883e', // password
        'admin_gender' => 'Nam',
        'admin_address' => 'Thành phố Hà Nội, Quận Ba Đình, Phường Phúc Xá',
        'admin_birthday' => '2000-08-07'
    ];
});
$factory->afterCreating(Admin::class, function($admin, $faker){
    $roles = Roles::where('name','user')->get();
    $admin->roles()->sync($roles->pluck('roles_id')->toArray());
});
