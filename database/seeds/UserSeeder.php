<?php

use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Admin',
            'lastname' => 'Admin',
            'email' =>'correo@correo.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);

        $admin = Role::create([
            'name' => 'admin',
            'display_name' => 'Administrador', // optional
            'description' => '', // optional
        ]);

       $user->attachRole($admin);

        Role::create([
            'name' => 'seller',
            'display_name' => 'Vendedor', // optional
            'description' => '', // optional
        ]);
        Role::create([
            'name' => 'designer',
            'display_name' => 'Diseñador', // optional
            'description' => '', // optional
        ]);
        Role::create([
            'name' => 'saler_manager',
            'display_name' => 'Gerente de Ventas', // optional
            'description' => '', // optional
        ]);
        Role::create([
            'name' => 'saler_design',
            'display_name' => 'Gerente de Diseño', // optional
            'description' => '', // optional
        ]);
    }
}
