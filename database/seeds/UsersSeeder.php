<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'naho',
                'email' => 'n@gmail.com',
                'department_id' => 3,
                'password' => Hash::make('11111111'),
    
            ],
            [
                'id' => 2,
                'name' => 'taro',
                'department_id' => 4,
                'email' => 't@gmail.com',
                'password' => Hash::make('22222222'),
            ],
            
        ]);
    }
}
