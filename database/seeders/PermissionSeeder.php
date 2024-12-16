<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'account create',
            'account delete'
        ];

        foreach($permissions as $permission){
            if(!Permission::where("name", $permission)->exists())
            Permission::create([
                "name"=>$permission,
                "guard_name"=>"api"
            ]);
        }
    }
}
