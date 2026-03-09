<x-minimal-layout>
<x-slot:title>AI Maslahatchi</x-slot:title>

@php $maxMsgs = \App\Models\ChatSession::MAX_MESSAGES; @endphp

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap');

:root {
    --bg:     #0f1117;
    --sb:     #161820;
    --panel:  #1c1e2a;
    --border: #2a2d3e;
    --muted:  #4b5163;
    --text:   #c9cdd8;
    --bright: #eef0f6;
    --accent: #5b8aff;
    --grad:   linear-gradient(135deg,#5b8aff,#8b5cf6);
    --green:  #34d399;
    --red:    #f87171;
    --sw:     280px;
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
button { cursor: pointer; border: none; background: none; font-family: inherit; }
textarea, input { font-family: inherit; }

.app {
    font-family: 'Inter', sans-serif;
    background: var(--bg);
    height: 100vh;
    display: flex;
    overflow: hidden;
    color: var(--text);
}

/* ════ SIDEBAR ════ */
.sb {
    width: var(--sw);
    background: var(--sb);
    border-right: 1px solid var(--border);
    display: flex;
    flex-direction: column;
    flex-shrink: 0;
    transition: transform .3s cubic-bezier(.4,0,.2,1);
    z-index: 40;
}
@media (max-width: 768px) {
    .sb { position: fixed; top: 0; left: 0; height: 100%; transform: translateX(-100%); }
    .sb.open { transform: translateX(0); box-shadow: 4px 0 24px rgba(0,0,0,.5); }
    .ov { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.55); z-index: 39; }
    .ov.show { display: block; }
}
.sb-head {
    padding: 1rem;
    border-bottom: 1px solid var(--border);
    display: flex; align-items: center; gap: .6rem;
}
.sb-logo {
    width: 34px; height: 34px;
    background: var(--grad);
    border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    font-size: 16px; flex-shrink: 0;
}
.sb-title { font-size: .88rem; font-weight: 700; color: var(--bright); }

.new-btn {
    margin: .75rem 1rem .25rem;
    width: calc(100% - 2rem);
    padding: .6rem 1rem;
    display: flex; align-items: center; gap: .5rem;
    background: rgba(91,138,255,.1);
    border: 1px solid rgba(91,138,255,.22);
    border-radius: 10px;
    color: var(--accent);
    font-size: .82rem; font-weight: 600;
    transition: all .18s;
}
.new-btn:hover { background: rgba(91,138,255,.2); border-color: var(--accent); }

.sb-label {
    padding: .5rem 1rem .3rem;
    font-size: .63rem; font-weight: 700;
    letter-spacing: .1em; text-transform: uppercase;
    color: var(--muted);
}

.sess-list {
    flex: 1; overflow-y: auto;
    padding: 0 .5rem .5rem;
}
.sess-list::-webkit-scrollbar { width: 4px; }
.sess-list::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }

.si {
    padding: .65rem .75rem;
    border-radius: 8px;
    cursor: pointer;
    transition: background .15s;
    margin-bottom: 2px;
    border: 1px solid transparent;
}
.si:hover { background: rgba(255,255,255,.04); }
.si.active { background: rgba(91,138,255,.1); border-color: rgba(91,138,255,.2); }
.si-title {
    font-size: .8rem; font-weight: 500; color: var(--bright);
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    margin-bottom: 3px;
}
.si-meta { display: flex; align-items: center; gap: .4rem; font-size: .67rem; color: var(--muted); }
.si-prev {
    font-size: .71rem; color: var(--muted);
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    margin-top: 2px;
}
.bdg { font-size: .6rem; font-weight: 700; padding: 1px 5px; border-radius: 4px; }
.b-a { background: rgba(52,211,153,.15); color: var(--green); }
.b-c { background: rgba(255,255,255,.06); color: var(--muted); }

/* ════ MAIN ════ */
.main { flex: 1; display: flex; flex-direction: column; min-width: 0; overflow: hidden; }

