<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

            $role = Role::create(['name'=> 'supper admin']);

            $permissions =
            [
                ['name' => 'Business View'],
                ['name' => 'Business Create'],
                ['name' => 'Business Edit'],
                ['name' => 'Business Delete'],

                ['name' => 'User View'],
                ['name' => 'User Create'],
                ['name' => 'User Edit'],
                ['name' => 'User Change Status'],
                ['name' => 'User Assign Role'],

                ['name' => 'Roles View'],
                ['name' => 'Roles Create'],
                ['name' => 'Roles Edit'],
                ['name' => 'Roles Delete'],
                ['name' => 'Roles Assign Permission'],

                ['name' => 'Customer View'],
                ['name' => 'Customer Create'],
                ['name' => 'Customer Edit'],
                ['name' => 'Customer Delete'],

                ['name' => 'Service View'],
                ['name' => 'Service Create'],
                ['name' => 'Service Edit'],
                ['name' => 'Service Delete'],

                ['name' => 'Service Category View'],
                ['name' => 'Service Category Create'],
                ['name' => 'Service Category Edit'],
                ['name' => 'Service Category Delete'],

                ['name' => 'Order View'],
                ['name' => 'Order Create'],
                ['name' => 'Order Edit'],
                ['name' => 'Order Delete'],

                ['name' => 'Expense View'],
                ['name' => 'Expense Create'],
                ['name' => 'Expense Edit'],
                ['name' => 'Expense Delete'],

                ['name' => 'Expense Category View'],
                ['name' => 'Expense Category Create'],
                ['name' => 'Expense Category Edit'],
                ['name' => 'Expense Category Delete'],

                ['name' => 'Report View'],
                ['name' => 'Report Create'],
                ['name' => 'Report Edit'],
                ['name' => 'Report Delete']

            ];
            foreach ($permissions as $item) {
                $permission= Permission::create($item);

            }
            $role->syncPermissions(Permission::all());
            $user = User::first();
            $user->assignRole($role);
        }


}
