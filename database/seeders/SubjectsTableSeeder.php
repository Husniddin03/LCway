<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectsTableSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = [
            // 📘 Maktab fanlari
            ['type' => 'Maktab fanlari', 'name' => 'Matematika'],
            ['type' => 'Maktab fanlari', 'name' => 'Algebra'],
            ['type' => 'Maktab fanlari', 'name' => 'Geometriya'],
            ['type' => 'Maktab fanlari', 'name' => 'Fizika'],
            ['type' => 'Maktab fanlari', 'name' => 'Kimyo'],
            ['type' => 'Maktab fanlari', 'name' => 'Biologiya'],
            ['type' => 'Maktab fanlari', 'name' => 'Informatika / Kompyuter savodxonligi'],
            ['type' => 'Maktab fanlari', 'name' => 'Ona tili va adabiyot'],
            ['type' => 'Maktab fanlari', 'name' => 'Ingliz tili'],
            ['type' => 'Maktab fanlari', 'name' => 'Rus tili'],
            ['type' => 'Maktab fanlari', 'name' => 'Tarix'],
            ['type' => 'Maktab fanlari', 'name' => 'Geografiya'],

            // 🌍 Chet tillar
            ['type' => 'Chet tillar', 'name' => 'Ingliz tili (General English, IELTS, CEFR, TOEFL, Duolingo)'],
            ['type' => 'Chet tillar', 'name' => 'Rus tili'],
            ['type' => 'Chet tillar', 'name' => 'Nemis tili'],
            ['type' => 'Chet tillar', 'name' => 'Fransuz tili'],
            ['type' => 'Chet tillar', 'name' => 'Arab tili'],
            ['type' => 'Chet tillar', 'name' => 'Koreys tili'],
            ['type' => 'Chet tillar', 'name' => 'Turk tili'],
            ['type' => 'Chet tillar', 'name' => 'Xitoy tili'],

            // 💻 IT va Texnologiya
            ['type' => 'IT va Texnologiya', 'name' => 'Kompyuter savodxonligi (MS Office, Internet)'],
            ['type' => 'IT va Texnologiya', 'name' => 'Grafik dizayn (Photoshop, Illustrator, CorelDraw)'],
            ['type' => 'IT va Texnologiya', 'name' => 'Web dasturlash (HTML, CSS, JavaScript, PHP, Laravel, Python, Django, Node.js)'],
            ['type' => 'IT va Texnologiya', 'name' => 'Mobil dasturlash (Android, iOS, Flutter)'],
            ['type' => 'IT va Texnologiya', 'name' => 'Sun’iy intellekt (AI) va Data Science'],
            ['type' => 'IT va Texnologiya', 'name' => 'Kiberxavfsizlik'],
            ['type' => 'IT va Texnologiya', 'name' => 'Robototexnika va Arduino'],

            // 🧠 Shaxsiy rivojlanish
            ['type' => 'Shaxsiy rivojlanish', 'name' => 'Tez o‘qish (Speed Reading)'],
            ['type' => 'Shaxsiy rivojlanish', 'name' => 'Mantiqiy fikrlash (Logika)'],
            ['type' => 'Shaxsiy rivojlanish', 'name' => 'Mental arifmetika'],
            ['type' => 'Shaxsiy rivojlanish', 'name' => 'Xotirani rivojlantirish'],
            ['type' => 'Shaxsiy rivojlanish', 'name' => 'Nutq madaniyati va oratorlik'],
            ['type' => 'Shaxsiy rivojlanish', 'name' => 'Psixologiya asoslari'],

            // 📈 Biznes va Kasbiy yo‘nalish
            ['type' => 'Biznes va Kasbiy yo‘nalish', 'name' => 'Buxgalteriya va 1C'],
            ['type' => 'Biznes va Kasbiy yo‘nalish', 'name' => 'Menejment va Marketing'],
            ['type' => 'Biznes va Kasbiy yo‘nalish', 'name' => 'Biznes asoslari'],
            ['type' => 'Biznes va Kasbiy yo‘nalish', 'name' => 'Startap va tadbirkorlik'],
            ['type' => 'Biznes va Kasbiy yo‘nalish', 'name' => 'Moliyaviy savodxonlik'],
            ['type' => 'Biznes va Kasbiy yo‘nalish', 'name' => 'HR (inson resurslarini boshqarish)'],

            // 🎨 San’at va ijod
            ['type' => 'San’at va ijod', 'name' => 'Musiqa (fortepiano, gitara, vokal va h.k.)'],
            ['type' => 'San’at va ijod', 'name' => 'Rassomchilik va dizayn'],
            ['type' => 'San’at va ijod', 'name' => 'Teatr va aktyorlik mahorati'],
        ];

        DB::table('subjects')->insert($subjects);
    }
}
