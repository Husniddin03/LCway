<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CalendarTableSeeder extends Seeder
{
    public function run(): void
    {
        $days = [
            ['weekdays' => 'Monday'],
            ['weekdays' => 'Tuesday'],
            ['weekdays' => 'Wednesday'],
            ['weekdays' => 'Thursday'],
            ['weekdays' => 'Friday'],
            ['weekdays' => 'Saturday'],
            ['weekdays' => 'Sunday'],
        ];

        DB::table('calendar')->insert($days);
    }
}
