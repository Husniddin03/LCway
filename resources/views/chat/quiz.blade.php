<x-layout>
<x-slot:title>Kasbga yo'naltiruvchi test — RIASEC</x-slot:title>

<style>
.ai-response-box h2 { color: #f1f5f9; font-size: 1rem; margin: .8rem 0 .4rem; border-bottom: 1px solid #475569; padding-bottom: .4rem; }
.ai-response-box h3 { color: #94a3b8; font-size: .88rem; margin: .6rem 0 .3rem; }
.ai-response-box ul,.ai-response-box ol { margin-left: 1.2rem; margin-top: .3rem; }
.ai-response-box li { margin-bottom: .3rem; }
.ai-response-box p { margin-bottom: .5rem; }
.ai-response-box strong { color: #f1f5f9; }
.ai-response-box code { background:rgba(255,255,255,.06); padding:1px 5px; border-radius:4px; font-family:'JetBrains Mono',monospace; font-size:.8rem; color:#a5c8ff; }

/* Light mode styles */
.light-mode .bg-slate-950 { background-color: #ffffff !important; }
.light-mode .bg-slate-800 { background-color: #f8fafc !important; }
.light-mode .bg-slate-900 { background-color: #ffffff !important; }
.light-mode .bg-slate-700\/10 { background-color: rgba(241,245,249,0.1) !important; }
.light-mode .bg-slate-700\/30 { background-color: rgba(241,245,249,0.3) !important; }
.light-mode .bg-slate-800\/50 { background-color: rgba(248,250,252,0.5) !important; }

.light-mode .text-slate-300 { color: #475569 !important; }
.light-mode .text-slate-100 { color: #1e293b !important; }
.light-mode .text-slate-500 { color: #64748b !important; }
.light-mode .text-slate-400 { color: #64748b !important; }

.light-mode .border-slate-700 { border-color: #e2e8f0 !important; }
.light-mode .border-slate-600 { border-color: #cbd5e1 !important; }
.light-mode .border-slate-500\/20 { border-color: rgba(59,130,246,0.2) !important; }

.light-mode .bg-blue-500\/10 { background-color: rgba(59,130,246,0.1) !important; }
.light-mode .bg-blue-500\/20 { background-color: rgba(59,130,246,0.2) !important; }
.light-mode .text-blue-500 { color: #3b82f6 !important; }
.light-mode .border-blue-500\/22 { border-color: rgba(59,130,246,0.22) !important; }
.light-mode .border-blue-500 { border-color: #3b82f6 !important; }

.light-mode .bg-emerald-500\/15 { background-color: rgba(16,185,129,0.15) !important; }
.light-mode .text-emerald-500 { color: #10b981 !important; }

.light-mode .bg-red-500\/8 { background-color: rgba(239,68,68,0.08) !important; }
.light-mode .border-red-500\/15 { border-color: rgba(239,68,68,0.15) !important; }
.light-mode .text-red-400 { color: #ef4444 !important; }

.light-mode .bg-gradient-to-r { 
    background: linear-gradient(135deg, #3b82f6, #8b5cf6) !important;
}

/* ═══════════════════════════════════════════
   THEME MANAGEMENT
═══════════════════════════════════════════ */
function initTheme() {
    const container = document.getElementById('quiz-container');
    const saved = localStorage.getItem('quiz-theme');
    
    // Check if user has saved preference
    if (saved === 'light') {
        container.classList.remove('dark-mode');
        container.classList.add('light-mode');
    } else {
        container.classList.remove('light-mode');
        container.classList.add('dark-mode');
        localStorage.setItem('quiz-theme', 'dark'); // default to dark
    }
}

function toggleTheme() {
    const container = document.getElementById('quiz-container');
    const isDark = container.classList.contains('dark-mode');
    
    if (isDark) {
        container.classList.remove('dark-mode');
        container.classList.add('light-mode');
        localStorage.setItem('quiz-theme', 'light');
    } else {
        container.classList.remove('light-mode');
        container.classList.add('dark-mode');
        localStorage.setItem('quiz-theme', 'dark');
    }
}

// Add theme toggle button
function addThemeToggle() {
    const hero = document.querySelector('.text-center.animate-fade-in');
    if (!hero) return;
    
    const toggleBtn = document.createElement('button');
    toggleBtn.className = 'fixed top-6 right-6 w-10 h-10 rounded-lg bg-slate-700/50 border border-slate-600 flex items-center justify-center transition-all duration-200 hover:bg-slate-600/50 hover:border-slate-500 z-50';
    toggleBtn.onclick = toggleTheme;
    toggleBtn.title = 'Tungi/Kunduzgi rejim';
    toggleBtn.innerHTML = `
        <svg class="w-5 h-5 text-slate-300 dark-mode-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
        </svg>
        <svg class="w-5 h-5 text-slate-300 light-mode-icon hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
        </svg>
    `;
    
    document.body.appendChild(toggleBtn);
    updateThemeIcon();
}

function updateThemeIcon() {
    const container = document.getElementById('quiz-container');
    const darkIcon = document.querySelector('.dark-mode-icon');
    const lightIcon = document.querySelector('.light-mode-icon');
    
    if (container.classList.contains('dark-mode')) {
        darkIcon?.classList.remove('hidden');
        lightIcon?.classList.add('hidden');
    } else {
        darkIcon?.classList.add('hidden');
        lightIcon?.classList.remove('hidden');
    }
}

// Override the original toggleTheme function to also update icon
const originalToggleTheme = toggleTheme;
toggleTheme = function() {
    originalToggleTheme();
    updateThemeIcon();
}

/* Dark mode - default (slate colors already work) */
.dark-mode .ai-response-box h2 { color: #f1f5f9; }
.dark-mode .ai-response-box h3 { color: #94a3b8; }
.dark-mode .ai-response-box strong { color: #f1f5f9; }
.dark-mode .ai-response-box code { color: #a5c8ff; }
</style>


<div class="font-sans bg-slate-950 min-h-screen p-4 md:p-8 relative overflow-x-hidden dark-mode" id="quiz-container">
    <!-- Orbs -->
    <div class="fixed w-[500px] h-[500px] rounded-full pointer-events-none z-0 blur-[80px] opacity-35 bg-gradient-to-r from-blue-600 to-transparent -top-48 -left-24"></div>
    <div class="fixed w-[400px] h-[400px] rounded-full pointer-events-none z-0 blur-[80px] opacity-35 bg-gradient-to-r from-purple-600 to-transparent -bottom-24 -right-20"></div>

    <div class="max-w-4xl mx-auto relative z-10 flex flex-col gap-8">

        <!-- Hero -->
        <div class="text-center animate-fade-in">
            <a href="{{ route('chat.riasec') }}" class="inline-block">
                <div class="inline-block text-xs font-bold tracking-widest uppercase text-blue-500 bg-blue-500/10 border border-blue-500/25 rounded-full px-3 py-1 mb-4 hover:bg-blue-500/20 transition-colors">
                    RIASEC Test
                </div>
            </a>
            <h1 class="text-3xl md:text-5xl font-black text-slate-100 leading-tight mb-3">
                Kasbga yo'naltiruvchi<br>psixologik test
            </h1>
            <p class="text-sm text-slate-400 max-w-lg mx-auto leading-relaxed">
                24 ta savolga «Ha» yoki «Yo'q» deb javob bering. Natijada sizga eng mos yo'nalishlar foizlarda chiqadi.
            </p>
        </div>

        <!-- Legend -->
        <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
            <div class="bg-slate-800 border border-slate-700 rounded-lg p-3 flex items-center gap-2 text-xs animate-fade-in" style="animation-delay:.05s">
                <div class="w-2.5 h-2.5 bg-red-400 rounded-full flex-shrink-0"></div>
                <div>
                    <strong class="block text-slate-100 text-[11px]">R — Realistic</strong>
                    <span class="text-slate-400">Amaliy, texnika, sport</span>
                </div>
            </div>
            <div class="bg-slate-800 border border-slate-700 rounded-lg p-3 flex items-center gap-2 text-xs animate-fade-in" style="animation-delay:.1s">
                <div class="w-2.5 h-2.5 bg-blue-500 rounded-full flex-shrink-0"></div>
                <div>
                    <strong class="block text-slate-100 text-[11px]">I — Investigative</strong>
                    <span class="text-slate-400">Tadqiqot, fan, tahlil</span>
                </div>
            </div>
            <div class="bg-slate-800 border border-slate-700 rounded-lg p-3 flex items-center gap-2 text-xs animate-fade-in" style="animation-delay:.15s">
                <div class="w-2.5 h-2.5 bg-purple-400 rounded-full flex-shrink-0"></div>
                <div>
                    <strong class="block text-slate-100 text-[11px]">A — Artistic</strong>
                    <span class="text-slate-400">San'at, ijod, dizayn</span>
                </div>
            </div>
            <div class="bg-slate-800 border border-slate-700 rounded-lg p-3 flex items-center gap-2 text-xs animate-fade-in" style="animation-delay:.2s">
                <div class="w-2.5 h-2.5 bg-emerald-400 rounded-full flex-shrink-0"></div>
                <div>
                    <strong class="block text-slate-100 text-[11px]">S — Social</strong>
                    <span class="text-slate-400">Yordam berish, muloqot</span>
                </div>
            </div>
            <div class="bg-slate-800 border border-slate-700 rounded-lg p-3 flex items-center gap-2 text-xs animate-fade-in" style="animation-delay:.25s">
                <div class="w-2.5 h-2.5 bg-amber-400 rounded-full flex-shrink-0"></div>
                <div>
                    <strong class="block text-slate-100 text-[11px]">E — Enterprising</strong>
                    <span class="text-slate-400">Biznes, liderlik</span>
                </div>
            </div>
            <div class="bg-slate-800 border border-slate-700 rounded-lg p-3 flex items-center gap-2 text-xs animate-fade-in" style="animation-delay:.3s">
                <div class="w-2.5 h-2.5 bg-slate-400 rounded-full flex-shrink-0"></div>
                <div>
                    <strong class="block text-slate-100 text-[11px]">C — Conventional</strong>
                    <span class="text-slate-400">Tartib, tizim, hujjat</span>
                </div>
            </div>
        </div>

        <!-- Questions -->
        <div class="bg-slate-800 border border-slate-700 rounded-2xl overflow-hidden animate-fade-in">
            <div class="p-5 flex items-center justify-between border-b border-slate-700 bg-slate-800/50">
                <h2 class="text-sm font-bold text-slate-100">Savollar</h2>
                <span class="text-xs text-slate-500 font-mono" id="progress-label">0 / 24</span>
            </div>
            <div class="h-1 bg-slate-700">
                <div class="h-full bg-gradient-to-r from-blue-500 to-purple-500 transition-all duration-400" id="progress-fill" style="width: 0%"></div>
            </div>

            <div class="p-5 flex flex-col gap-2" id="questions-list"></div>

            <div class="p-5 border-t border-slate-700">
                <button class="w-full py-4 bg-gradient-to-r from-blue-500 to-purple-500 rounded-xl text-white font-bold text-base cursor-pointer transition-all duration-250 shadow-lg shadow-blue-500/30 flex items-center justify-center gap-2 hover:shadow-xl hover:shadow-blue-500/40 hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none" onclick="submitTest()" id="submit-btn">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    Natijani ko'rish
                </button>
            </div>
        </div>

        <!-- Result -->
        <div class="bg-slate-800 border border-slate-700 rounded-2xl overflow-hidden hidden animate-fade-in" id="result-card">
            <div class="p-6 bg-gradient-to-r from-blue-500/10 to-purple-500/10 border-b border-slate-700 text-center">
                <h2 class="text-xl font-black text-slate-100 mb-1">🎯 Sizning natijangiz</h2>
                <p class="text-sm text-slate-400">RIASEC profilingiz quyida ko'rsatilgan</p>
            </div>

            <!-- Score bars -->
            <div class="flex flex-col gap-3 p-0" id="score-bars"></div>

            <!-- Chart -->
            <div class="p-6 pt-5">
                <canvas id="resultChart" style="max-height:280px;"></canvas>
            </div>

            <!-- AI Tavsiya -->
            <div class="p-6 border-t border-slate-700">
                <div class="flex items-center gap-2 text-xs font-bold tracking-wide uppercase text-slate-500 mb-4">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>
                    AI tavsiyasi
                </div>
                <div class="bg-slate-900 border border-slate-700 rounded-lg p-5 text-sm leading-relaxed text-slate-400 min-h-20 ai-response-box" id="ai-response">
                    <div class="flex gap-1 items-center p-1">
                        <span class="w-1.5 h-1.5 bg-blue-500 rounded-full animate-bounce"></span>
                        <span class="w-1.5 h-1.5 bg-blue-500 rounded-full animate-bounce" style="animation-delay:.2s"></span>
                        <span class="w-1.5 h-1.5 bg-blue-500 rounded-full animate-bounce" style="animation-delay:.4s"></span>
                    </div>
                </div>
            </div>

            <button class="mx-6 mb-6 w-[calc(100%-3rem)] py-3 border border-slate-700 rounded-lg bg-transparent text-slate-400 font-sans text-sm cursor-pointer transition-all duration-200 hover:border-blue-500 hover:text-blue-500" onclick="resetTest()">↺ Testni qayta topshirish</button>
        </div>

        <!-- History table -->
        @if($history->count())
        <div class="bg-slate-800 border border-slate-700 rounded-2xl overflow-hidden animate-fade-in overflow-x-auto">
            <div class="p-4 border-b border-slate-700 flex items-center gap-2 text-xs font-bold tracking-wide uppercase text-slate-500">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/><path d="M12 6v6l4 2"/></svg>
                Oldingi natijalar ({{ $history->count() }} ta)
            </div>
            <table class="w-full border-collapse text-sm">
                <thead>
                    <tr>
                        <th class="p-3 text-left font-semibold text-slate-500 text-[10px] tracking-wide uppercase bg-slate-800/50 border-b border-slate-700">#</th>
                        <th class="p-3 text-left font-semibold text-slate-500 text-[10px] tracking-wide uppercase bg-slate-800/50 border-b border-slate-700">Natijalar</th>
                        <th class="p-3 text-left font-semibold text-slate-500 text-[10px] tracking-wide uppercase bg-slate-800/50 border-b border-slate-700">Eng yuqori</th>
                        <th class="p-3 text-left font-semibold text-slate-500 text-[10px] tracking-wide uppercase bg-slate-800/50 border-b border-slate-700">Sana</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($history as $i => $r)
                    @php
                        $scores = ['R'=>$r->r_score,'I'=>$r->i_score,'A'=>$r->a_score,'S'=>$r->s_score,'E'=>$r->e_score,'C'=>$r->c_score];
                        arsort($scores);
                        $top = array_key_first($scores);
                        $colors = ['R'=>'#f87171','I'=>'#5b8fff','A'=>'#c084fc','S'=>'#34d399','E'=>'#fbbf24','C'=>'#94a3b8'];
                    @endphp
                    <tr>
                        <td class="p-3 text-slate-500 text-[10px] font-mono">{{ $i+1 }}</td>
                        <td class="p-3">
                            <div class="flex gap-1">
                                @foreach(['R','I','A','S','E','C'] as $k)
                                <span class="text-[10px] font-bold px-1.5 py-0.5 rounded font-mono" style="background:{{ $colors[$k] }}22;color:{{ $colors[$k] }}">
                                    {{ $k }}{{ $r->{strtolower($k).'_score'} }}%
                                </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="p-3">
                            <span class="text-[11px] font-bold px-1.5 py-0.5 rounded font-mono" style="background:{{ $colors[$top] }}22;color:{{ $colors[$top] }}">
                                {{ $top }} — {{ $scores[$top] }}%
                            </span>
                        </td>
                        <td class="p-3 text-[11px] text-slate-500 whitespace-nowrap">
                            {{ $r->created_at->format('d.m.Y H:i') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script src="https://js.puter.com/v2/"></script>

<script>
const SAVE_URL = '{{ route('riasec.save') }}';
const CSRF     = '{{ csrf_token() }}';

const questions = [
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

const groups  = { R:[0,1,2,3], I:[4,5,6,7], A:[8,9,10,11], S:[12,13,14,15], E:[16,17,18,19], C:[20,21,22,23] };
const typeColors = { R:'#f87171', I:'#5b8fff', A:'#c084fc', S:'#34d399', E:'#fbbf24', C:'#94a3b8' };
const typeNames  = { R:'Realistic',I:'Investigative',A:'Artistic',S:'Social',E:'Enterprising',C:'Conventional' };
const typeDesc   = { R:'Amaliy, texnika', I:'Tadqiqot, fan', A:'San\'at, ijod', S:'Ijtimoiy yordam', E:'Biznes, liderlik', C:'Tartib, tizim' };

let answeredCount = 0;
let chart = null;

// Initialize theme on load
window.addEventListener('load', () => {
    initTheme();
    addThemeToggle();
});

// Build questions
const list = document.getElementById('questions-list');
questions.forEach((q, i) => {
    const div = document.createElement('div');
    div.className = 'question-item flex items-center justify-between gap-4 p-4 rounded-lg bg-slate-900 border border-slate-700 transition-all duration-200';
    div.id = `q-item-${i}`;

    // Detect type
    const type = Object.keys(groups).find(k => groups[k].includes(i));
    const dot = `<span class="w-1.5 h-1.5 rounded-full bg-red-400 inline-block mr-1 flex-shrink-0" style="background:${typeColors[type]}"></span>`;

    div.innerHTML = `
        <span class="question-num text-[10px] font-bold text-slate-500 mr-0.5 font-mono flex-shrink-0">${String(i+1).padStart(2,'0')}</span>
        ${dot}
        <span class="question-text text-sm text-slate-400 leading-relaxed flex-1">${q}</span>
        <div class="radio-group flex gap-1 flex-shrink-0 md:flex-row flex-col">
            <label class="radio-pill flex items-center gap-1 px-3 py-1 rounded-full border border-slate-600 bg-slate-800 cursor-pointer text-xs text-slate-500 transition-all duration-180 hover:border-blue-500 hover:text-blue-500" id="pill-yes-${i}" onclick="pickAnswer(${i},1)">
                <input type="radio" name="q${i}" value="1" class="hidden">✓ Ha
            </label>
            <label class="radio-pill flex items-center gap-1 px-3 py-1 rounded-full border border-slate-600 bg-slate-800 cursor-pointer text-xs text-slate-500 transition-all duration-180 hover:border-blue-500 hover:text-blue-500" id="pill-no-${i}" onclick="pickAnswer(${i},0)">
                <input type="radio" name="q${i}" value="0" class="hidden">✗ Yo'q
            </label>
        </div>`;
    list.appendChild(div);
});

function pickAnswer(i, val) {
    const prevEl = document.querySelector(`input[name="q${i}"]:checked`);
    const wasAnswered = !!prevEl;

    document.querySelectorAll(`input[name="q${i}"]`).forEach(r => r.checked = false);
    document.querySelector(`input[name="q${i}"][value="${val}"]`).checked = true;

    const yesP = document.getElementById(`pill-yes-${i}`);
    const noP  = document.getElementById(`pill-no-${i}`);
    yesP.className = val === 1 
        ? 'radio-pill flex items-center gap-1 px-3 py-1 rounded-full border border-emerald-500 bg-emerald-500/10 cursor-pointer text-xs text-emerald-500 transition-all duration-180' 
        : 'radio-pill flex items-center gap-1 px-3 py-1 rounded-full border border-slate-600 bg-slate-800 cursor-pointer text-xs text-slate-500 transition-all duration-180 hover:border-blue-500 hover:text-blue-500';
    noP.className  = val === 0 
        ? 'radio-pill flex items-center gap-1 px-3 py-1 rounded-full border border-slate-500 bg-slate-700/30 cursor-pointer text-xs text-slate-500 transition-all duration-180' 
        : 'radio-pill flex items-center gap-1 px-3 py-1 rounded-full border border-slate-600 bg-slate-800 cursor-pointer text-xs text-slate-500 transition-all duration-180 hover:border-blue-500 hover:text-blue-500';

    document.getElementById(`q-item-${i}`).classList.add('border-blue-500/30', 'bg-blue-500/4');
    document.getElementById(`q-item-${i}`).classList.remove('border-slate-700', 'bg-slate-900');

    if (!wasAnswered) {
        answeredCount++;
        updateProgress();
    }
}

function updateProgress() {
    document.getElementById('progress-label').textContent = `${answeredCount} / 24`;
    document.getElementById('progress-fill').style.width = (answeredCount / 24 * 100) + '%';
}

function submitTest() {
    if (answeredCount < 24) {
        // Javob berilmagan birinchi savolga scroll qilish
        for (let i = 0; i < 24; i++) {
            if (!document.querySelector(`input[name="q${i}"]:checked`)) {
                document.getElementById(`q-item-${i}`).scrollIntoView({ behavior:'smooth', block:'center' });
                const item = document.getElementById(`q-item-${i}`);
                item.classList.remove('border-slate-700', 'bg-slate-900');
                item.classList.add('border-red-400', 'bg-red-400/10');
                setTimeout(() => {
                    item.classList.remove('border-red-400', 'bg-red-400/10');
                    item.classList.add('border-slate-700', 'bg-slate-900');
                }, 1500);
                break;
            }
        }
        return;
    }

    // Hisoblash
    const scores = {};
    for (const t in groups) {
        scores[t] = groups[t].reduce((sum, i) => {
            const el = document.querySelector(`input[name="q${i}"]:checked`);
            return sum + (el ? parseInt(el.value) : 0);
        }, 0) / 4 * 100;
    }

    showResult(scores);
}

function showResult(scores) {
    const card = document.getElementById('result-card');
    card.classList.remove('hidden');
    card.classList.add('block');
    card.scrollIntoView({ behavior:'smooth', block:'start' });

    // Score bars
    const barsEl = document.getElementById('score-bars');
    barsEl.innerHTML = '';
    for (const t in scores) {
        const pct = Math.round(scores[t]);
        const row = document.createElement('div');
        row.className = 'score-row flex items-center gap-3';
        row.innerHTML = `
            <div class="score-label w-32 flex-shrink-0 text-xs text-slate-400">
                <strong class="text-slate-100">${t}</strong> ${typeDesc[t]}
            </div>
            <div class="score-track flex-1 h-2.5 bg-slate-900 rounded-full overflow-hidden">
                <div class="score-fill h-full rounded-full transition-all duration-1000 ease-out" id="fill-${t}" style="background:${typeColors[t]};width:0%"></div>
            </div>
            <div class="score-pct w-9 text-right text-xs font-bold font-mono" style="color:${typeColors[t]}">${pct}%</div>`;
        barsEl.appendChild(row);
        setTimeout(() => { document.getElementById(`fill-${t}`).style.width = pct + '%'; }, 100);
    }

    // Chart
    if (chart) chart.destroy();
    chart = new Chart(document.getElementById('resultChart'), {
        type: 'bar',
        data: {
            labels: Object.keys(scores).map(k => `${k}\n${typeNames[k]}`),
            datasets: [{
                data: Object.values(scores).map(v => Math.round(v)),
                backgroundColor: Object.keys(scores).map(k => typeColors[k] + 'cc'),
                borderColor:     Object.keys(scores).map(k => typeColors[k]),
                borderWidth: 2, borderRadius: 8, borderSkipped: false
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: true,
            plugins: {
                legend: { display: false },
                tooltip: { callbacks: { label: ctx => ctx.parsed.y + '%' } }
            },
            scales: {
                y: {
                    beginAtZero: true, max: 100,
                    ticks: { callback: v => v+'%', color: '#64748b', font:{size:11} },
                    grid: { color:'rgba(255,255,255,.05)' }
                },
                x: {
                    ticks: { color: '#cbd5e1', font:{size:11} },
                    grid: { display: false }
                }
            }
        }
    });

    // AI recommendation
    askAI(scores);
}

async function askAI(scores) {
    const aiBox = document.getElementById('ai-response');
    aiBox.innerHTML = '<div class="flex gap-1 items-center p-1"><span class="w-1.5 h-1.5 bg-blue-500 rounded-full animate-bounce"></span><span class="w-1.5 h-1.5 bg-blue-500 rounded-full animate-bounce" style="animation-delay:.2s"></span><span class="w-1.5 h-1.5 bg-blue-500 rounded-full animate-bounce" style="animation-delay:.4s"></span></div>';

    const sorted = Object.entries(scores).sort((a,b) => b[1]-a[1]);

    const prompt = `Siz kasbga yo'naltirish bo'yicha professional maslahatchi sifatida ishlayapsiz.

RIASEC test natijalari:
- Realistic (Amaliy): ${Math.round(scores.R)}%
- Investigative (Tadqiqot): ${Math.round(scores.I)}%
- Artistic (Ijod): ${Math.round(scores.A)}%
- Social (Ijtimoiy): ${Math.round(scores.S)}%
- Enterprising (Tadbirkorlik): ${Math.round(scores.E)}%
- Conventional (Tartib): ${Math.round(scores.C)}%

Eng yuqori: ${sorted[0][0]} (${Math.round(sorted[0][1])}%), ${sorted[1][0]} (${Math.round(sorted[1][1])}%), ${sorted[2][0]} (${Math.round(sorted[2][1])}%)

Quyidagi formatda javob bering (o'zbek tilida, aniq va qisqacha):

## 📊 Natija tahlili
[2-3 jumlada xulosa]

## 💼 Tavsiya etilgan kasblar
[5-6 ta aniq kasb nomi va qisqacha izoh]

## 🎓 O'qish yo'nalishlari
[3-4 ta yo'nalish]

## ⭐ Kuchli tomonlar
[3 ta]

## 📈 Rivojlantirish uchun
[2 ta maslahat]`;

    try {
        let full = '';
        const response = await puter.ai.chat(prompt, { model: 'deepseek/deepseek-r1', stream: true });
        aiBox.innerHTML = '';

        for await (const part of response) {
            if (part?.text) {
                full += part.text;
                aiBox.innerHTML = marked.parse(full);
            }
        }

        // Bazaga saqlash
        await fetch(SAVE_URL, {
            method: 'POST',
            headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN': CSRF },
            body: JSON.stringify({
                r_score: Math.round(scores.R),
                i_score: Math.round(scores.I),
                a_score: Math.round(scores.A),
                s_score: Math.round(scores.S),
                e_score: Math.round(scores.E),
                c_score: Math.round(scores.C),
                ai_recommendation: full
            })
        });

    } catch(err) {
        aiBox.innerHTML = '<span class="text-red-400">❌ Xatolik yuz berdi.</span>';
        console.error(err);
    }
}

function resetTest() {
    document.querySelectorAll('input[type="radio"]').forEach(r => r.checked = false);
    document.querySelectorAll('.radio-pill').forEach(p => {
        p.className = 'radio-pill flex items-center gap-1 px-3 py-1 rounded-full border border-slate-600 bg-slate-800 cursor-pointer text-xs text-slate-500 transition-all duration-180 hover:border-blue-500 hover:text-blue-500';
    });
    document.querySelectorAll('.question-item').forEach(i => {
        i.classList.remove('border-blue-500/30', 'bg-blue-500/4');
        i.classList.add('border-slate-700', 'bg-slate-900');
    });
    answeredCount = 0;
    updateProgress();
    document.getElementById('result-card').classList.add('hidden');
    document.getElementById('result-card').classList.remove('block');
    window.scrollTo({ top: 0, behavior: 'smooth' });
}
</script>

</x-layout>