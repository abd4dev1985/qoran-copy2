<?php

namespace Database\Seeders;

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
        // \App\Models\User::factory(10)->create();
        //$this->call([SurahSeeder::class,]);
        $this->call([AyahSeeder::class,]);
        // $this->call([PageSeeder::class,]);
    }
}
