<x-minimal-layout>
<x-slot:title>Kasbga yo'naltiruvchi test — RIASEC</x-slot:title>

<style>
@import url('https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap');

:root {
    --ink:     #0b0d14;
    --surface: #12151f;
    --card:    #181c28;
    --border:  #232839;
    --muted:   #454d6a;
    --text:    #c2c8d8;
    --bright:  #edf0f8;
    --accent:  #5b8fff;
    --violet:  #8a5cf5;
    --green:   #34d399;
    --amber:   #fbbf24;
    --red:     #f87171;
    --radius:  16px;

    --r-color: #f87171;
    --i-color: #5b8fff;
    --a-color: #c084fc;
    --s-color: #34d399;
    --e-color: #fbbf24;
    --c-color: #94a3b8;
}

*{box-sizing:border-box;margin:0;padding:0;}

.riasec-page {
    font-family: 'Sora', sans-serif;
    background: var(--ink);
    min-height: 100vh;
    padding: 3rem 1rem 4rem;
    position: relative;
    overflow-x: hidden;
}

/* ── Orbs ── */
.orb {
    position: fixed; border-radius: 50%; pointer-events: none; z-index: 0;
    filter: blur(80px); opacity: .35;
}
.orb-1 { width:500px;height:500px; background:radial-gradient(circle,#3b5bff,transparent); top:-180px;left:-100px; }
.orb-2 { width:400px;height:400px; background:radial-gradient(circle,#7c3aed,transparent); bottom:-100px;right:-80px; }

.container {
    max-width: 860px;
    margin: 0 auto;
    position: relative; z-index: 1;
    display: flex; flex-direction: column; gap: 2rem;
}

/* ── Hero ── */
.hero {
    text-align: center;
    animation: fadeUp .6s ease;
}
.hero-tag {
    display: inline-block;
    font-size: .72rem; font-weight: 700;
    letter-spacing: .12em; text-transform: uppercase;
    color: var(--accent);
    background: rgba(91,143,255,.12);
    border: 1px solid rgba(91,143,255,.25);
    border-radius: 20px; padding: 5px 14px;
    margin-bottom: 1rem;
}
.hero h1 {
    font-size: clamp(1.9rem,5vw,3rem);
    font-weight: 800; color: var(--bright);
    line-height: 1.15; margin-bottom: .75rem;
}
.hero p {
    font-size: .95rem; color: var(--text);
    max-width: 540px; margin: 0 auto;
    line-height: 1.7;
}

/* ── Type legend ── */
.legend {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: .6rem;
}
@media(max-width:600px){ .legend{grid-template-columns:repeat(2,1fr);} }

.legend-item {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: 10px; padding: .65rem .9rem;
    display: flex; align-items: center; gap: .6rem;
    font-size: .78rem;
    animation: fadeUp .5s ease both;
}
.legend-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; }
.legend-item span { color: var(--text); }
.legend-item strong { color: var(--bright); display: block; font-size: .72rem; }

/* ── Question card ── */
.questions-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    overflow: hidden;
    animation: fadeUp .6s ease;
}
.questions-card-header {
    padding: 1.2rem 1.5rem;
    display: flex; align-items: center;
    justify-content: space-between;
    border-bottom: 1px solid var(--border);
    background: rgba(255,255,255,.02);
}
.questions-card-header h2 {
    font-size: .95rem; font-weight: 700;
    color: var(--bright);
}
.progress-label {
    font-size: .75rem; color: var(--muted);
    font-family: 'JetBrains Mono', monospace;
}
.progress-bar-wrap {
    height: 3px; background: var(--border);
    margin: 0;
}
.progress-bar-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--accent), var(--violet));
    transition: width .4s ease;
    width: 0%;
}

.questions-list { padding: 1rem 1.5rem; display: flex; flex-direction: column; gap: .6rem; }

