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

        User::factory()->create([
            'name' => 'Husniddin G\'afforov',
            'email' => 'husniddin13124041@gmail.com',
            'password' => bcrypt('330440311'),
            'role' => 'admin',
            'google_id' => '112106458759192214990',
            'avatar' => 'https://lh3.googleusercontent.com/a/ACg8ocL4WlERMSuEiR4fes2os85yVHweFOF7TOTsvYdTw2mzaTpp21s=s96-c'
        ]);

        $this->call([
            SamarkandCentersSeeder::class,
            UzbekistanOSMEducationSeederNew::class,
            UzbekistanLearningCentersSeeder::class,
            CentralAsiaSeeder::class,
            NewDataSeeder::class,
            CleanDuplicatesSimpleSeeder::class,
        ]);
    }
}
