<?php

use App\Permission;
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
            'name' => 'Antonio',
            'lastname' => 'Tomas',
            'email' => 'adminportales@promolife.com.mx',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);
        $admin = Role::create([
            'name' => 'admin',
            'display_name' => 'Administrador', // optional
            'description' => '', // optional
        ]);
        $user->profile()->update(['company' => 'Promo Life']);
        $user->attachRole($admin);

        $seller = User::create([
            'name' => 'Ived',
            'lastname' => 'Ramos',
            'email' => 'ived@promolife.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);
        $seller_role = Role::create([
            'name' => 'seller',
            'display_name' => 'Vendedor', // optional
            'description' => '', // optional
        ]);
        $seller->profile()->update(['company' => 'Promo Life']);
        $seller->attachRole($seller_role);

        $designer = User::create([
            'name' => 'Aide',
            'lastname' => 'Aguila',
            'email' => 'aide@promolife.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);
        $designer_role = Role::create([
            'name' => 'designer',
            'display_name' => 'Diseñador', // optional
            'description' => '', // optional
        ]);
        $designer->profile()->update(['company' => 'Promo Life']);
        $designer->attachRole($designer_role);

        $sales_manager = User::create([
            'name' => 'Jaime',
            'lastname' => 'Gonzalez',
            'email' => 'jaime@promolife.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);

        $sales_manager_role = Role::create([
            'name' => 'sales_manager',
            'display_name' => 'Gerente de Ventas', // optional
            'description' => '', // optional
        ]);
        $sales_manager->profile()->update(['company' => 'Promo Life']);
        $sales_manager->attachRole($sales_manager_role);

        $design_manager = User::create([
            'name' => 'Raul',
            'lastname' => 'Torres',
            'email' => 'raul@promolife.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);
        $design_manager_role = Role::create([
            'name' => 'design_manager',
            'display_name' => 'Encargado de Diseño', // optional
            'description' => '', // optional
        ]);
        $design_manager->profile()->update(['company' => 'Promo Life']);
        $design_manager->attachRole($design_manager_role);

        $sales_assistant = User::create([
            'name' => 'Leon',
            'lastname' => 'Mancera',
            'email' => 'leon@promolife.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);
        $sales_assistant_role = Role::create([
            'name' => 'sales_assistant',
            'display_name' => 'Asistente de Ventas', // optional
            'description' => '', // optional
        ]);

        $sales_assistant->profile()->update(['company' => 'Promo Life']);
        $sales_assistant->attachRole($sales_assistant_role);

        Permission::create([
            'name' => 'create-ticket',
            'display_name' => 'Crear Tickets', // optional
            'description' => '', // optional
        ]);
        Permission::create([
            'name' => 'attend-ticket',
            'display_name' => 'Atender Tickets', // optional
            'description' => '', // optional
        ]);
    }
}
