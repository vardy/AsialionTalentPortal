<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use App\Invoice;
use App\File;
use App\PurchaseOrder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_admin = Role::where('name', 'admin')->first();
        $role_user  = Role::where('name', 'user')->first();

        $superuser = new User();
        $superuser->name = 'Superuser';
        $superuser->email = 'webmaster@asialion.com';
        $superuser->password = bcrypt(env('ADMIN_PASSWORD'));
        $superuser->save();
        $superuser->roles()->attach($role_admin);

        $testUserOne = new User();
        $testUserOne->name = 'Test User One';
        $testUserOne->email = 'test1@company.com';
        $testUserOne->password = bcrypt(env('TEST_USER_ONE_PASSWORD'));
        $testUserOne->save();
        $testUserOne->roles()->attach($role_user);

        $invoice = new Invoice();
        $invoice->total = 0;
        $invoice->user_id = $testUserOne->id;
        $invoice->save();

        $file = new File();
        $file->invoice_id = $invoice->id;
        $file->save();

        $purchase_order = new PurchaseOrder();
        $purchase_order->invoice_id = $invoice->id;
        $purchase_order->save();
    }
}