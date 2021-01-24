<?php

use Illuminate\Database\Seeder;
Use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::forceCreate([
            'id' => '1',
            'username' => 'administrator',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
            'level' => 'Administrator',
        ]);

        User::forceCreate([
            'id' => '2',
            'username' => 'user',
            'email' => 'user@gmail.com',
            'password' => Hash::make('123456'),
            'level' => 'User',
        ]);

    }
}