.topbar {
    padding: .75rem 1.25rem;
    background: var(--panel);
    border-bottom: 1px solid var(--border);
    display: flex; align-items: center; gap: .75rem;
    flex-shrink: 0;
}
.tb-tog { display: none; color: var(--text); padding: 4px; align-items: center; }
@media (max-width: 768px) { .tb-tog { display: flex; } }
.tb-info { flex: 1; min-width: 0; }
.tb-title {
    font-size: .9rem; font-weight: 600; color: var(--bright);
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.tb-sub { font-size: .72rem; color: var(--muted); margin-top: 1px; }
.prog-wrap { display: flex; align-items: center; gap: .5rem; width: 110px; flex-shrink: 0; }
.prog-bar { flex: 1; height: 3px; background: var(--border); border-radius: 2px; overflow: hidden; }
.prog-fill { height: 100%; background: var(--grad); border-radius: 2px; transition: width .3s; }
.prog-txt { font-size: .65rem; color: var(--muted); white-space: nowrap; font-family: 'JetBrains Mono', monospace; }

.home-btn {
    width: 42px;
    height: 42px;
    border-radius: 11px;
    background: linear-gradient(135deg, rgba(91,138,255,.08), rgba(139,92,246,.08));
    border: 1px solid rgba(91,138,255,.15);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: all .25s cubic-bezier(.4,0,.2,1);
    color: var(--accent);
    margin-left: .75rem;
    position: relative;
    overflow: hidden;
}
.home-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: var(--grad);
    opacity: 0;
    transition: opacity .25s;
    border-radius: 10px;
}
.home-btn:hover {
    transform: scale(1.08) translateY(-1px);
    border-color: var(--accent);
    box-shadow: 0 4px 16px rgba(91,138,255,.25);
}
.home-btn:hover::before {
    opacity: .1;
}
.home-btn:active {
    transform: scale(1.02) translateY(0);
    transition: all .1s;
}
.home-btn svg {
    width: 20px;
    height: 20px;
    position: relative;
    z-index: 1;
    transition: transform .25s;
}
.home-btn:hover svg {
    transform: scale(1.1);
}

.full-banner {
    display: none;
    padding: .5rem 1.25rem;
    background: rgba(248,113,113,.08);
    border-bottom: 1px solid rgba(248,113,113,.15);
    font-size: .78rem; color: var(--red);
    align-items: center; gap: .5rem;
    flex-shrink: 0;
}
.full-banner.show { display: flex; }

/* ════ MESSAGES ════ */
.msgs {
    flex: 1; overflow-y: auto;
    padding: 1.5rem 1.25rem;
    display: flex; flex-direction: column; gap: .85rem;
    scroll-behavior: smooth;
}
.msgs::-webkit-scrollbar { width: 5px; }
.msgs::-webkit-scrollbar-thumb { background: var(--border); border-radius: 4px; }

.empty-state {
    flex: 1;
    display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    text-align: center; gap: .8rem;
    padding: 2rem;
    animation: fadeUp .4s ease;
}
.empty-icon {
    width: 64px; height: 64px;
    background: linear-gradient(135deg, rgba(91,138,255,.12), rgba(139,92,246,.12));
    border: 1px solid rgba(91,138,255,.18);
    border-radius: 20px;
    display: flex; align-items: center; justify-content: center;
    font-size: 28px;
}
.empty-state h3 { font-size: 1rem; font-weight: 600; color: var(--bright); }
.empty-state p { font-size: .82rem; color: var(--muted); max-width: 300px; line-height: 1.65; }
.chips { display: flex; flex-wrap: wrap; gap: .4rem; justify-content: center; margin-top: .25rem; }
.chip {
    padding: .4rem .9rem;
    background: var(--panel);
    border: 1px solid var(--border);
    border-radius: 20px;
    font-size: .75rem; color: var(--text);
    cursor: pointer; transition: all .15s;
}
.chip:hover { border-color: var(--accent); color: var(--accent); background: rgba(91,138,255,.06); }