.question-item {
    display: flex; align-items: center;
    justify-content: space-between;
    gap: 1rem;
    padding: .85rem 1rem;
    border-radius: 10px;
    background: var(--surface);
    border: 1px solid var(--border);
    transition: border-color .2s, background .2s;
}
.question-item.answered { border-color: rgba(91,143,255,.3); background: rgba(91,143,255,.04); }

.question-text {
    font-size: .85rem; color: var(--text);
    line-height: 1.5; flex: 1;
}
.question-num {
    font-size: .7rem; font-weight: 700;
    color: var(--muted); margin-right: .2rem;
    font-family: 'JetBrains Mono', monospace;
    flex-shrink: 0;
}

.radio-group { display: flex; gap: .4rem; flex-shrink: 0; }

/* Mobile: stack radio buttons vertically */
@media(max-width:600px){ 
    .radio-group { flex-direction: column; gap: .6rem; } 
}

.radio-pill {
    display: flex; align-items: center; gap: 5px;
    padding: 5px 12px; border-radius: 20px;
    border: 1.5px solid var(--border);
    background: var(--card);
    cursor: pointer; font-size: .78rem;
    color: var(--muted); transition: all .18s;
    user-select: none;
}
.radio-pill input { display: none; }
.radio-pill:hover { border-color: var(--accent); color: var(--accent); }
.radio-pill.selected-yes { border-color: var(--green); background: rgba(52,211,153,.1); color: var(--green); }
.radio-pill.selected-no  { border-color: var(--muted); background: rgba(255,255,255,.03); color: var(--muted); }

/* ── Submit btn ── */
.submit-wrap { padding: 1.2rem 1.5rem; border-top: 1px solid var(--border); }
.submit-btn {
    width: 100%; padding: 1rem;
    background: linear-gradient(135deg, var(--accent), var(--violet));
    border: none; border-radius: 12px;
    color: #fff; font-family: 'Sora', sans-serif;
    font-size: 1rem; font-weight: 700;
    cursor: pointer; transition: all .25s;
    box-shadow: 0 4px 20px rgba(91,143,255,.3);
    display: flex; align-items: center; justify-content: center; gap: .5rem;
}
.submit-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(91,143,255,.4); }
.submit-btn:disabled { opacity: .5; cursor: not-allowed; transform: none; }

/* ── Result ── */
.result-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    overflow: hidden;
    display: none;
    animation: fadeUp .5s ease;
}
.result-card.visible { display: block; }

.result-header {
    padding: 1.4rem 1.5rem;
    background: linear-gradient(135deg,rgba(91,143,255,.1),rgba(138,92,245,.1));
    border-bottom: 1px solid var(--border);
    text-align: center;
}
.result-header h2 { font-size: 1.3rem; font-weight: 800; color: var(--bright); margin-bottom: .3rem; }
.result-header p  { font-size: .83rem; color: var(--text); }

.chart-wrap { padding: 1.5rem; }

/* Score bars */
.score-bars { display: flex; flex-direction: column; gap: .7rem; padding: 0 1.5rem; }
.score-row { display: flex; align-items: center; gap: .75rem; }
.score-label {
    width: 130px; flex-shrink: 0;
    font-size: .78rem; color: var(--text);
}
.score-label strong { color: var(--bright); }
.score-track {
    flex: 1; height: 10px;
    background: var(--surface); border-radius: 6px; overflow: hidden;
}
.score-fill { height: 100%; border-radius: 6px; transition: width 1s cubic-bezier(.22,1,.36,1); width: 0%; }
.score-pct {
    width: 36px; text-align: right;
    font-size: .75rem; font-weight: 700;
    font-family: 'JetBrains Mono', monospace;
    color: var(--bright);
}

.chart-canvas-wrap { padding: 0 1.5rem 1.5rem; }

