<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use App\Invoice;
use App\File;
use App\PurchaseOrder;
use App\PersonalDetails;
use App\CV;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Initialise roles to add to superuser and test user.
        $role_admin = Role::where('name', 'admin')->first();
        $role_user  = Role::where('name', 'user')->first();

        // Create and save superuser
        $superuser = new User();
        $superuser->name = 'Superuser';
        $superuser->email = 'webmaster@asialion.com';
        $superuser->password = bcrypt(env('ADMIN_PASSWORD'));
        $superuser->save();
        $superuser->roles()->attach($role_admin);

        // Create and save test user
        $testUserOne = new User();
        $testUserOne->name = 'Test User One';
        $testUserOne->email = 'test1@company.com';
        $testUserOne->password = bcrypt(env('TEST_USER_ONE_PASSWORD'));
        $testUserOne->save();
        $testUserOne->roles()->attach($role_user);

        // Create and save an invoice.
        // Invoice's number is a substring of the first 5 digits of its id,
        // so that must be set after the first save of the invoice.
        $invoice = new Invoice();
        $invoice->user_id = $testUserOne->id;
        $invoice->total = 0;
        $invoice->save();
        $invoice->invoice_number = substr($invoice->id, 0, 5);
        $invoice->save();

        // File and purchase order is saved with the invoice's ID set
        // File's fields are set by parsing a file's metadata with provided
        // functions for Files.
        $file = new File();
        $file->invoice_id = $invoice->id;
        $file->file_name = 'Dolphins.mp4';
        $file->original_file_name = 'Dolphins.mp4';
        $file->file_size = '4000';
        $file->file_extension = '.mp4';
        $file->file_mime = 'video/mp4';
        $file->save();

        $purchase_order = new PurchaseOrder();
        $purchase_order->invoice_id = $invoice->id;
        $purchase_order->po_number = 7849;
        $purchase_order->description = 'Order for screwdrivers';
        $purchase_order->value = 100;
        $purchase_order->save();

        $personal_details = new PersonalDetails();
        $personal_details->user_id = $testUserOne->id;
        $personal_details->save();

        $cv = new CV();
        $cv->personal_details_id = $personal_details->id;
        $cv->save();
    }
}