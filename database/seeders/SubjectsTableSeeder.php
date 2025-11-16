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
            ['type' => 'Maktab fanlari', 'name' => 'Matematika', 'icon' => '📐'],
            ['type' => 'Maktab fanlari', 'name' => 'Algebra', 'icon' => '🔢'],
            ['type' => 'Maktab fanlari', 'name' => 'Geometriya', 'icon' => '📏'],
            ['type' => 'Maktab fanlari', 'name' => 'Fizika', 'icon' => '⚡'],
            ['type' => 'Maktab fanlari', 'name' => 'Kimyo', 'icon' => '🧪'],
            ['type' => 'Maktab fanlari', 'name' => 'Biologiya', 'icon' => '🧬'],
            ['type' => 'Maktab fanlari', 'name' => 'Informatika / Kompyuter savodxonligi', 'icon' => '💻'],
            ['type' => 'Maktab fanlari', 'name' => 'Ona tili va adabiyot', 'icon' => '📖'],
            ['type' => 'Maktab fanlari', 'name' => 'Ingliz tili', 'icon' => '🇬🇧'],
            ['type' => 'Maktab fanlari', 'name' => 'Rus tili', 'icon' => '🇷🇺'],
            ['type' => 'Maktab fanlari', 'name' => 'Tarix', 'icon' => '🏛️'],
            ['type' => 'Maktab fanlari', 'name' => 'Geografiya', 'icon' => '🌍'],

            // 🌍 Chet tillar
            ['type' => 'Chet tillar', 'name' => 'Ingliz tili (General English, IELTS, CEFR, TOEFL, Duolingo)', 'icon' => '🎓'],
            ['type' => 'Chet tillar', 'name' => 'Rus tili', 'icon' => '🇷🇺'],
            ['type' => 'Chet tillar', 'name' => 'Nemis tili', 'icon' => '🇩🇪'],
            ['type' => 'Chet tillar', 'name' => 'Fransuz tili', 'icon' => '🇫🇷'],
            ['type' => 'Chet tillar', 'name' => 'Arab tili', 'icon' => '🇸🇦'],
            ['type' => 'Chet tillar', 'name' => 'Koreys tili', 'icon' => '🇰🇷'],
            ['type' => 'Chet tillar', 'name' => 'Turk tili', 'icon' => '🇹🇷'],
            ['type' => 'Chet tillar', 'name' => 'Xitoy tili', 'icon' => '🇨🇳'],
            ['type' => 'Chet tillar', 'name' => 'Yapon tili', 'icon' => '🇯🇵'],
            ['type' => 'Chet tillar', 'name' => 'Ispan tili', 'icon' => '🇪🇸'],
            ['type' => 'Chet tillar', 'name' => 'Italyan tili', 'icon' => '🇮🇹'],
            ['type' => 'Chet tillar', 'name' => 'Fors tili', 'icon' => '🇮🇷'],

            // 💻 IT va Texnologiya
            ['type' => 'IT va Texnologiya', 'name' => 'Kompyuter savodxonligi (MS Office, Internet)', 'icon' => '🖥️'],
            ['type' => 'IT va Texnologiya', 'name' => 'Grafik dizayn (Photoshop, Illustrator, CorelDraw)', 'icon' => '🎨'],
            ['type' => 'IT va Texnologiya', 'name' => 'Mobil dasturlash (Android, iOS, Flutter)', 'icon' => '📱'],
            ['type' => 'IT va Texnologiya', 'name' => 'Sun\'iy intellekt (AI) va Data Science', 'icon' => '🤖'],
            ['type' => 'IT va Texnologiya', 'name' => 'Kiberxavfsizlik', 'icon' => '🔒'],
            ['type' => 'IT va Texnologiya', 'name' => 'Robototexnika va Arduino', 'icon' => '🤖'],
            ['type' => 'IT va Texnologiya', 'name' => '3D modellashtirish va animatsiya', 'icon' => '🖌️'],
            ['type' => 'IT va Texnologiya', 'name' => 'Video montaj va tahrirlash', 'icon' => '🎬'],
            ['type' => 'IT va Texnologiya', 'name' => 'Oʻyin dasturlash (Unity, Unreal Engine)', 'icon' => '🎮'],
            ['type' => 'IT va Texnologiya', 'name' => 'Bulutli hisoblash (AWS, Azure, Google Cloud)', 'icon' => '☁️'],
            ['type' => 'IT va Texnologiya', 'name' => 'Ma\'lumotlar bazasi boshqaruvi (SQL, NoSQL)', 'icon' => '🗄️'],
            ['type' => 'IT va Texnologiya', 'name' => 'DevOps va CI/CD', 'icon' => '⚙️'],
            ['type' => 'IT va Texnologiya', 'name' => 'Blockchain va Kriptovalyutalar', 'icon' => '⛓️'],
            ['type' => 'IT va Texnologiya', 'name' => 'UI/UX dizayn', 'icon' => '🎨'],
            ['type' => 'IT va Texnologiya', 'name' => 'Texnologik startaplar uchun kurslar', 'icon' => '🚀'],
            ['type' => 'IT va Texnologiya', 'name' => 'Ma\'lumotlar tahlili va vizualizatsiyasi', 'icon' => '📊'],
            ['type' => 'IT va Texnologiya', 'name' => 'Sun\'iy intellekt va mashinani o\'rganish', 'icon' => '🤖'],
            ['type' => 'IT va Texnologiya', 'name' => 'Veb xavfsizligi va etikal xakerlik', 'icon' => '🛡️'],
            ['type' => 'IT va Texnologiya', 'name' => 'Internet narsalar (IoT)', 'icon' => '🌐'],
            ['type' => 'IT va Texnologiya', 'name' => 'Kvant hisoblash asoslari', 'icon' => '⚛️'],
            ['type' => 'IT va Texnologiya', 'name' => 'Virtual haqiqat (VR) va kengaytirilgan haqiqat (AR)', 'icon' => '🕶️'],
            ['type' => 'IT va Texnologiya', 'name' => 'Dasturiy ta\'minot sinovlari (Software Testing)', 'icon' => '✅'],
            ['type' => 'IT va Texnologiya', 'name' => 'Kriptovalyuta savdosi va investitsiyalari', 'icon' => '💱'],
            ['type' => 'IT va Texnologiya', 'name' => 'Texnologik loyihalarni boshqarish (Agile, Scrum)', 'icon' => '📅'],
            ['type' => 'IT va Texnologiya', 'name' => '3D chop etish (3D Printing)', 'icon' => '🖨️'],
            ['type' => 'IT va Texnologiya', 'name' => 'Yordamchi xizmat (Help Desk) tahlilchisi', 'icon' => '🛠️'],
            ['type' => 'IT va Texnologiya', 'name' => 'IT qo\'llab-quvvatlash mutaxassisi', 'icon' => '🖥️'],
            ['type' => 'IT va Texnologiya', 'name' => 'Sifatni nazorat qiluvchi testchi (QA Tester)', 'icon' => '✅'],
            ['type' => 'IT va Texnologiya', 'name' => 'Kompyuter kriminalistikasi tahlilchisi', 'icon' => '🕵️‍♂️'],
            ['type' => 'IT va Texnologiya', 'name' => 'Ma\'lumotlar tahlilchisi', 'icon' => '📊'],
            ['type' => 'IT va Texnologiya', 'name' => 'Veb dasturchi', 'icon' => '🌐'],
            ['type' => 'IT va Texnologiya', 'name' => 'Tizimlar administratori', 'icon' => '🛠️'],
            ['type' => 'IT va Texnologiya', 'name' => 'IT tadqiqotchisi', 'icon' => '🔬'],
            ['type' => 'IT va Texnologiya', 'name' => 'Ilova ishlab chiquvchi', 'icon' => '📱'],
            ['type' => 'IT va Texnologiya', 'name' => 'Xavfsizlik tahlilchisi (Cybersecurity analyst)', 'icon' => '🛡️'],
            ['type' => 'IT va Texnologiya', 'name' => 'Ma\'lumotlar bazasi administratori', 'icon' => '🗄️'],
            ['type' => 'IT va Texnologiya', 'name' => 'Biznes tahlilchisi (BI analyst)', 'icon' => '📈'],
            ['type' => 'IT va Texnologiya', 'name' => 'UX dizayneri', 'icon' => '🎨'],
            ['type' => 'IT va Texnologiya', 'name' => 'Tarmoq muhandisi', 'icon' => '🔌'],
            ['type' => 'IT va Texnologiya', 'name' => 'Dasturiy ta\'minot muhandisi', 'icon' => '💻'],
            ['type' => 'IT va Texnologiya', 'name' => 'Bulut muhandisi (Cloud Engineer)', 'icon' => '☁️'],
            ['type' => 'IT va Texnologiya', 'name' => 'IT arxitekt', 'icon' => '🏗️'],
            ['type' => 'IT va Texnologiya', 'name' => 'Dasturiy arxitekt', 'icon' => '🧩'],
            ['type' => 'IT va Texnologiya', 'name' => 'Bosh texnologiya direktori (CTO)', 'icon' => '🎯'],

            // imtihonga tayyorgarlik
            ['type' => 'Imtihonga tayyorgarlik', 'name' => 'TOEFL tayyorgarlik', 'icon' => '📝'],
            ['type' => 'Imtihonga tayyorgarlik', 'name' => 'IELTS tayyorgarlik', 'icon' => '📝'],
            ['type' => 'Imtihonga tayyorgarlik', 'name' => 'SAT tayyorgarlik', 'icon' => '📝'],
            ['type' => 'Imtihonga tayyorgarlik', 'name' => 'GRE tayyorgarlik', 'icon' => '📝'],
            ['type' => 'Imtihonga tayyorgarlik', 'name' => 'GMAT tayyorgarlik', 'icon' => '📝'],
            ['type' => 'Imtihonga tayyorgarlik', 'name' => 'Oliy ta\'limga kirish imtihonlari (O\'zbekiston)', 'icon' => '🎓'],
            ['type' => 'Imtihonga tayyorgarlik', 'name' => 'Oliy ta\'limga kirish imtihonlari (Xalqaro)', 'icon' => '🌐'],
            ['type' => 'Imtihonga tayyorgarlik', 'name' => 'Autotestga tayyorgarlik', 'icon' => '📝'],

            // bozor ko'nikmalari
            ['type' => 'Bozor ko\'nikmalari', 'name' => 'Raqamli marketing (SEO, SMM, Email Marketing)', 'icon' => '📈'],

            // 🧠 Shaxsiy rivojlanish
            ['type' => 'Shaxsiy rivojlanish', 'name' => 'Tez o\'qish (Speed Reading)', 'icon' => '📚'],
            ['type' => 'Shaxsiy rivojlanish', 'name' => 'Mantiqiy fikrlash (Logika)', 'icon' => '🧩'],
            ['type' => 'Shaxsiy rivojlanish', 'name' => 'Mental arifmetika', 'icon' => '🧮'],
            ['type' => 'Shaxsiy rivojlanish', 'name' => 'Mnemonika (Yodlash san\'ati)', 'icon' => '🧠'],
            ['type' => 'Shaxsiy rivojlanish', 'name' => 'Xotirani rivojlantirish', 'icon' => '🧠'],
            ['type' => 'Shaxsiy rivojlanish', 'name' => 'Nutq madaniyati va oratorlik', 'icon' => '🎤'],
            ['type' => 'Shaxsiy rivojlanish', 'name' => 'Psixologiya asoslari', 'icon' => '🧘'],

            // 📈 Biznes va Kasbiy yo'nalish
            ['type' => 'Biznes va Kasbiy yo\'nalish', 'name' => 'Buxgalteriya va 1C', 'icon' => '📊'],
            ['type' => 'Biznes va Kasbiy yo\'nalish', 'name' => 'Menejment va Marketing', 'icon' => '📈'],
            ['type' => 'Biznes va Kasbiy yo\'nalish', 'name' => 'Biznes asoslari', 'icon' => '💼'],
            ['type' => 'Biznes va Kasbiy yo\'nalish', 'name' => 'Startap va tadbirkorlik', 'icon' => '🚀'],
            ['type' => 'Biznes va Kasbiy yo\'nalish', 'name' => 'Moliyaviy savodxonlik', 'icon' => '💰'],
            ['type' => 'Biznes va Kasbiy yo\'nalish', 'name' => 'HR (inson resurslarini boshqarish)', 'icon' => '👥'],

            // 🎨 San'at va ijod
            ['type' => 'San\'at va ijod', 'name' => 'Musiqa (fortepiano, gitara, vokal va h.k.)', 'icon' => '🎵'],
            ['type' => 'San\'at va ijod', 'name' => 'Rassomchilik va dizayn', 'icon' => '🎨'],
            ['type' => 'San\'at va ijod', 'name' => 'Teatr va aktyorlik mahorati', 'icon' => '🎭'],
        ];

        DB::table('subjects')->insert($subjects);
    }
}


/* 
*/