/* Bubbles */
.msg { display: flex; gap: .65rem; animation: fadeUp .25s ease; }
.msg.user { flex-direction: row-reverse; }
.avatar {
    width: 32px; height: 32px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: .72rem; font-weight: 700; flex-shrink: 0;
    font-family: 'JetBrains Mono', monospace;
}
.msg.user .avatar { background: var(--grad); color: #fff; }
.msg.ai   .avatar { background: var(--panel); border: 1px solid var(--border); color: var(--accent); }
.msg-body { max-width: 74%; display: flex; flex-direction: column; }
.msg.user .msg-body { align-items: flex-end; }
.bubble { padding: .8rem 1rem; border-radius: 14px; font-size: .86rem; line-height: 1.7; }
.msg.user .bubble { background: var(--grad); color: #fff; border-bottom-right-radius: 4px; }
.msg.ai   .bubble { background: var(--panel); border: 1px solid var(--border); color: var(--text); border-bottom-left-radius: 4px; }
.msg-time { font-size: .64rem; color: var(--muted); margin-top: 4px; padding: 0 2px; }

/* Typing */
.dots { display: flex; gap: 4px; align-items: center; padding: 2px 0; }
.dots span {
    width: 6px; height: 6px;
    background: var(--accent); border-radius: 50%;
    animation: bounce 1.2s ease infinite;
}
.dots span:nth-child(2) { animation-delay: .2s; }
.dots span:nth-child(3) { animation-delay: .4s; }
@keyframes bounce { 0%,80%,100%{transform:translateY(0);opacity:.4} 40%{transform:translateY(-6px);opacity:1} }

/* AI markdown */
.ai-md p   { margin-bottom: .5rem; }
.ai-md p:last-child { margin-bottom: 0; }
.ai-md h1, .ai-md h2, .ai-md h3 { color: var(--bright); margin: .8rem 0 .35rem; font-size: .95rem; }
.ai-md ul, .ai-md ol { margin: .35rem 0 .35rem 1.25rem; }
.ai-md li  { margin-bottom: .3rem; }
.ai-md strong { color: var(--bright); }
.ai-md a   { color: var(--accent); text-decoration: underline; }
.ai-md code {
    font-family: 'JetBrains Mono', monospace;
    font-size: .79rem;
    background: rgba(255,255,255,.07);
    padding: 1px 5px; border-radius: 4px;
    color: #93c5fd;
}
.ai-md pre {
    background: rgba(0,0,0,.4);
    border: 1px solid var(--border);
    border-radius: 8px; padding: .85rem;
    overflow-x: auto; margin: .5rem 0;
}
.ai-md pre code { background: none; padding: 0; color: var(--text); }
.ai-md table { width: 100%; border-collapse: collapse; font-size: .82rem; margin: .5rem 0; }
.ai-md th, .ai-md td { padding: .4rem .65rem; border: 1px solid var(--border); text-align: left; }
.ai-md th { background: rgba(255,255,255,.04); color: var(--bright); }
.ai-md hr { border: none; border-top: 1px solid var(--border); margin: .75rem 0; }

/* Markaz karta (AI javobida) */
.center-tag {
    display: inline-block;
    padding: 2px 8px;
    background: rgba(91,138,255,.12);
    border: 1px solid rgba(91,138,255,.2);
    border-radius: 6px;
    font-size: .72rem; color: var(--accent);
    margin: 2px 2px 2px 0;
}

/* ════ INPUT ════ */
.inp-area {
    padding: .9rem 1.25rem 1rem;
    background: var(--panel);
    border-top: 1px solid var(--border);
    flex-shrink: 0;
}
.inp-row {
    display: flex; gap: .6rem; align-items: flex-end;
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: .6rem .6rem .6rem .9rem;
    transition: border-color .2s;
}
.inp-row:focus-within { border-color: var(--accent); }
.inp-ta {
    flex: 1; background: none; border: none; outline: none;
    color: var(--bright); font-size: .875rem; line-height: 1.5;
    resize: none; min-height: 24px; max-height: 130px; padding: 0;
}
.inp-ta::placeholder { color: var(--muted); }
.send-btn {
    width: 36px; height: 36px; border-radius: 9px;
    background: var(--grad);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; transition: all .18s;
    box-shadow: 0 2px 10px rgba(91,138,255,.28);
}
.send-btn:hover:not(:disabled) { transform: scale(1.08); box-shadow: 0 4px 16px rgba(91,138,255,.42); }
.send-btn:disabled { opacity: .4; cursor: not-allowed; transform: none; }
.send-btn svg { color: #fff; }
.inp-foot {
    display: flex; justify-content: space-between; align-items: center;
    margin-top: .45rem; padding: 0 .2rem;
    font-size: .68rem; color: var(--muted);
}
.inp-foot kbd {
    background: var(--bg); border: 1px solid var(--border);
    border-radius: 3px; padding: 1px 4px;
    font-family: 'JetBrains Mono', monospace;
    font-size: .65rem; color: var(--text);
}

/* Searching indicator */
.search-indicator {
    display: none;
    padding: .35rem .75rem;
    background: rgba(91,138,255,.08);
    border: 1px solid rgba(91,138,255,.15);
    border-radius: 8px;
    font-size: .75rem; color: var(--accent);
    align-items: center; gap: .4rem;
    margin-bottom: .5rem;
    animation: fadeUp .2s ease;
}
.search-indicator.show { display: flex; }
.search-dot { width: 6px; height: 6px; background: var(--accent); border-radius: 50%; animation: bounce 1s ease infinite; }
.search-dot:nth-child(2) { animation-delay: .15s; }
.search-dot:nth-child(3) { animation-delay: .3s; }

@keyframes fadeUp { from{opacity:0;transform:translateY(8px)} to{opacity:1;transform:translateY(0)} }
</style>

{{-- Overlay --}}
<div class="ov" id="ov" onclick="closeSB()"></div>

<div class="app">

{{-- ═══════════════ SIDEBAR ═══════════════ --}}
<aside class="sb" id="sb">
    <div class="sb-head">
        <div class="sb-logo">🤖</div>
        <span class="sb-title">AI Maslahatchi</span>
    </div>

    <button class="new-btn" onclick="newChat()">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
        Yangi suhbat
    </button>

    <div class="sb-label">Suhbatlar tarixi</div>

    <div class="sess-list" id="sess-list">
        @forelse($sessions as $s)
        <div class="si {{ $currentSession?->id == $s->id ? 'active' : '' }}"
             id="si-{{ $s->id }}"
             onclick="loadSess({{ $s->id }})">
            <div class="si-title">{{ $s->title }}</div>
            <div class="si-meta">
                <span class="bdg {{ $s->status === 'active' ? 'b-a' : 'b-c' }}">
                    {{ $s->status === 'active' ? 'Faol' : 'Yopiq' }}
                </span>
                <span>{{ $s->message_count }}/{{ $maxMsgs }}</span>
                <span>{{ $s->created_at->format('d.m') }}</span>
            </div>
            @if($s->lastMessage)
            <div class="si-prev">{{ Str::limit($s->lastMessage->content, 48) }}</div>
            @endif
        </div>
        @empty
        <div id="sess-empty" style="padding:1.5rem 1rem;text-align:center;font-size:.78rem;color:var(--muted)">
            Hali suhbat yo'q
        </div>
        @endforelse
    </div>
</aside>

{{-- ═══════════════ MAIN ═══════════════ --}}
<div class="main">

    {{-- Topbar --}}
    <div class="topbar">
        <button class="tb-tog" onclick="openSB()">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
        </button>
        <div class="tb-info">
            <div class="tb-title" id="tb-title">{{ $currentSession?->title ?? 'AI Maslahatchi' }}</div>
            <div class="tb-sub" id="tb-sub">
                {{ $currentSession ? ($currentSession->message_count . '/' . $maxMsgs . ' xabar') : 'Yangi suhbat boshlang' }}
            </div>
        </div>
        <div class="prog-wrap">
            <div class="prog-bar">
                <div class="prog-fill" id="prog-fill"
                     style="width:{{ $currentSession ? round($currentSession->message_count / $maxMsgs * 100) : 0 }}%">
                </div>
            </div>
            <span class="prog-txt" id="prog-txt">{{ $currentSession?->message_count ?? 0 }}/{{ $maxMsgs }}</span>
        </div>
        <button class="home-btn" onclick="window.location.href='{{route('index')}}'" title="Asosiy sahifaga qaytish">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                <polyline points="9,22 9,12 15,12 15,22"/>
            </svg>
        </button>
    </div>

    {{-- To'lganlik banneri --}}
    <div class="full-banner {{ $currentSession?->isFull() ? 'show' : '' }}" id="full-banner">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        Bu suhbat to'ldi ({{ $maxMsgs }} xabar).
        <button onclick="newChat()" style="color:var(--accent);text-decoration:underline;font-size:.78rem;margin-left:.25rem;">
            Yangi suhbat ochish →
        </button>
    </div>

    {{-- Messages --}}
    <div class="msgs" id="msgs">

        {{-- Qidiruv indikatori --}}
        <div class="search-indicator" id="search-indicator">
            <div class="search-dot"></div>
            <div class="search-dot"></div>
            <div class="search-dot"></div>
            <span id="search-text">Markazlar qidirilmoqda...</span>
        </div>

        @if($messages->isEmpty())
        <div class="empty-state" id="empty-state">
            <div class="empty-icon">💬</div>
            <h3>Salom! Men AI maslahatchi</h3>
            <p>O'quv markazlar, kurslar va ta'lim haqida savol bering</p>
            <div class="chips">
                <button class="chip" onclick="fillIn(this.textContent)">Toshkentda matematika kurslari</button>
                <button class="chip" onclick="fillIn(this.textContent)">Ingliz tili o'rganmoqchiman</button>
                <button class="chip" onclick="fillIn(this.textContent)">Dasturlash kurslari qayerda?</button>
                <button class="chip" onclick="fillIn(this.textContent)">Arzon o'quv markazlar</button>
                <button class="chip" onclick="fillIn(this.textContent)">Samarqandda IT kurslari</button>
                <button class="chip" onclick="fillIn(this.textContent)">Qaysi o'quv markaz yaxshi?</button>
            </div>
        </div>
        @else
        @foreach($messages as $m)
        <div class="msg {{ $m->role === 'user' ? 'user' : 'ai' }}">
            <div class="avatar">{{ $m->role === 'user' ? 'S' : 'AI' }}</div>
            <div class="msg-body">
                <div class="bubble">
                    @if($m->role === 'assistant')
                        <div class="ai-md">{!! \Illuminate\Support\Str::markdown($m->content) !!}</div>
                    @else
                        {{ $m->content }}
                    @endif
                </div>
                <div class="msg-time">{{ $m->created_at->format('H:i') }}</div>
            </div>
        </div>
        @endforeach
        @endif
    </div>

    {{-- Input --}}
    <div class="inp-area">
        <div class="inp-row">
            <textarea
                id="inp"
                class="inp-ta"
                placeholder="Savol yozing... (masalan: Toshkentda ingliz tili kursi)"
                rows="1"
            ></textarea>
            <button class="send-btn" id="send-btn" onclick="send()">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="22" y1="2" x2="11" y2="13"/>
                    <polygon points="22 2 15 22 11 13 2 9 22 2"/>
                </svg>
            </button>
        </div>
        <div class="inp-foot">
            <span><kbd>Enter</kbd> yuborish · <kbd>Shift+Enter</kbd> yangi qator</span>
            <span id="char-count" style="font-family:'JetBrains Mono',monospace">0/2000</span>
        </div>
    </div>

</div>
</div>

<script src="https://js.puter.com/v2/"></script>
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

<script>
/* ═══════════════════════════════════════════
   SOZLAMALAR
═══════════════════════════════════════════ */
const CSRF         = '{{ csrf_token() }}';
const URL_SAVE     = '{{ route('chat.save') }}';
const URL_NEW      = '{{ route('chat.new-session') }}';
const URL_SESSION  = '{{ url('chat/session') }}';
const URL_SEARCH   = '{{ route('chat.search-centers') }}';
const MAX_MSGS     = {{ $maxMsgs }};

// Puter modellar
const MODEL_MAIN   = 'deepseek/deepseek-r1';        // Asosiy — chuqur fikrlash
const MODEL_FAST   = 'deepseek/deepseek-chat';      // Tez — keyword extraction

/* ═══════════════════════════════════════════
   HOLAT
═══════════════════════════════════════════ */
let currentSID   = {{ $currentSession?->id ?? 'null' }};
let sessionFull  = {{ $currentSession?->isFull() ? 'true' : 'false' }};
let msgCount     = {{ $currentSession?->message_count ?? 0 }};

// AI uchun mahalliy tarix (oxirgi 6 xabar, har biri max 400 belgi)
let localHistory = [];
@foreach($messages->take(6) as $m)
localHistory.push({
    role:    '{{ $m->role }}',
    content: @json(mb_substr($m->content, 0, 400))
});
@endforeach

/* ═══════════════════════════════════════════
   SIDEBAR
═══════════════════════════════════════════ */
function openSB()  {
    document.getElementById('sb').classList.add('open');
    document.getElementById('ov').classList.add('show');
}
function closeSB() {
    document.getElementById('sb').classList.remove('open');
    document.getElementById('ov').classList.remove('show');
}

/* ═══════════════════════════════════════════
   YANGI SUHBAT
═══════════════════════════════════════════ */
async function newChat() {
    const r = await api(URL_NEW, 'POST', {});
    if (r.ok) location.href = '{{ route('chat.chat') }}?session=' + r.session_id;
}

/* ═══════════════════════════════════════════
   SESSIYA YUKLASH
═══════════════════════════════════════════ */
async function loadSess(id) {
    closeSB();
    if (id === currentSID) return;

    // Active state
    document.querySelectorAll('.si').forEach(e => e.classList.remove('active'));
    document.getElementById('si-' + id)?.classList.add('active');

    const d = await api(URL_SESSION + '/' + id);
    if (!d.ok) return;

    currentSID  = id;
    sessionFull = d.is_full;
    msgCount    = d.session.message_count || 0;

    // Tarixni yangilash
    localHistory = d.messages.slice(-6).map(m => ({
        role:    m.role,
        content: m.content.substring(0, 400)
    }));

    // Xabarlarni render qilish
    const box = document.getElementById('msgs');
    box.innerHTML = '';

    // Qidiruv indikatorini qayta qo'shish
    const ind = document.createElement('div');
    ind.className = 'search-indicator';
    ind.id = 'search-indicator';
    ind.innerHTML = `<div class="search-dot"></div><div class="search-dot"></div><div class="search-dot"></div><span id="search-text">Markazlar qidirilmoqda...</span>`;
    box.appendChild(ind);

    if (d.messages.length === 0) {
        box.innerHTML += `<div class="empty-state"><div class="empty-icon">💬</div><h3>Bo'sh suhbat</h3><p>Savol yozing...</p></div>`;
    } else {
        d.messages.forEach(m => appendMsg(m.role, m.content, m.created_at, false));
    }

    document.getElementById('tb-title').textContent = d.session.title;
    updProg(msgCount);
    updBanner(sessionFull);
    scrollBot();
}

/* ═══════════════════════════════════════════
   INPUT BOSHQARUV
═══════════════════════════════════════════ */
const inp = document.getElementById('inp');

inp.addEventListener('input', function () {
    this.style.height = 'auto';
    this.style.height = Math.min(this.scrollHeight, 130) + 'px';
    document.getElementById('char-count').textContent = this.value.length + '/2000';
});

inp.addEventListener('keydown', e => {
    if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        send();
    }
});

function fillIn(text) {
    inp.value = text;
    inp.focus();
    inp.dispatchEvent(new Event('input'));
}

/* ═══════════════════════════════════════════
   KEYWORD EXTRACTION
   Faqat markaz qidirish kerakligini aniqlash
   va qidiruv parametrlarini chiqarish
═══════════════════════════════════════════ */
async function extractKeywords(userMsg) {
    const prompt = `Sen o'quv markaz qidiruv tizimining filter modulisan.
Quyidagi foydalanuvchi so'rovini tahlil qil va FAQAT JSON qaytargin. Hech qanday izoh, matn yoki kod bloki yozma.

Qaytariladigan JSON formati:
{
  "needs_search": true,
  "province": "Toshkent",
  "subjects": ["matematika", "fizika"],
  "query": "matematika kursi"
}

Qoidalar:
- needs_search: agar so'rov o'quv markaz, kurs, dars, ta'lim, o'qish, o'qituvchi bilan bog'liq bo'lsa TRUE, aks holda FALSE
- province: faqat quyidagilardan biri yoki null:
  Toshkent, Samarqand, Buxoro, Andijon, Namangan, Farg'ona,
  Qashqadaryo, Surxandaryo, Xorazm, Navoiy, Jizzax, Sirdaryo, Qoraqalpog'iston
- subjects: o'qitiladigan fanlar ro'yxati (matematika, ingliz tili, dasturlash, fizika va h.k.) — topilmasa bo'sh massiv
- query: qidiruv uchun 2-4 ta eng muhim kalit so'z (o'zbek tilida)

Foydalanuvchi so'rovi: "${userMsg}"`;

    try {
        const r    = await puter.ai.chat(prompt, { model: MODEL_FAST, stream: false });
        const text = (r?.message?.content?.[0]?.text || r?.text || '').trim();
        const clean = text.replace(/^```json\s*/i, '').replace(/^```\s*/i, '').replace(/\s*```$/i, '').trim();
        return JSON.parse(clean);
    } catch {
        return { needs_search: false, province: null, subjects: [], query: '' };
    }
}

/* ═══════════════════════════════════════════
   MARKAZLARNI QIDIRISH (MySQL LIKE)
═══════════════════════════════════════════ */
async function searchCenters(kw) {
    showSearchIndicator('Markazlar qidirilmoqda...');
    try {
        const r = await api(URL_SEARCH, 'POST', { keywords: kw });
        hideSearchIndicator();
        return (r.ok && r.count > 0) ? r : null;
    } catch {
        hideSearchIndicator();
        return null;
    }
}

function showSearchIndicator(text) {
    const el = document.getElementById('search-indicator');
    const tx = document.getElementById('search-text');
    if (el) { el.classList.add('show'); if (tx) tx.textContent = text; }
}
function hideSearchIndicator() {
    document.getElementById('search-indicator')?.classList.remove('show');
}

/* ═══════════════════════════════════════════
   ASOSIY YUBORISH FUNKSIYASI
═══════════════════════════════════════════ */
async function send() {
    const msg = inp.value.trim();
    if (!msg) return;
    if (sessionFull) { updBanner(true); return; }

    // Empty state ni olib tashlash
    document.getElementById('empty-state')?.remove();

    // User xabari
    appendMsg('user', msg);

    // Input tozalash
    inp.value = '';
    inp.style.height = 'auto';
    document.getElementById('char-count').textContent = '0/2000';
    document.getElementById('send-btn').disabled = true;
    inp.disabled = true;

    const typingEl = appendTyping();

    try {
        /* ── 1. Keyword extraction ── */
        const kw = await extractKeywords(msg);

        /* ── 2. Markaz qidirish (kerak bo'lsa) ── */
        let centerContext = '';
        let foundCount    = 0;

        if (kw.needs_search) {
            const result = await searchCenters({
                province: kw.province,
                subjects: kw.subjects,
                query:    kw.query || msg,
            });

            if (result) {
                foundCount    = result.count;
                centerContext = result.context;
            }
        }

        /* ── 3. System prompt ── */
        const systemPrompt = buildSystemPrompt(centerContext, foundCount);

        /* ── 4. AI ga yuborish ── */
        const messages = [
            { role: 'system', content: systemPrompt },
            ...localHistory,
            { role: 'user', content: msg }
        ];

        const stream = await puter.ai.chat(messages, { model: MODEL_MAIN, stream: true });

        typingEl.remove();

        const aiEl  = appendMsg('ai', '', true);
        const aiMd  = aiEl.querySelector('.ai-md');
        let fullResp = '';

        for await (const part of stream) {
            if (part?.text) {
                fullResp += part.text;
                aiMd.innerHTML = marked.parse(fullResp);
                scrollBot();
            }
        }

        /* ── 5. Mahalliy tarixni yangilash ── */
        localHistory.push({ role: 'user',      content: msg.substring(0, 400) });
        localHistory.push({ role: 'assistant', content: fullResp.substring(0, 400) });
        if (localHistory.length > 12) localHistory = localHistory.slice(-12);

        /* ── 6. DB ga saqlash ── */
        const saved = await api(URL_SAVE, 'POST', {
            session_id:   currentSID,
            user_message: msg,
            ai_response:  fullResp,
            model:        MODEL_MAIN,
        });

        if (saved.ok) {
            currentSID  = saved.session_id;
            msgCount   += 2;
            sessionFull = saved.is_full;
            updProg(msgCount);
            updBanner(sessionFull);
            updSidebarItem(currentSID, msg, msgCount, sessionFull);
        }

    } catch (err) {
        typingEl?.remove();
        hideSearchIndicator();
        appendMsg('ai', '❌ Xatolik yuz berdi. Iltimos, qaytadan urinib ko\'ring.');
        console.error(err);
    } finally {
        document.getElementById('send-btn').disabled = false;
        inp.disabled = false;
        inp.focus();
    }
}

/* ═══════════════════════════════════════════
   SYSTEM PROMPT YARATISH
   Markaz ma'lumotlari bo'lsa — tafsiya rejimi
   Bo'lmasa — umumiy maslahat rejimi
═══════════════════════════════════════════ */
function buildSystemPrompt(centerContext, foundCount) {
    const today = new Date().toLocaleDateString('uz-UZ', { year:'numeric', month:'long', day:'numeric' });

    const base = `Siz O'zbekistondagi ta'lim sohasida ixtisoslashgan AI maslahatchi bo'lgan "EduBot"siz.
Bugun: ${today}
Til: faqat O'zbek tilida javob bering.
Uslub: samimiy, aniq, foydali. Keraksiz uzun so'zlardan saqlaning.`;

    if (centerContext && foundCount > 0) {
        return `${base}

VAZIFA: Foydalanuvchi o'quv markaz haqida so'radi. Quyida ma'lumotlar bazasidan topilgan ${foundCount} ta eng mos markaz berilgan.

=== MARKAZLAR MA'LUMOTI ===
${centerContext}
=== MA'LUMOT TUGADI ===

Javob berish qoidalari:
1. FAQAT yuqoridagi ro'yxatdagi markazlarni tavsiya qiling — o'zingizdan markaz to'qimang
2. Har bir tavsiya uchun quyidagi formatda yozing:
   **[Markaz nomi]** — [Viloyat, Tuman]
   • Fanlar: [fanlar va narxlar]
   • [Qo'shimcha muhim ma'lumot]
3. Agar foydalanuvchining talabiga mos markaz topilmasa — "Afsuski, [shart] bo'yicha mos markaz topilmadi" deb ayting
4. Tavsiyadan keyin qisqa maslahat bering (qaysi mezonlar bo'yicha tanlash kerak)
5. Markazlarni student_count (o'quvchilar soni) ko'p bo'lgani yaxshiroq deb hisoblang`;
    }

    return `${base}

VAZIFA: Foydalanuvchiga ta'lim va o'quv markazlar haqida umumiy maslahat bering.

Qila oladigan narsalaringiz:
- O'quv markaz tanlash bo'yicha maslahat
- Fan va kurslar haqida ma'lumot
- O'qish metodlari va maslahatlar
- O'zbekistondagi ta'lim tizimi haqida

Agar foydalanuvchi muayyan viloyat yoki fan bo'yicha markaz so'rasa:
"[Viloyat]da [fan] bo'yicha markazlarni qidirish uchun aniqroq yozing" deb yo'naltiring.`;
}

/* ═══════════════════════════════════════════
   DOM YORDAMCHI FUNKSIYALAR
═══════════════════════════════════════════ */
function appendMsg(role, content, time, isStreaming = false) {
    const box  = document.getElementById('msgs');
    const t    = time || new Date().toLocaleTimeString('uz', { hour: '2-digit', minute: '2-digit' });
    const div  = document.createElement('div');
    div.className = 'msg ' + role;

    if (role === 'user') {
        div.innerHTML = `
            <div class="avatar">S</div>
            <div class="msg-body">
                <div class="bubble">${esc(content)}</div>
                <div class="msg-time">${t}</div>
            </div>`;
    } else {
        div.innerHTML = `
            <div class="avatar">AI</div>
            <div class="msg-body">
                <div class="bubble">
                    <div class="ai-md">${isStreaming ? '' : marked.parse(content)}</div>
                </div>
                <div class="msg-time">${t}</div>
            </div>`;
    }

    box.appendChild(div);
    scrollBot();
    return div;
}

function appendTyping() {
    const box = document.getElementById('msgs');
    const div = document.createElement('div');
    div.className = 'msg ai';
    div.id = 'typing-indicator';
    div.innerHTML = `
        <div class="avatar">AI</div>
        <div class="msg-body">
            <div class="bubble">
                <div class="dots"><span></span><span></span><span></span></div>
            </div>
        </div>`;
    box.appendChild(div);
    scrollBot();
    return div;
}

function scrollBot() {
    const b = document.getElementById('msgs');
    b.scrollTop = b.scrollHeight;
}

function esc(t) {
    const d = document.createElement('div');
    d.textContent = t;
    return d.innerHTML;
}

/* ═══════════════════════════════════════════
   UI YANGILASH
═══════════════════════════════════════════ */
function updProg(n) {
    const pct = Math.min(n / MAX_MSGS * 100, 100);
    document.getElementById('prog-fill').style.width = pct + '%';
    document.getElementById('prog-txt').textContent  = n + '/' + MAX_MSGS;
    document.getElementById('tb-sub').textContent    = n + '/' + MAX_MSGS + ' xabar';
}

function updBanner(isFull) {
    const b = document.getElementById('full-banner');
    isFull ? b.classList.add('show') : b.classList.remove('show');
}

function updSidebarItem(id, lastMsg, count, isFull) {
    document.getElementById('sess-empty')?.remove();
    document.querySelectorAll('.si').forEach(e => e.classList.remove('active'));

    let el = document.getElementById('si-' + id);

    if (!el) {
        el = document.createElement('div');
        el.className = 'si active';
        el.id = 'si-' + id;
        el.onclick = () => loadSess(id);
        el.innerHTML = `
            <div class="si-title">${esc(lastMsg.substring(0, 42))}</div>
            <div class="si-meta">
                <span class="bdg b-a">Faol</span>
                <span>${count}/${MAX_MSGS}</span>
            </div>
            <div class="si-prev">${esc(lastMsg.substring(0, 48))}</div>`;
        document.getElementById('sess-list').prepend(el);
    } else {
        el.classList.add('active');
        const meta = el.querySelector('.si-meta');
        if (meta) {
            meta.innerHTML = `
                <span class="bdg ${isFull ? 'b-c' : 'b-a'}">${isFull ? 'Yopiq' : 'Faol'}</span>
                <span>${count}/${MAX_MSGS}</span>`;
        }
        const prev = el.querySelector('.si-prev');
        if (prev) prev.textContent = lastMsg.substring(0, 48);
    }
}

/* ═══════════════════════════════════════════
   API FETCH YORDAMCHISI
═══════════════════════════════════════════ */
async function api(url, method = 'GET', body = null) {
    const opts = {
        method,
        headers: {
            'X-CSRF-TOKEN':  CSRF,
            'Content-Type':  'application/json',
        },
    };
    if (body && method !== 'GET') opts.body = JSON.stringify(body);
    const r = await fetch(url, opts);
    return r.json();
}

/* ═══════════════════════════════════════════
   INIT
═══════════════════════════════════════════ */
window.addEventListener('load', () => {
    scrollBot();
    inp.focus();
});
</script>

</x-minimal-layout>