<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AssignAllPermissionsToAdminSeeder extends Seeder
{
    public function run()
    {
        // 1. Admin Role তৈরি বা নিয়ে নাও
        $role = Role::firstOrCreate(
            ['name' => 'admin', 'guard_name' => 'web']
        );

        // 2. Permission লিস্ট (যা assign করতে হবে)
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'product-list',
            'product-create',
            'product-edit',
            'product-delete',
            'category-list',
            'category-create',
            'category-edit',
            'category-delete',
            'attribute-list',
            'attribute-create',
            'attribute-edit',
            'attribute-delete',
            'banner-list',
            'banner-create',
            'banner-edit',
            'banner-delete',
            'page-list',
            'page-create',
            'page-edit',
            'page-delete',
            'permission-list',
            'permission-create',
            'permission-edit',
            'permission-delete',
            'setting-list',
            'setting-create',
            'setting-edit',
            'setting-delete',
            'social-list',
            'social-create',
            'social-edit',
            'social-delete',
            'contact-list',
            'contact-create',
            'contact-edit',
            'contact-delete',
            'shipping-list',
            'shipping-create',
            'shipping-edit',
            'shipping-delete',
            'color-list',
            'color-create',
            'color-edit',
            'color-delete',
            'subcategory-list',
            'subcategory-create',
            'subcategory-edit',
            'subcategory-delete',
            'childcategory-list',
            'childcategory-create',
            'childcategory-edit',
            'childcategory-delete',
            //coupon
            'coupon-list',
            'coupon-create',
            'coupon-update',
            'coupon-delete',
            'coupon-edit',
            //size
            'size-list',
            'size-create',
            'size-update',
            'size-delete',
            'size-edit',
            // facebook pixels
            'pixels-list',
            'pixels-create',
            'pixels-update',
            'pixels-delete',
            'pixels-edit',
            // combo product
            'combo-list',
            'combo-create',
            'combo-update',
            'combo-delete',
            'combo-edit'
        ];

        // 3. প্রতিটা permission ensure করে role এ assign করো
        foreach ($permissions as $perm) {
            $permission = Permission::firstOrCreate(
                ['name' => $perm, 'guard_name' => 'web']
            );
            $role->givePermissionTo($permission);
        }

        // 4. User (id=1) কে admin role assign করো
        $user = User::find(1);
        if ($user) {
            $user->assignRole($role);
        }
    }
}
