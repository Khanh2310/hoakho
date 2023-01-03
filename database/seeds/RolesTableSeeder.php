<?php

use Illuminate\Database\Seeder;
use App\Roles;
class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Roles::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Roles::create(['name'=>'admin']);
        Roles::create(['name'=>'manager']);
        Roles::create(['name'=>'employee']);
        Roles::create(['name'=>'delivery']);
    }
}
