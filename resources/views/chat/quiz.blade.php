<x-layout>
    <x-slot:title>Kasbga yo'naltiruvchi test</x-slot:title>

    <section class="test-container">
        <div x-data="{ sectionTitle: `Kasbga yo'naltiruvchi test`, sectionTitleText: `24 ta savolga javob bering, natijada sizga mos yo'nalish foizlarda chiqadi. (RIASEC test)` }">
            <div class="animate_top bb ze rj ki xn vq">
                <h2 x-text="sectionTitle" class="fk vj pr kk wm on/5 gq/2 bb _b"></h2>
                <p class="bb on/5 wo/5 hq" x-text="sectionTitleText"></p>
                <a href="{{route('chat.riasec')}}" style="color: blue; "> RIASEC test</a>
            </div>
        </div>
        <form id="testForm" class="test-box">
            <div id="questions"></div>

            <button type="button" class="submit-btn" onclick="calculateRIASEC()">Natijani ko'rish</button>
        </form>

        <div id="result-box" class="result-box hidden">
            <h2>Natijangiz</h2>
            <canvas id="resultChart" style="max-height: 350px;"></canvas>

            <h3 style="margin-top:20px;">AI tavsiyasi</h3>
            <div id="ai-result" class="ai-result">⏳ Hisoblanmoqda...</div>

            <button type="button" class="reset-btn" onclick="resetTest()">Testni qayta topshirish</button>
        </div>
    </section>


    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Marked.js (Markdown formatlash) -->
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <!-- DeepSeek Puter -->
    <script src="https://js.puter.com/v2/"></script>

    <script>
        // --- SAVOLLAR MASSIVI ---
        const questionsList = [
            "Mashinalar yoki mexanik qurilmalarni ayirib-yig'ish menga yoqadi.",
            "Uskunalar, asboblar bilan ishlashni xohlayman.",
            "Ochiq havoda jismoniy ish qilish yoqadi.",
            "Sport va jismoniy mashg'ulotlar menga qiziq.",
            "Murakkab masalalarni yechishni yoqtiraman.",
            "Ilmiy tajribalar haqida o'qishni yaxshi ko'raman.",
            "Kompyuterda dastur tuzish menga yoqadi.",
            "Narsalar qanday ishlashini o'rganishni yoqtiraman.",
            "Chizish yoki dizayn qilishni yaxshi ko'raman.",
            "Yangi g'oyalarni o'ylab topishni yoqtiraman.",
            "Musiqa yoki ijodiy mashg'ulotlar menga yoqadi.",
            "Ranglar va shakllar bilan ishlashni yoqtiraman.",
            "Boshqalarga yordam berish menga yoqadi.",
            "O'qituvchi bo'lishni tasavvur qila olaman.",
            "Odamlar bilan gaplashish yoqadi.",
            "Jamoada ishlash menga zavq beradi.",
            "Guruhni boshqarish menga yoqadi.",
            "Savdo qilish meni qiziqtiradi.",
            "Pul topish yo'llari haqida o'ylashni yoqtiraman.",
            "Loyihalarni boshqarishni yoqtiraman.",
            "Hujjatlar bilan ishlash menga qiziq.",
            "Tartib-intizom va qoidalarga rioya qilishni yoqtiraman.",
            "Ma'lumotlarni tizimli ravishda saqlashni afzal ko'raman.",
            "Hisobotlar tuzish va raqamlar bilan ishlash menga yoqadi."
        ];

        // RIASEC mapping
        const groups = {
            R: [0, 1, 2, 3],
            I: [4, 5, 6, 7],
            A: [8, 9, 10, 11],
            S: [12, 13, 14, 15],
            E: [16, 17, 18, 19],
            C: [20, 21, 22, 23]
        };

        // RIASEC yo'nalishlari haqida ma'lumot
        const riasecInfo = {
            R: "Realistic - Amaliy ish, texnika, sport",
            I: "Investigative - Tadqiqot, fan, tahlil",
            A: "Artistic - San'at, ijod, dizayn",
            S: "Social - Odamlar bilan ishlash, yordam berish",
            E: "Enterprising - Biznes, liderlik, tadbirkorlik",
            C: "Conventional - Tartib, hujjatlar, tizim"
        };

        // HTMLga savollarni chiqarish
        const qBox = document.getElementById("questions");
        questionsList.forEach((q, i) => {
            qBox.innerHTML += `
        <div class="question">
            <p><strong>${i + 1}.</strong> ${q}</p>
            <div class="radio-group">
                <label class="radio-label">
                    <input type="radio" name="q${i}" value="1">
                    <span>Ha</span>
                </label>
                <label class="radio-label">
                    <input type="radio" name="q${i}" value="0">
                    <span>Yo'q</span>
                </label>
            </div>
        </div>`;
        });

        let chart = null;

        // ————— TEST HISOBLASH —————
        function calculateRIASEC() {
            // Barcha savollarga javob berilganini tekshirish
            let allAnswered = true;
            for (let i = 0; i < questionsList.length; i++) {
                if (!document.querySelector(`input[name="q${i}"]:checked`)) {
                    allAnswered = false;
                    break;
                }
            }

            if (!allAnswered) {
                alert("⚠️ Iltimos, barcha savollarga javob bering!");
                return;
            }

            let scores = {
                R: 0,
                I: 0,
                A: 0,
                S: 0,
                E: 0,
                C: 0
            };

            // Har bir yo'nalikni hisoblash
            for (let type in groups) {
                groups[type].forEach(i => {
                    let v = document.querySelector(`input[name="q${i}"]:checked`);
                    if (v) scores[type] += parseInt(v.value);
                });
            }

            // Foizga o'tkazish
            let resultPercent = {
                R: (scores.R / 4) * 100,
                I: (scores.I / 4) * 100,
                A: (scores.A / 4) * 100,
                S: (scores.S / 4) * 100,
                E: (scores.E / 4) * 100,
                C: (scores.C / 4) * 100
            };

            // Grafikni chiqarish
            document.getElementById("result-box").classList.remove("hidden");
            document.getElementById("result-box").scrollIntoView({
                behavior: 'smooth'
            });
            drawChart(resultPercent);

            // AI dan maslahat so'rash
            askAI(resultPercent);
        }

        // ————— DIAGRAMMA CHIZISH —————
        function drawChart(data) {
            const ctx = document.getElementById("resultChart");

            if (chart) chart.destroy();

            // Ranglar va gradient
            const colors = [
                'rgba(239, 68, 68, 0.8)', // R - qizil
                'rgba(59, 130, 246, 0.8)', // I - ko'k
                'rgba(168, 85, 247, 0.8)', // A - binafsha
                'rgba(34, 197, 94, 0.8)', // S - yashil
                'rgba(249, 115, 22, 0.8)', // E - to'q sariq
                'rgba(107, 114, 128, 0.8)' // C - kulrang
            ];

            chart = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: [
                        "Realistic (R)\nAmaliy",
                        "Investigative (I)\nTadqiqot",
                        "Artistic (A)\nIjod",
                        "Social (S)\nIjtimoiy",
                        "Enterprising (E)\nTadbirkorlik",
                        "Conventional (C)\nTartib"
                    ],
                    datasets: [{
                        label: "Foiz",
                        data: [data.R, data.I, data.A, data.S, data.E, data.C],
                        backgroundColor: colors,
                        borderColor: colors.map(c => c.replace('0.8', '1')),
                        borderWidth: 2,
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.parsed.y.toFixed(0) + '%';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            ticks: {
                                callback: function(value) {
                                    return value + '%';
                                }
                            }
                        },
                        x: {
                            ticks: {
                                font: {
                                    size: 11
                                }
                            }
                        }
                    }
                }
            });
        }

        // ————— AI TAVSIYASI —————
        async function askAI(result) {
            const aiResultDiv = document.getElementById("ai-result");
            aiResultDiv.innerHTML = "⏳ Suniy intellekt tahlil qilmoqda...";

            // Eng yuqori 3 yo'nalishni topish
            const sorted = Object.entries(result)
                .sort((a, b) => b[1] - a[1])
                .slice(0, 3);

            const prompt = `Siz kasbga yo'naltirish bo'yicha professional maslahatchi sifatida ishlayapsiz.

Quyidagi RIASEC test natijalariga asoslanib, talabaga to'liq va batafsil kasb tanlash bo'yicha maslahat bering:

**Test natijalari:**
- Realistic (Amaliy): ${result.R}%
- Investigative (Tadqiqot): ${result.I}%
- Artistic (Ijod): ${result.A}%
- Social (Ijtimoiy): ${result.S}%
- Enterprising (Tadbirkorlik): ${result.E}%
- Conventional (Tartib): ${result.C}%

**Eng yuqori 3 yo'nalish:**
1. ${riasecInfo[sorted[0][0]]} - ${sorted[0][1]}%
2. ${riasecInfo[sorted[1][0]]} - ${sorted[1][1]}%
3. ${riasecInfo[sorted[2][0]]} - ${sorted[2][1]}%

Quyidagi formatda javob bering:

## 📊 Natija tahlili
[Qisqacha natijani tahlil qiling]

## 💼 Tavsiya etilgan kasblar
[5-7 ta aniq kasb nomlari va qisqacha tavsif]

## 🎓 Ta'lim yo'nalishlari
[Qaysi universitetlarda o'qish mumkin]

## ⭐ Kuchli tomonlaringiz
[3-4 ta kuchli tomon]

## 📈 Rivojlantirish kerak bo'lgan sohalar
[2-3 ta tavsiya]

Javobingiz o'zbek tilida, oddiy va tushunarli bo'lsin.`;

            try {
                let fullResponse = "";
                const response = await puter.ai.chat(prompt, {
                    model: "deepseek/deepseek-r1",
                    stream: true
                });

                aiResultDiv.innerHTML = "";

                for await (const part of response) {
                    if (part.text) {
                        fullResponse += part.text;
                        // Markdown ni HTML ga o'girish
                        aiResultDiv.innerHTML = marked.parse(fullResponse);
                    }
                }
            } catch (error) {
                console.error('AI xato:', error);
                aiResultDiv.innerHTML = `
                    <div style="color: #dc2626; padding: 1rem; background: #fee2e2; border-radius: 8px;">
                        ❌ Xatolik yuz berdi. Iltimos, qaytadan urinib ko'ring.
                    </div>`;
            }
        }

        // ————— TESTNI QAYTA BOSHLASH —————
        function resetTest() {
            // Barcha radiobutton tanlovlarini tozalash
            document.querySelectorAll('input[type="radio"]').forEach(input => {
                input.checked = false;
            });

            // Natijalar qismini yashirish
            document.getElementById("result-box").classList.add("hidden");

            // Grafikkni yo'q qilish
            if (chart) {
                chart.destroy();
                chart = null;
            }

            // Tepaga scroll qilish
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }
    </script>


    <style>
        * {
            box-sizing: border-box;
        }

        .test-container {
            max-width: 850px;
            margin: 5rem auto;
            padding: 20px;
        }

        .title {
            font-size: 36px;
            font-weight: bold;
            text-align: center;
            color: #1f2937;
            margin-bottom: 10px;
        }

        .subtitle {
            text-align: center;
            margin-bottom: 30px;
            color: #6b7280;
            font-size: 16px;
            line-height: 1.6;
        }

        .test-box {
            background: white;
            padding: 30px;
            border-radius: 16px;
            margin-top: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .question {
            margin-bottom: 20px;
            padding: 20px;
            background: #f9fafb;
            border-radius: 12px;
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .question:hover {
            background: #f3f4f6;
            border-color: #e5e7eb;
        }

        .question p {
            margin-bottom: 12px;
            color: #374151;
            font-size: 16px;
            line-height: 1.5;
        }

        .radio-group {
            display: flex;
            gap: 15px;
        }

        .radio-label {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            padding: 8px 16px;
            border-radius: 8px;
            background: white;
            border: 2px solid #e5e7eb;
            transition: all 0.2s ease;
        }

        .radio-label:hover {
            border-color: #3b82f6;
            background: #eff6ff;
        }

        .radio-label input[type="radio"] {
            cursor: pointer;
            width: 18px;
            height: 18px;
        }

        .radio-label input[type="radio"]:checked {
            accent-color: #3b82f6;
        }

        .radio-label span {
            font-weight: 500;
            color: #374151;
        }

        .submit-btn,
        .reset-btn {
            width: 100%;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            padding: 16px;
            border: none;
            border-radius: 12px;
            color: white;
            font-weight: bold;
            cursor: pointer;
            font-size: 18px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        }

        .submit-btn:hover,
        .reset-btn:hover {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
        }

        .reset-btn {
            margin-top: 20px;
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
            box-shadow: 0 4px 12px rgba(107, 114, 128, 0.3);
        }

        .reset-btn:hover {
            background: linear-gradient(135deg, #4b5563 0%, #374151 100%);
        }

        .result-box {
            margin-top: 40px;
            padding: 30px;
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .result-box h2 {
            text-align: center;
            color: #1f2937;
            font-size: 28px;
            margin-bottom: 20px;
        }

        .result-box h3 {
            color: #1f2937;
            font-size: 22px;
            margin-top: 30px;
            margin-bottom: 15px;
        }

        .hidden {
            display: none;
        }

        .ai-result {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            line-height: 1.8;
            color: #374151;
        }

        /* Markdown formatlash uchun */
        .ai-result h2 {
            color: #1f2937;
            font-size: 22px;
            margin-top: 20px;
            margin-bottom: 15px;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 8px;
        }

        .ai-result h3 {
            color: #374151;
            font-size: 18px;
            margin-top: 15px;
            margin-bottom: 10px;
        }

        .ai-result ul,
        .ai-result ol {
            margin-left: 20px;
            margin-top: 10px;
            margin-bottom: 15px;
        }

        .ai-result li {
            margin-bottom: 8px;
            line-height: 1.6;
        }

        .ai-result p {
            margin-bottom: 12px;
        }

        .ai-result strong {
            color: #1f2937;
            font-weight: 600;
        }

        .ai-result code {
            background: #f3f4f6;
            padding: 2px 6px;
            border-radius: 4px;
            font-family: monospace;
            color: #dc2626;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .test-container {
                padding: 15px;
            }

            .title {
                font-size: 28px;
            }

            .test-box {
                padding: 20px;
            }

            .question {
                padding: 15px;
            }

            .radio-group {
                flex-direction: column;
            }

            .radio-label {
                width: 100%;
            }
        }
    </style>

</x-layout>
