<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CalendarTableSeeder extends Seeder
{
    public function run(): void
    {
        $days = [
            ['weekdays' => 'Dushanba'],
            ['weekdays' => 'Seshanba'],
            ['weekdays' => 'Chorshanba'],
            ['weekdays' => 'Payshanba'],
            ['weekdays' => 'Juma'],
            ['weekdays' => 'Shanba'],
        ];

        DB::table('calendar')->insert($days);
    }
}