/* AI section */
.ai-section { padding: 1.5rem; border-top: 1px solid var(--border); }
.ai-section-title {
    display: flex; align-items: center; gap: .5rem;
    font-size: .8rem; font-weight: 700; letter-spacing: .08em;
    text-transform: uppercase; color: var(--muted);
    margin-bottom: 1rem;
}
.ai-response-box {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: 10px; padding: 1.2rem;
    font-size: .86rem; line-height: 1.75;
    color: var(--text); min-height: 80px;
}
.ai-response-box h2 { color: var(--bright); font-size: 1rem; margin: .8rem 0 .4rem; border-bottom: 1px solid var(--border); padding-bottom: .4rem; }
.ai-response-box h3 { color: var(--text); font-size: .88rem; margin: .6rem 0 .3rem; }
.ai-response-box ul,.ai-response-box ol { margin-left: 1.2rem; margin-top: .3rem; }
.ai-response-box li { margin-bottom: .3rem; }
.ai-response-box p { margin-bottom: .5rem; }
.ai-response-box strong { color: var(--bright); }
.ai-response-box code { background:rgba(255,255,255,.06); padding:1px 5px; border-radius:4px; font-family:'JetBrains Mono',monospace; font-size:.8rem; color:#a5c8ff; }

.typing-dots { display:flex; gap:4px; align-items:center; padding:.4rem 0; }
.typing-dots span { width:6px;height:6px; background:var(--accent); border-radius:50%; animation:bounce 1.2s ease infinite; }
.typing-dots span:nth-child(2){animation-delay:.2s;}
.typing-dots span:nth-child(3){animation-delay:.4s;}
@keyframes bounce{0%,80%,100%{transform:translateY(0);opacity:.5;}40%{transform:translateY(-6px);opacity:1;}}

.reset-btn {
    margin: 1rem 1.5rem 1.5rem;
    width: calc(100% - 3rem);
    padding: .85rem; border: 1.5px solid var(--border);
    border-radius: 10px; background: none;
    color: var(--text); font-family:'Sora',sans-serif;
    font-size: .88rem; cursor: pointer;
    transition: all .2s;
}
.reset-btn:hover { border-color: var(--accent); color: var(--accent); }

/* ── History table ── */
.history-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    overflow: hidden;
    animation: fadeUp .7s ease;
    overflow-x: auto !important;
}
.history-card-header {
    padding: .9rem 1.2rem;
    border-bottom: 1px solid var(--border);
    display: flex; align-items: center; gap: .5rem;
    font-size: .78rem; font-weight: 700;
    letter-spacing: .07em; text-transform: uppercase;
    color: var(--muted);
}
.htable { width:100%; border-collapse:collapse; font-size:.8rem; }
.htable th { padding:.6rem 1rem; text-align:left; font-weight:600; color:var(--muted); font-size:.7rem; letter-spacing:.07em; text-transform:uppercase; background:rgba(255,255,255,.02); border-bottom:1px solid var(--border); }
.htable td { padding:.65rem 1rem; color:var(--text); border-bottom:1px solid rgba(255,255,255,.04); }
.htable tr:last-child td { border-bottom:none; }
.htable tr:hover td { background:rgba(255,255,255,.02); }
.mini-score { display:flex; gap:4px; }
.mini-pill { font-size:.65rem; font-weight:700; padding:2px 6px; border-radius:4px; font-family:'JetBrains Mono',monospace; }

@keyframes fadeUp{from{opacity:0;transform:translateY(14px);}to{opacity:1;transform:translateY(0);}}
</style>

