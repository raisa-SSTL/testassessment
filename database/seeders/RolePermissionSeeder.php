<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        //
        // Role::create(['name' => 'Admin', 'guard_name' => 'api']);
        // Role::create(['name' => 'User', 'guard_name' => 'api']);

        app()[
            \Spatie\Permission\PermissionRegistrar::class
        ]->forgetCachedPermissions();

        $arrayOfPermissionNames = [
            "create product",
            "update product",
            "delete product",
            "read product"
        ];
        $permissions = collect($arrayOfPermissionNames)->map(function (
            $permission
            ){
                return ["name"=>$permission, "guard_name"=>"api"];
        });
        Permission::insert($permissions->toArray());
        //create roles with the "api" guard
        $adminRole = Role::create(["name" => "Admin", "guard_name" => "api"]);
        $userRole = Role::create(["name" => "User", "guard_name" => "api"]);
        //assign permissions to admin
        $adminRole->givePermissionTo(Permission::all());
        //assign permissions to user
        $userRole->givePermissionTo(["update product", "read product"]);
    }
}
