<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // // // // // // // // // // // //
        // CREATE ROLES
        // // // // // // // // // // // //

        $role_admin = Role::create([
            'name' => 'admin'
        ]);

        $role_user = Role::create([
            'name' => 'user'
        ]);

        // // // // // // // // // // // //
        // CREATE SPECIFIC PERMISSIONS
        // // // // // // // // // // // //

        $delete_invoices = Permission::create([
            'name' => 'delete invoices'
        ]);


        // // // // // // // // // // // //
        // ASSIGN PERMISSIONS TO ROLES
        // // // // // // // // // // // //

        $role_user->syncPermissions([
            $delete_invoices
        ]);

        $role_admin->syncPermissions([
            $delete_invoices
        ]);
    }
}