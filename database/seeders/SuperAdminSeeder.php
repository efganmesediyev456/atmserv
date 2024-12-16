<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //admin
        $admin=User::create([
            "email"=>"admin@gmail.com",
            "password"=>Hash::make("password"),
            "name"=>"admin"
        ]);

         //user1
         User::create([
            "email"=>"user1@gmail.com",
            "password"=>Hash::make("password"),
            "name"=>"user1"
        ]);

        //user2
        User::create([
            "email"=>"user2@gmail.com",
            "password"=>Hash::make("password"),
            "name"=>"user2"
        ]);

        //user3
        User::create([
            "email"=>"user3@gmail.com",
            "password"=>Hash::make("password"),
            "name"=>"user3"
        ]);


        //role
        Role::create([
            "name"=>"admin",
            "guard_name"=>"web"
        ]);

        $admin->assignRole("admin");
    }
}
