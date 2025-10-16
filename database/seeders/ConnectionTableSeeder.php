<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConnectionTableSeeder extends Seeder
{
    public function run(): void
    {
        $connections = [
            ['name' => 'Telegram'],
            ['name' => 'YouTube'],
            ['name' => 'Facebook'],
            ['name' => 'Instagram'],
            ['name' => 'TikTok'],
            ['name' => 'Website'],
            ['name' => 'Email'],
            ['name' => 'Phone'],
            ['name' => 'Github'],
            ['name' => 'LinkedIn'],
            ['name' => 'Twitter'],
            ['name' => 'WhatsApp'],
            ['name' => 'Viber'],
            ['name' => 'Snapchat'],
            ['name' => 'Pinterest'],
            ['name' => 'Reddit'],
            ['name' => 'Tumblr'],
            ['name' => 'Flickr'],
            ['name' => 'Medium'],
            ['name' => 'Quora'],
            ['name' => 'WeChat'],
            ['name' => 'Line'],
            ['name' => 'VK'],
            ['name' => 'Odnoklassniki'],
            ['name' => 'Yelp'],
            ['name' => 'Zalo'],
        ];

        DB::table('connection')->insert($connections);
    }
}
