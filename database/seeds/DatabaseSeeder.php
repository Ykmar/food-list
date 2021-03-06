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
        factory(\App\Models\Recipe::class, 3)->create();

        factory(\App\Models\Recipe::class, 2)->create([
            'big' => true,
        ]);

        factory(\App\Models\Recipe::class, 3)->create([
            'season' => 'summer',
        ]);

        factory(\App\Models\Recipe::class, 2)->create([
            'season' => 'summer',
            'big' => true,
        ]);
    }
}
