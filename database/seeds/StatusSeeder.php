<?php

namespace Database\Seeders;

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
            'status' => 'Creado',
        ]);

        Status::create([
            'status' => 'Diseño en proceso',
        ]);

        Status::create([
            'status' => 'Entregado',
        ]);

        Status::create([
            'status' => 'Solicitud de ajustes',
        ]);

        Status::create([
            'status' => 'Realizando ajustes',
        ]);

        Status::create([
            'status' => 'Finalizado',
        ]);

        Status::create([
            'status' => 'Falta de información',
        ]);

        Status::create([
            'status' => 'Solicitar artes',
        ]);

        Status::create([
            'status' => 'Entrega de artes',
        ]);

        Status::create([
            'status' => 'Modificación de ticket',

        ]);

        Status::create([
            'status' => 'Solicitud modificación artes',

        ]);

        Status::create([
            'status' => 'Modificando artes',

        ]);
    }
}
