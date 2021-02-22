<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Auth\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            /**
             * Permissions
             */
            ['name' => 'view_permissions', 'details' => 'Permissões [ver]', 'guard' => 'api'],
            ['name' => 'add_permissions', 'details' => 'Permissões [adicionar]', 'guard' => 'api'],
            ['name' => 'edit_permissions', 'details' => 'Permissões [editar]', 'guard' => 'api'],
            ['name' => 'delete_permissions', 'details' => 'Permissões [apagar]', 'guard' => 'api'],

            /**
             * Roles
             */
            ['name' => 'view_roles', 'details' => 'Perfis [ver]', 'guard' => 'api'],
            ['name' => 'add_roles', 'details' => 'Perfis [adicionar]', 'guard' => 'api'],
            ['name' => 'edit_roles', 'details' => 'Perfis [editar]', 'guard' => 'api'],
            ['name' => 'delete_roles', 'details' => 'Perfis [apagar]', 'guard' => 'api'],

            /**
             * Users
             */
            ['name' => 'view_users', 'details' => 'Usuários [ver]', 'guard' => 'api'],
            ['name' => 'add_users', 'details' => 'Usuários [adicionar]', 'guard' => 'api'],
            ['name' => 'edit_users', 'details' => 'Usuários [editar]', 'guard' => 'api'],
            ['name' => 'delete_users', 'details' => 'Usuários [apagar]', 'guard' => 'api'],

            /**
             * To Do List
             */
            ['name' => 'view_to_dos', 'details' => 'Tarefas [ver]', 'guard' => 'api'],
            ['name' => 'add_to_dos', 'details' => 'Tarefas [adicionar]', 'guard' => 'api'],
            ['name' => 'edit_to_dos', 'details' => 'Tarefas [editar]', 'guard' => 'api'],
            ['name' => 'delete_to_dos', 'details' => 'Tarefas [apagar]', 'guard' => 'api'],
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission['name'],
                'details' => $permission['details'],
                'guard_name' => $permission['guard']
            ]);
        }
    }
}
