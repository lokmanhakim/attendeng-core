<?php

use App\Configs\BaseSeeder;
use App\Models\User;

class UserSeeder extends BaseSeeder
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     *
     *
     */
    public function run()
    {
        $user = new User();
        $user->email = 'hello@infinitelogix.com.my';
        $user->username = 'attendeng';
        $user->password = password_hash('4tt3ndeng', PASSWORD_DEFAULT);
        $user->save();

        $user = new User();
        $user->email = 'lokman@infinitelogix.com.my';
        $user->username = 'lokman';
        $user->password = password_hash('4tt3ndeng', PASSWORD_DEFAULT);
        $user->save();

        $user = new User();
        $user->email = 'izzudin.razali@infinitelogix.com.my';
        $user->username = 'izzudin.razali';
        $user->password = password_hash('930224145171', PASSWORD_DEFAULT);
        $user->save();

        $user = new User();
        $user->email = 'taha.norani@infinitelogix.com.my';
        $user->username = 'taha.norani';
        $user->password = password_hash('941224016007', PASSWORD_DEFAULT);
        $user->save();

        $user = new User();
        $user->email = 'mimie@infinitelogix.com.my';
        $user->username = 'mimi';
        $user->password = password_hash('861126235468', PASSWORD_DEFAULT);
        $user->save();

        $user = new User();
        $user->email = 'adila.azli@infinitelogix.com.my';
        $user->username = 'adila.azli';
        $user->password = password_hash('860622295326', PASSWORD_DEFAULT);
        $user->save();

        $user = new User();
        $user->email = 'faiqah.seth@infinitelogix.com.my';
        $user->username = 'faiqah.seth';
        $user->password = password_hash('930603105970', PASSWORD_DEFAULT);
        $user->save();

        $user = new User();
        $user->email = 'edzhan.adnan@infinitelogix.com.my';
        $user->username = 'edzhan.adnan';
        $user->password = password_hash('901206016437', PASSWORD_DEFAULT);
        $user->save();

    }
}
