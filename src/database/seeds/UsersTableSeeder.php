<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => 'naruto',
            'email' => 'naruto@gmail.com',
            'password' => bcrypt('naruto1234')
        ];
        
        User::create($param);

        $param = [
            'name' => 'sasuke',
            'email' => 'sasuke@gmail.com',
            'password' => bcrypt('sasuke1234')
        ];

        User::create($param);

        $param = [
            'name' => 'sakura',
            'email' => 'sakura@gmail.com',
            'password' => bcrypt('sakura1234')
        ];

        User::create($param);

    }
}
