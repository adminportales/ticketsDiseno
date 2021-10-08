<?php

use App\Type;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Type::create([
            'type' => 'Virtual'
        ]);
        Type::create([
            'type' => 'Presentacion'
        ]);
        Type::create([
            'type' => 'Diseño Especial'
        ]);
    }
}
