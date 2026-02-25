<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    public function run()
    {
        // check if user already exists
        $user = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('123456'),
                'image' => 'public/backEnd/assets/images/default-user.png', // default image
                'status' => 1, // optional, active
            ]
        );


        // check if role exists
        $role = Role::firstOrCreate(['name' => 'Admin']);

        // assign all permissions to Admin role
        $role->syncPermissions(Permission::all());

        // assign role to user
        $user->assignRole($role); // role object works fine
    }
}
