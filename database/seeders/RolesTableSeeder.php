<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Auth\Permission;
use App\Models\Auth\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Create Root role
         */
        $root = Role::create([
            'name' => 'root',
            'details' => 'Root',
            'guard_name' => 'api'
        ]);

        $root->syncPermissions(Permission::all());

        /**
         * Create Admin role
         */
        $admin = Role::create([
            'name' => 'admin',
            'details' => 'Administrador',
            'guard_name' => 'api'
        ]);
        
        $admin->syncPermissions(Permission::whereNotIn('name', [
            'delete_users', 'add_permissions', 'edit_permissions', 'delete_permissions',
            ])->get());

        /**
         * Create User role
         */
        $user = Role::create([
            'name' => 'user',
            'details' => 'Usuário',
            'guard_name' => 'api'
        ]);

        $user->syncPermissions(Permission::whereIn('name', [
            'view_to_dos', 'add_to_dos', 'edit_to_dos', 'delete_to_dos',
        ])->get());
    }
}
