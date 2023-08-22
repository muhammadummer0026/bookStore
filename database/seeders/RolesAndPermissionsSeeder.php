<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {

        // Define permissions
        $permissions = [
            'view_dashboard', 'manage_users', 'update_or_create_image', 'get_all_books',
            'get_individual_book', 'search_books', 'update_book', 'destroy_book', 'add_order',
            'get_all_orders', 'get_individual_order', 'search_orders', 'update_order',
            'destroy_order', 'add_rating', 'get_all_ratings', 'get_individual_rating',
            'update_rating', 'destroy_rating', 'average_rating', 'get_all_users', 'get_individual_user',
            'search_users', 'update_user', 'destroy_user', 'register_user', 'verify_email',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        // Assign permissions to roles
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->syncPermissions($permissions);

        $userRole = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);
        $userRole->syncPermissions([
            'get_all_books', 'get_individual_book', 'search_books', 'add_order', 'update_order', 'destroy_order',
            'add_rating', 'get_all_ratings', 'register_user', 'average_rating',
        ]);
    }
}