<div class="riasec-page">
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    
    <!-- Simple back navigation -->
    <div class="back-nav" style="position: fixed; top: 20px; left: 20px; z-index: 100;">
        <a href="{{ route('index') }}" 
           style="display: flex; align-items: center; gap: 8px; 
                  background: rgba(24, 28, 40, 0.9); 
                  border: 1px solid var(--border); 
                  color: var(--text); 
                  padding: 8px 16px; 
                  border-radius: 8px; 
                  text-decoration: none; 
                  font-size: 0.85rem; 
                  backdrop-filter: blur(10px);
                  transition: all 0.2s;"
           onmouseover="this.style.background='var(--accent)'; this.style.color='#fff'; this.style.borderColor='var(--accent)'"
           onmouseout="this.style.background='rgba(24, 28, 40, 0.9)'; this.style.color='var(--text)'; this.style.borderColor='var(--border)'">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
            Asosiy sahifa
        </a>
    </div>

    <div class="container">

        <!-- Hero -->
        <div class="hero">
            <div class="hero-tag">RIASEC Test</div>
            <h1>Kasbga yo'naltiruvchi<br>psixologik test</h1>
            <p>24 ta savolga «Ha» yoki «Yo'q» deb javob bering. Natijada sizga eng mos yo'nalishlar foizlarda chiqadi.</p>
        </div>

        <!-- Legend -->
        <div class="legend">
            <div class="legend-item" style="animation-delay:.05s">
                <div class="legend-dot" style="background:var(--r-color)"></div>
                <div><strong>R — Realistic</strong><span>Amaliy, texnika, sport</span></div>
            </div>
            <div class="legend-item" style="animation-delay:.1s">
                <div class="legend-dot" style="background:var(--i-color)"></div>
                <div><strong>I — Investigative</strong><span>Tadqiqot, fan, tahlil</span></div>
            </div>
            <div class="legend-item" style="animation-delay:.15s">
                <div class="legend-dot" style="background:var(--a-color)"></div>
                <div><strong>A — Artistic</strong><span>San'at, ijod, dizayn</span></div>
            </div>
            <div class="legend-item" style="animation-delay:.2s">
                <div class="legend-dot" style="background:var(--s-color)"></div>
                <div><strong>S — Social</strong><span>Yordam berish, muloqot</span></div>
            </div>
            <div class="legend-item" style="animation-delay:.25s">
                <div class="legend-dot" style="background:var(--e-color)"></div>
                <div><strong>E — Enterprising</strong><span>Biznes, liderlik</span></div>
            </div>
            <div class="legend-item" style="animation-delay:.3s">
                <div class="legend-dot" style="background:var(--c-color)"></div>
                <div><strong>C — Conventional</strong><span>Tartib, tizim, hujjat</span></div>
            </div>
        </div>

        <!-- Questions -->
        <div class="questions-card">
            <div class="questions-card-header">
                <h2>Savollar</h2>
                <span class="progress-label" id="progress-label">0 / 24</span>
            </div>
            <div class="progress-bar-wrap">
                <div class="progress-bar-fill" id="progress-fill"></div>
            </div>

            <div class="questions-list" id="questions-list"></div>

            <div class="submit-wrap">
                <button class="submit-btn" onclick="submitTest()" id="submit-btn">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                    Natijani ko'rish
                </button>
            </div>
        </div>

        <!-- Result -->
        <div class="result-card" id="result-card">
            <div class="result-header">
                <h2>🎯 Sizning natijangiz</h2>
                <p>RIASEC profilingiz quyida ko'rsatilgan</p>
            </div>

            <!-- Score bars -->
            <div class="score-bars" id="score-bars"></div>

            <!-- Chart -->
            <div class="chart-canvas-wrap" style="padding-top:1.2rem;">
                <canvas id="resultChart" style="max-height:280px;"></canvas>
            </div>

            <!-- AI Tavsiya -->
            <div class="ai-section">
                <div class="ai-section-title">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4M12 8h.01"/></svg>
                    AI tavsiyasi
                </div>
                <div class="ai-response-box" id="ai-response">
                    <div class="typing-dots"><span></span><span></span><span></span></div>
                </div>
            </div>

            <button class="reset-btn" onclick="resetTest()">↺ Testni qayta topshirish</button>
        </div>

        <!-- History table -->
        @if($history->count())
        <div class="history-card">
            <div class="history-card-header">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/><path d="M12 6v6l4 2"/></svg>
                Oldingi natijalar ({{ $history->count() }} ta)
            </div>
            <table class="htable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Natijalar</th>
                        <th>Eng yuqori</th>
                        <th>Sana</th>
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
                        <td style="color:var(--muted);font-size:.7rem;font-family:'JetBrains Mono',monospace;">{{ $i+1 }}</td>
                        <td>
                            <div class="mini-score">
                                @foreach(['R','I','A','S','E','C'] as $k)
                                <span class="mini-pill" style="background:{{ $colors[$k] }}22;color:{{ $colors[$k] }}">
                                    {{ $k }}{{ $r->{strtolower($k).'_score'} }}%
                                </span>
                                @endforeach
                            </div>
                        </td>
                        <td>
                            <span class="mini-pill" style="background:{{ $colors[$top] }}22;color:{{ $colors[$top] }};font-size:.75rem;">
                                {{ $top }} — {{ $scores[$top] }}%
                            </span>
                        </td>
                        <td style="font-size:.72rem;color:var(--muted);white-space:nowrap;">
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

