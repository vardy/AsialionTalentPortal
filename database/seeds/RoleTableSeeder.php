<?php

use App\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_admin = new Role();
        $role_admin->name = 'admin';
        $role_admin->description = 'A superuser';
        $role_admin->save();

        $role_user = new Role();
        $role_user->name = 'user';
        $role_user->description = 'A normal user';
        $role_user->save();
    }
}
