<x-layout>
    <x-slot:title>Kasbga yo'naltiruvchi test</x-slot:title>
    <style>
        .main {
            max-width: 900px;
            margin: auto;
            margin-top: 5rem;
            padding: 20px;
        }

        section {
            padding: 20px 25px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        section h2 {
            margin-top: 0;
        }

        section p {
            line-height: 1.6;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 15px;
        }

        .card {
            padding: 15px 20px;
            border-radius: 10px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 18px rgba(77, 75, 75, 0.1);
        }

        .card h3 {
            margin-top: 0;
        }

        .card p {
            margin-bottom: 0;
        }
    </style>

    <main class="main">
        <section>
            <h2>RIASEC testi nima?</h2>
            <p>
                RIASEC testi — bu odamning qaysi kasb yo‘nalishiga ko‘proq mos kelishini aniqlash uchun ishlatiladigan
                psixologik testdir.
                U John Holland tomonidan ishlab chiqilgan va dunyo bo‘yicha millionlab odamlar tomonidan qo‘llanadi.
            </p>
        </section>

        <section>
            <h2>RIASEC harflari va yo‘nalishlari</h2>
            <div class="grid">
                <div class="card">
                    <h3>R – Realistic (Texnika, jismoniy ish)</h3>
                    <p>Texnika, mexanika, sport va jismoniy ishlar bilan shug‘ullanishni yoqtiradiganlar uchun. Misol:
                        muhandis, quruvchi, elektrik.</p>
                </div>
                <div class="card">
                    <h3>I – Investigative (Ilmiy, tahliliy)</h3>
                    <p>Ilmiy tadqiqotlar, mantiqiy masalalar, IT va kod yozishni yoqtiradiganlar uchun. Misol:
                        dasturchi,
                        ilmiy tadqiqotchi.</p>
                </div>
                <div class="card">
                    <h3>A – Artistic (Ijodiy, san’at)</h3>
                    <p>San’at, dizayn, musiqiy yoki ijodiy mashg‘ulotlarni yoqtiradiganlar uchun. Misol: rassom,
                        dizayner,
                        arxitektor.</p>
                </div>
                <div class="card">
                    <h3>S – Social (Ijtimoiy, yordam)</h3>
                    <p>Odamlarga yordam berish va ularga ta’lim berishni yoqtiradiganlar uchun. Misol: o‘qituvchi,
                        shifokor,
                        psixolog.</p>
                </div>
                <div class="card">
                    <h3>E – Enterprising (Tadbirkor, rahbar)</h3>
                    <p>Biznes, liderlik, strategik qarorlar qabul qilishni yoqtiradiganlar uchun. Misol: menejer,
                        biznesmen,
                        marketolog.</p>
                </div>
                <div class="card">
                    <h3>C – Conventional (An’anaviy, tizimli)</h3>
                    <p>Tizimli ishlar, hujjatlar, hisob-kitob va ma’lumotlarni boshqarishni yoqtiradiganlar uchun.
                        Misol:
                        buxgalter, arxivchi.</p>
                </div>
            </div>
        </section>

        <section>
            <h2>RIASEC testi qanday ishlaydi?</h2>
            <p>
                Test odatda 20–60 ta “Ha/Yo‘q” savollardan iborat bo‘ladi.
                Savollar orqali sizning qaysi yo‘nalishga qiziqishingiz aniqlanadi.
                Natijada sizga mos keladigan kasblar va kuchli tomonlaringizni ko‘rasiz.
            </p>
        </section>

        <section>
            <h2>Testdan foyda</h2>
            <p>
                RIASEC testi yordamida siz:
            </p>
            <ul>
                <li>O‘z qiziqishlaringizni aniqlaysiz</li>
                <li>Kuchli va zaif tomonlaringizni bilib olasiz</li>
                <li>Kelajakdagi kasb tanlashingizni osonlashtirasiz</li>
                <li>Shaxsiy va kasbiy rivojlanishingizga yo‘l ochasiz</li>
            </ul>
        </section>
    </main>


</x-layout>
