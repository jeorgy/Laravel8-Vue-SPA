<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Auth\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $root = User::create([
            'name' => 'Root',
            'email' => 'root@root.com',
            'password' => bcrypt('123456'),
            'email_verified_at' => now()
        ]);

        $admin = User::create([
            'name' => 'Administrador',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456'),
            'email_verified_at' => now()
        ]);

        $user = User::create([
            'name' => 'Usuário',
            'email' => 'user@user.com',
            'password' => bcrypt('123456'),
            'email_verified_at' => now()
        ]);

        $root->assignRole('root');
        $admin->assignRole('admin');
        $user->assignRole('user');
    }
}
