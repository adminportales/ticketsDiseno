<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(TypeSeeder::class);
        $this->call(PrioritySeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(TechniqueSeeder::class);
    }
}
