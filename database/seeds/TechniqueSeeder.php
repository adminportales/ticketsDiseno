<?php

use App\Technique;
use Illuminate\Database\Seeder;

class TechniqueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Technique::create([
            'name' => 'Grabado Laser'
        ]);
        Technique::create([
            'name' => 'Serigrafia'
        ]);
        Technique::create([
            'name' => 'Tampografia'
        ]);
        Technique::create([
            'name' => 'Gota de resina'
        ]);
        Technique::create([
            'name' => 'Bordado'
        ]);
    }
}
