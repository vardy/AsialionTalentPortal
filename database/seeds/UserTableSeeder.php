<?php
use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superuser = new User();
        $superuser->name = 'Superuser';
        $superuser->email = 'webmaster@asialion.com';
        $superuser->password = bcrypt(env('ADMIN_PASSWORD'));
        $superuser->save();

        $testUserOne = new User();
        $testUserOne->name = 'Test User One';
        $testUserOne->email = 'test1@company.com';
        $testUserOne->password = bcrypt(env('TEST_USER_ONE_PASSWORD'));
        $testUserOne->save();
    }
}