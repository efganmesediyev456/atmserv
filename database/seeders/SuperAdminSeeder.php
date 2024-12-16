<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //super admin
        User::create([
            "email"=>"superadmin@gmail.com",
            "password"=>Hash::make("password"),
            "name"=>"super admin",
            'super'=>1
        ]);


        //super admin
        User::create([
            "email"=>"admin@gmail.com",
            "password"=>Hash::make("password"),
            "name"=>"admin",
            'super'=>1
        ]);

         //user1
         User::create([
            "email"=>"user1@gmail.com",
            "password"=>Hash::make("password"),
            "name"=>"user1",
            'super'=>1
        ]);

        //user2
        User::create([
            "email"=>"user2@gmail.com",
            "password"=>Hash::make("password"),
            "name"=>"user2",
            'super'=>1
        ]);

        //user3
        User::create([
            "email"=>"user3@gmail.com",
            "password"=>Hash::make("password"),
            "name"=>"user3",
            'super'=>1
        ]);
    }
}