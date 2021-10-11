<?php

use App\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::create([
            'status' => 'Creado'
        ]);

        Status::create([
            'status' => 'En revision'
        ]);

        Status::create([
            'status' => 'Entregado'
        ]);

        Status::create([
            'status' => 'Solicitud de ajustes'
        ]);

        Status::create([
            'status' => 'Realizando ajustes'
        ]);

        Status::create([
            'status' => 'Finalizado'
        ]);
        //
    }
}
