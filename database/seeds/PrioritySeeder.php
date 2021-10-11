<?php

use App\Priority;
use Illuminate\Database\Seeder;

class PrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Priority::create([
            'priority' => 'Alta'
        ]);
        Priority::create([
            'priority' => 'Media'
        ]);
        Priority::create([
            'priority' => 'Baja'
        ]);
    }
}
