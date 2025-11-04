<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Husniddin',
        //     'email' => 'husniddin13124041@gmail.com',
        //     'password' => 330440311
        // ]);

        $this->call([
            SubjectsTableSeeder::class,
            ConnectionTableSeeder::class,
            CalendarTableSeeder::class,
            FullDatabaseSeeder::class,
        ]);
    }
}