// Build questions
const list = document.getElementById('questions-list');
questions.forEach((q, i) => {
    const div = document.createElement('div');
    div.className = 'question-item';
    div.id = `q-item-${i}`;

    // Detect type
    const type = Object.keys(groups).find(k => groups[k].includes(i));
    const dot = `<span style="width:7px;height:7px;border-radius:50%;background:${typeColors[type]};display:inline-block;margin-right:4px;flex-shrink:0;"></span>`;

    div.innerHTML = `
        <span class="question-num">${String(i+1).padStart(2,'0')}</span>
        ${dot}
        <span class="question-text">${q}</span>
        <div class="radio-group">
            <label class="radio-pill" id="pill-yes-${i}" onclick="pickAnswer(${i},1)">
                <input type="radio" name="q${i}" value="1">✓ Ha
            </label>
            <label class="radio-pill" id="pill-no-${i}" onclick="pickAnswer(${i},0)">
                <input type="radio" name="q${i}" value="0">✗ Yo'q
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
    yesP.className = 'radio-pill' + (val === 1 ? ' selected-yes' : '');
    noP.className  = 'radio-pill' + (val === 0 ? ' selected-no' : '');

    document.getElementById(`q-item-${i}`).classList.add('answered');

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
                document.getElementById(`q-item-${i}`).style.borderColor = '#f87171';
                setTimeout(() => {
                    document.getElementById(`q-item-${i}`).style.borderColor = '';
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
    card.classList.add('visible');
    card.scrollIntoView({ behavior:'smooth', block:'start' });

    // Score bars
    const barsEl = document.getElementById('score-bars');
    barsEl.innerHTML = '';
    for (const t in scores) {
        const pct = Math.round(scores[t]);
        const row = document.createElement('div');
        row.className = 'score-row';
        row.innerHTML = `
            <div class="score-label"><strong>${t}</strong> ${typeDesc[t]}</div>
            <div class="score-track">
                <div class="score-fill" id="fill-${t}" style="background:${typeColors[t]};width:0%"></div>
            </div>
            <div class="score-pct" style="color:${typeColors[t]}">${pct}%</div>`;
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
                    ticks: { callback: v => v+'%', color:'#4a5068', font:{size:11} },
                    grid: { color:'rgba(255,255,255,.05)' }
                },
                x: {
                    ticks: { color:'#c2c8d8', font:{size:11} },
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
    aiBox.innerHTML = '<div class="typing-dots"><span></span><span></span><span></span></div>';

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
        aiBox.innerHTML = '<span style="color:#f87171">❌ Xatolik yuz berdi.</span>';
        console.error(err);
    }
}

function resetTest() {
    document.querySelectorAll('input[type="radio"]').forEach(r => r.checked = false);
    document.querySelectorAll('.radio-pill').forEach(p => {
        p.className = 'radio-pill';
    });
    document.querySelectorAll('.question-item').forEach(i => i.classList.remove('answered'));
    answeredCount = 0;
    updateProgress();
    document.getElementById('result-card').classList.remove('visible');
    window.scrollTo({ top: 0, behavior: 'smooth' });
}
</script>

</x-minimal-layout>