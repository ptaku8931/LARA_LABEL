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
            'name' => 'Guest User',
            'email' => 'guest@gmail.com',
            'password' => bcrypt('guest1234')
        ];
        
        User::create($param);

    }
}
