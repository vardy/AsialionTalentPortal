<?php

use App\ProfilePicture;
use Illuminate\Database\Seeder;
use App\User;
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

        // Create and save superuser
        $superuser = new User();
        $superuser->name = 'Superuser';
        $superuser->email = 'webmaster@asialion.com';
        $superuser->password = bcrypt(env('ADMIN_PASSWORD'));
        $superuser->save();
        $superuser->assignRole('admin');

        // Create and save test user
        $testUserOne = new User();
        $testUserOne->name = 'Test User One';
        $testUserOne->email = 'test1@company.com';
        $testUserOne->password = bcrypt(env('TEST_USER_ONE_PASSWORD'));
        $testUserOne->save();
        $testUserOne->assignRole('user');

        $seeded_users = [$superuser, $testUserOne];

        foreach ($seeded_users as $seeded_user) {
            $personal_details = new PersonalDetails();
            $personal_details->user_id = $seeded_user->id;
            $personal_details->save();

            $cv = new CV();
            $cv->personal_details_id = $personal_details->id;
            $cv->save();

            $profile_picture = new ProfilePicture();
            $profile_picture->personal_details_id = $personal_details->id;
            $profile_picture->save();
        }
    }
}