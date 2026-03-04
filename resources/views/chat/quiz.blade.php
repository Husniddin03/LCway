<x-layout>
    <x-slot:title>Kasbga yo'naltiruvchi test</x-slot:title>

    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
        <div class="max-w-4xl mx-auto px-6">

            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">
                    Kasbga yo'naltiruvchi test
                </h1>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
                    24 ta savolga javob bering, natijada sizga mos yo'nalish foizlarda chiqadi. (RIASEC test)
                </p>
            </div>

            <!-- Test Form -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 mb-8">
                <form id="testForm" class="space-y-6">
                    <div id="questions" class="space-y-6"></div>

                    <div class="flex justify-center pt-6">
                        <button type="button" onclick="calculateRIASEC()"
                            class="bg-primary-600 hover:bg-primary-700 text-white font-semibold px-8 py-3 rounded-lg transition-colors duration-200 flex items-center space-x-2 shadow-lg hover:shadow-xl transform hover:scale-105">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            <span>Natijani ko'rish</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Result Section -->
            <div id="result-box" class="hidden bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6 text-center">Natijangiz</h2>

                <!-- Chart -->
                <div class="mb-8 flex justify-center">
                    <div class="w-full max-w-2xl" style="height:350px;">
                        <canvas id="resultChart"></canvas>
                    </div>
                </div>

                <!-- AI Tavsiya -->
                <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-6">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                        AI tavsiyasi
                    </h3>
                    <div id="ai-result"></div>
                </div>

                <div class="flex justify-center mt-6">
                    <button type="button" onclick="resetTest()"
                        class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-white font-semibold px-6 py-3 rounded-lg transition-colors duration-200 flex items-center space-x-2 shadow hover:shadow-md transform hover:scale-105">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        <span>Testni qayta topshirish</span>
                    </button>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

    <script>
    // ───────────────────────────────────────────────
    // SAVOLLAR
    // ───────────────────────────────────────────────
    const questionsList = [
        { text: "Mashinalar yoki mexanik qurilmalarni ayirib-yig'ish menga yoqadi.", category: "R" },
        { text: "Uskunalar, asboblar bilan ishlashni xohlayman.", category: "R" },
        { text: "Ochiq havoda jismoniy ish qilish yoqadi.", category: "R" },
        { text: "Sport va jismoniy mashg'ulotlar menga qiziq.", category: "R" },
        { text: "Murakkab masalalarni yechishni yoqtiraman.", category: "I" },
        { text: "Ilmiy tajribalar haqida o'qishni yaxshi ko'raman.", category: "I" },
        { text: "Kompyuterda dastur tuzish menga yoqadi.", category: "I" },
        { text: "Narsalar qanday ishlashini o'rganishni yoqtiraman.", category: "I" },
        { text: "Chizish yoki dizayn qilishni yaxshi ko'raman.", category: "A" },
        { text: "Yangi g'oyalarni o'ylab topishni yoqtiraman.", category: "A" },
        { text: "Musiqa yoki ijodiy mashg'ulotlar menga yoqadi.", category: "A" },
        { text: "Odamlar bilan gaplashishni yoqtiraman.", category: "S" },
        { text: "Jamoa ishida ishlashni afzal ko'raman.", category: "S" },
        { text: "Boshqalarga yordam berishdan zavq olaman.", category: "S" },
        { text: "Boshqalarni o'qitish yoki tushuntirishni yoqtiraman.", category: "S" },
        { text: "Boshqalarni boshqarishni yoqtiraman.", category: "E" },
        { text: "Tashkilot ishlarida ishtirok etishni yoqtiraman.", category: "E" },
        { text: "Savdo-sotiq bilan shug'ullanishni yoqtiraman.", category: "E" },
        { text: "Biznes boshlashni xohlayman.", category: "E" },
        { text: "Rahbarlik qilishni yoqtiraman.", category: "E" },
        { text: "Ma'lumotlarni tartibli saqlashni yoqtiraman.", category: "C" },
        { text: "Hujjatlar va hisobotlar bilan ishlashni yoqtiraman.", category: "C" },
        { text: "Qoidalar va tartibga rioya qilishni yoqtiraman.", category: "C" },
        { text: "Mas'uliyatni olishdan qo'rqmayman.", category: "C" }
    ];

    const SCORES = { "Umuman yoqmaydi": 1, "Yoqmaydi": 2, "Neytral": 3, "Yoqadi": 4, "Juda yoqadi": 5 };

    const CATEGORY_LABELS = {
        R: "Realistic (R) Amaliy",
        I: "Investigative (I) Tadqiqot",
        A: "Artistic (A) Ijod",
        S: "Social (S) Ijtimoiy",
        E: "Enterprising (E) Tadbirkorlik",
        C: "Conventional (C) Tartib"
    };

    let answers = {};
    let chartInstance = null;

    // ───────────────────────────────────────────────
    // SAVOLLARNI YUKLASH
    // ───────────────────────────────────────────────
    function loadQuestions() {
        const container = document.getElementById('questions');
        container.innerHTML = '';
        questionsList.forEach((q, i) => {
            const div = document.createElement('div');
            div.className = 'bg-gray-50 dark:bg-gray-700 rounded-xl p-6';
            div.innerHTML = `
                <div class="flex items-start space-x-3">
                    <span class="flex-shrink-0 w-8 h-8 bg-primary-600 text-white rounded-full flex items-center justify-center font-semibold text-sm">${i + 1}</span>
                    <div class="flex-1">
                        <p class="text-gray-900 dark:text-white font-medium mb-4">${q.text}</p>
                        <div class="flex flex-wrap gap-2">
                            ${Object.keys(SCORES).map(label => `
                                <label class="flex items-center space-x-2 cursor-pointer bg-white dark:bg-gray-600 hover:bg-primary-50 dark:hover:bg-primary-900/30 border border-gray-200 dark:border-gray-500 hover:border-primary-400 px-3 py-2 rounded-lg transition-all">
                                    <input type="radio" name="q${i}" value="${label}" class="w-4 h-4 text-primary-600 hidden">
                                    <span class="text-sm text-gray-700 dark:text-gray-200">${label}</span>
                                </label>
                            `).join('')}
                        </div>
                    </div>
                </div>
            `;
            container.appendChild(div);
        });

        // Radio tanlaganda label rangi o'zgarsin
        document.querySelectorAll('input[type=radio]').forEach(radio => {
            radio.addEventListener('change', () => {
                const name = radio.name;
                document.querySelectorAll(`input[name="${name}"]`).forEach(r => {
                    r.closest('label').classList.remove('bg-primary-100', 'dark:bg-primary-800', 'border-primary-500');
                    r.closest('label').classList.add('bg-white', 'dark:bg-gray-600', 'border-gray-200', 'dark:border-gray-500');
                });
                radio.closest('label').classList.remove('bg-white', 'dark:bg-gray-600', 'border-gray-200', 'dark:border-gray-500');
                radio.closest('label').classList.add('bg-primary-100', 'dark:bg-primary-800', 'border-primary-500');
            });
        });
    }

    // ───────────────────────────────────────────────
    // NATIJANI HISOBLASH
    // ───────────────────────────────────────────────
    function calculateRIASEC() {
        answers = {};
        for (let i = 0; i < questionsList.length; i++) {
            const sel = document.querySelector(`input[name="q${i}"]:checked`);
            if (!sel) {
                showNotification(`${i + 1}-savolga javob bering!`, 'warning');
                document.querySelectorAll('.bg-gray-50, .dark\\:bg-gray-700')[i]?.scrollIntoView({ behavior: 'smooth', block: 'center' });
                return;
            }
            answers[i] = sel.value;
        }

        // Har bir kategoriya uchun umumiy ball (max = 4 savol × 5 = 20)
        const totals = { R: 0, I: 0, A: 0, S: 0, E: 0, C: 0 };
        const counts = { R: 0, I: 0, A: 0, S: 0, E: 0, C: 0 };

        questionsList.forEach((q, i) => {
            totals[q.category] += SCORES[answers[i]];
            counts[q.category]++;
        });

        // Foizga o'tkazish
        const percentages = {};
        Object.keys(totals).forEach(cat => {
            percentages[cat] = Math.round((totals[cat] / (counts[cat] * 5)) * 100);
        });

        showResults(percentages);
    }

    // ───────────────────────────────────────────────
    // NATIJALARNI KO'RSATISH
    // ───────────────────────────────────────────────
    function showResults(percentages) {
        window.lastPercentages = percentages;
        document.getElementById('result-box').classList.remove('hidden');
        document.getElementById('result-box').scrollIntoView({ behavior: 'smooth' });

        // Eski chartni yo'qot
        if (chartInstance) { chartInstance.destroy(); chartInstance = null; }

        createChart(percentages);
        getAIRecommendation(percentages);
    }

    // ───────────────────────────────────────────────
    // GRAFIK
    // ───────────────────────────────────────────────
    function createChart(percentages) {
        const ctx = document.getElementById('resultChart').getContext('2d');
        chartInstance = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: Object.keys(percentages).map(k => CATEGORY_LABELS[k]),
                datasets: [{
                    label: 'Foiz (%)',
                    data: Object.values(percentages),
                    backgroundColor: [
                        'rgba(59,130,246,0.8)',
                        'rgba(168,85,247,0.8)',
                        'rgba(34,197,94,0.8)',
                        'rgba(249,115,22,0.8)',
                        'rgba(234,179,8,0.8)',
                        'rgba(107,114,128,0.8)'
                    ],
                    borderColor: [
                        'rgba(59,130,246,1)',
                        'rgba(168,85,247,1)',
                        'rgba(34,197,94,1)',
                        'rgba(249,115,22,1)',
                        'rgba(234,179,8,1)',
                        'rgba(107,114,128,1)'
                    ],
                    borderWidth: 2,
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: { callback: v => v + '%' }
                    }
                },
                plugins: { legend: { display: false } }
            }
        });
    }

    // ───────────────────────────────────────────────
    // AI TAVSIYA — Anthropic API + JSON
    // ───────────────────────────────────────────────
    async function getAIRecommendation(percentages) {
        const aiResult = document.getElementById('ai-result');

        aiResult.innerHTML = `
            <div class="flex flex-col items-center justify-center py-12 space-y-4">
                <div class="relative">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-primary-600"></div>
                    <div class="absolute inset-0 rounded-full border-2 border-primary-200 animate-pulse"></div>
                </div>
                <p class="text-gray-600 dark:text-gray-400 font-medium">AI tavsiyasini tayyorlamoqda...</p>
            </div>
        `;

        // AIga yuboriladigan JSON
        const payload = {
            riasec_scores: percentages,
            category_names: CATEGORY_LABELS,
            questions_and_answers: questionsList.map((q, i) => ({
                question: q.text,
                category: q.category,
                answer: answers[i],
                score: SCORES[answers[i]]
            }))
        };

        const prompt = `
Quyidagi RIASEC test natijalari JSON formatida berilgan:

\`\`\`json
${JSON.stringify(payload, null, 2)}
\`\`\`

Ushbu natijalar asosida o'zbek tilida quyidagilarni yoz:

## 📊 Natija tahlili
Eng yuqori 3 ta kategoriyani foizlari bilan tushuntir. Nima ma'nosi borligini ayt.

## 💼 Tavsiya etilgan kasblar
Natijaga mos 5–7 ta kasbni ro'yxatla. Har biri uchun 1 qator izoh.

## 🎓 O'qish yo'nalishlari
Universitetda qaysi yo'nalishlarni tanlash kerak — 4–5 ta tavsiya.

## 🚀 Kelajak istiqbollari
Bu yo'nalishlardagi ish imkoniyatlari va daromad haqida qisqacha.

## 💡 Shaxsiy maslahatlar
Foydalanuvchiga mos 3 ta amaliy maslahat.

Javobni markdown formatida, o'zbek tilida yoz.
        `.trim();

        try {
            const response = await fetch("https://api.anthropic.com/v1/messages", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "anthropic-dangerous-direct-browser-access": "true"
                },
                body: JSON.stringify({
                    model: "claude-sonnet-4-20250514",
                    max_tokens: 1500,
                    messages: [{ role: "user", content: prompt }]
                })
            });

            if (!response.ok) throw new Error(`HTTP ${response.status}`);

            const data = await response.json();
            const text = data.content.map(c => c.text || '').join('\n');

            aiResult.innerHTML = `
                <div class="bg-gradient-to-r from-primary-50 to-blue-50 dark:from-primary-900/20 dark:to-blue-900/20 rounded-xl p-6 border border-primary-200 dark:border-primary-800">
                    <div class="flex items-center space-x-2 mb-4">
                        <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                        <span class="font-semibold text-primary-900 dark:text-primary-100">AI tomonidan tayyorlandi</span>
                    </div>
                    <div class="prose prose-gray dark:prose-invert max-w-none ai-content">
                        ${marked.parse(text)}
                    </div>
                </div>
                <div class="flex justify-center mt-4">
                    <button onclick="copyResults()" class="flex items-center space-x-2 text-sm text-gray-500 hover:text-primary-600 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        <span>Natijalarni nusxalash</span>
                    </button>
                </div>
            `;

        } catch (err) {
            console.error(err);
            aiResult.innerHTML = `
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-6">
                    <p class="text-red-700 dark:text-red-300 font-medium mb-2">❌ AI xizmati ishlamayapti</p>
                    <p class="text-red-600 dark:text-red-400 text-sm mb-4">${err.message}</p>
                    <button onclick="retryAI()" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                        Qayta urinish
                    </button>
                </div>
            `;
        }
    }

    function retryAI() {
        if (window.lastPercentages) getAIRecommendation(window.lastPercentages);
    }

    function copyResults() {
        navigator.clipboard.writeText(document.getElementById('ai-result').innerText)
            .then(() => showNotification('Nusxalandi!', 'success'))
            .catch(() => showNotification('Xatolik!', 'error'));
    }

    function resetTest() {
        document.getElementById('testForm').reset();
        document.getElementById('result-box').classList.add('hidden');
        answers = {};
        document.querySelectorAll('label').forEach(l => {
            l.classList.remove('bg-primary-100', 'dark:bg-primary-800', 'border-primary-500');
            l.classList.add('bg-white', 'dark:bg-gray-600', 'border-gray-200');
        });
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function showNotification(message, type = 'info') {
        const colors = { info: 'bg-blue-500', warning: 'bg-yellow-500', error: 'bg-red-500', success: 'bg-green-500' };
        const n = document.createElement('div');
        n.className = `fixed top-4 right-4 z-50 px-5 py-3 rounded-xl shadow-lg text-white font-medium transform transition-all duration-300 translate-x-full ${colors[type]}`;
        n.textContent = message;
        document.body.appendChild(n);
        setTimeout(() => n.classList.remove('translate-x-full'), 100);
        setTimeout(() => { n.classList.add('translate-x-full'); setTimeout(() => n.remove(), 300); }, 3000);
    }

    document.addEventListener('DOMContentLoaded', loadQuestions);
    </script>

    <style>
        .ai-content h1, .ai-content h2, .ai-content h3 { font-weight: 700; margin: 1rem 0 0.5rem; }
        .ai-content h2 { font-size: 1.2rem; color: #4f46e5; }
        .ai-content h3 { font-size: 1rem; }
        .ai-content p { margin-bottom: 0.6rem; line-height: 1.7; }
        .ai-content ul { margin-left: 1.5rem; margin-bottom: 0.75rem; }
        .ai-content li { margin-bottom: 0.3rem; }
        .ai-content strong { color: #4f46e5; }
        @media (prefers-color-scheme: dark) {
            .ai-content h2 { color: #818cf8; }
            .ai-content strong { color: #818cf8; }
        }
    </style>
</x-layout>