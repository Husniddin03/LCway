<x-layout>
    <x-slot:title>AI Maslahatchi</x-slot:title>

    @php $maxMsgs = \App\Models\ChatSession::MAX_MESSAGES; @endphp

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap');

        .ai-md p {
            margin-bottom: .5rem;
        }

        .ai-md p:last-child {
            margin-bottom: 0;
        }

        .ai-md h1,
        .ai-md h2,
        .ai-md h3 {
            color: #f1f5f9;
            margin: .8rem 0 .35rem;
            font-size: .95rem;
        }

        .ai-md ul,
        .ai-md ol {
            margin: .35rem 0 .35rem 1.25rem;
        }

        .ai-md li {
            margin-bottom: .3rem;
        }

        .ai-md strong {
            color: #f1f5f9;
        }

        .ai-md a {
            color: #3b82f6;
            text-decoration: underline;
        }

        .ai-md code {
            font-family: 'JetBrains Mono', monospace;
            font-size: .79rem;
            background: rgba(255, 255, 255, .07);
            padding: 1px 5px;
            border-radius: 4px;
            color: #93c5fd;
        }

        .ai-md pre {
            background: rgba(0, 0, 0, .4);
            border: 1px solid #374151;
            border-radius: 8px;
            padding: .85rem;
            overflow-x: auto;
            margin: .5rem 0;
        }

        .ai-md pre code {
            background: none;
            padding: 0;
            color: #d1d5db;
        }

        .ai-md table {
            width: 100%;
            border-collapse: collapse;
            font-size: .82rem;
            margin: .5rem 0;
        }

        .ai-md th,
        .ai-md td {
            padding: .4rem .65rem;
            border: 1px solid #374151;
            text-align: left;
        }

        .ai-md th {
            background: rgba(255, 255, 255, .04);
            color: #f9fafb;
        }

        .ai-md hr {
            border: none;
            border-top: 1px solid #374151;
            margin: .75rem 0;
        }

        .center-tag {
            display: inline-block;
            padding: 2px 8px;
            background: rgba(59, 130, 246, .12);
            border: 1px solid rgba(59, 130, 246, .2);
            border-radius: 6px;
            font-size: .72rem;
            color: #3b82f6;
            margin: 2px 2px 2px 0;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(8px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        /* Light mode styles */
        .light-mode .bg-slate-950 {
            background-color: #ffffff !important;
        }

        .light-mode .bg-slate-800 {
            background-color: #f8fafc !important;
        }

        .light-mode .bg-slate-800\/50 {
            background-color: rgba(248, 250, 252, 0.5) !important;
        }

        .light-mode .bg-slate-900 {
            background-color: #ffffff !important;
        }

        .light-mode .bg-slate-700\/10 {
            background-color: rgba(241, 245, 249, 0.1) !important;
        }

        .light-mode .bg-slate-700\/30 {
            background-color: rgba(241, 245, 249, 0.3) !important;
        }

        .light-mode .bg-slate-800\/50 {
            background-color: rgba(248, 250, 252, 0.5) !important;
        }

        .light-mode .text-slate-300 {
            color: #475569 !important;
        }

        .light-mode .text-slate-100 {
            color: #1e293b !important;
        }

        .light-mode .text-slate-500 {
            color: #64748b !important;
        }

        .light-mode .text-slate-400 {
            color: #64748b !important;
        }

        .light-mode .border-slate-700 {
            border-color: #e2e8f0 !important;
        }

        .light-mode .border-slate-600 {
            border-color: #cbd5e1 !important;
        }

        .light-mode .border-slate-500\/20 {
            border-color: rgba(59, 130, 246, 0.2) !important;
        }

        .light-mode .bg-blue-500\/10 {
            background-color: rgba(59, 130, 246, 0.1) !important;
        }

        .light-mode .bg-blue-500\/20 {
            background-color: rgba(59, 130, 246, 0.2) !important;
        }

        .light-mode .text-blue-500 {
            color: #3b82f6 !important;
        }

        .light-mode .border-blue-500\/22 {
            border-color: rgba(59, 130, 246, 0.22) !important;
        }

        .light-mode .border-blue-500 {
            border-color: #3b82f6 !important;
        }

        .light-mode .bg-emerald-500\/15 {
            background-color: rgba(16, 185, 129, 0.15) !important;
        }

        .light-mode .text-emerald-500 {
            color: #10b981 !important;
        }

        .light-mode .bg-red-500\/8 {
            background-color: rgba(239, 68, 68, 0.08) !important;
        }

        .light-mode .border-red-500\/15 {
            border-color: rgba(239, 68, 68, 0.15) !important;
        }

        .light-mode .text-red-400 {
            color: #ef4444 !important;
        }

        .light-mode .bg-gradient-to-r {
            background: linear-gradient(135deg, #3b82f6, #8b5cf6) !important;
        }

        /* Dark mode - default (slate colors already work) */
        .dark-mode .ai-md h1,
        .dark-mode .ai-md h2,
        .dark-mode .ai-md h3 {
            color: #f1f5f9;
        }

        .dark-mode .ai-md strong {
            color: #f1f5f9;
        }

        .dark-mode .ai-md a {
            color: #3b82f6;
        }

        .dark-mode .center-tag {
            background: rgba(59, 130, 246, .12);
            border: 1px solid rgba(59, 130, 246, .2);
            color: #3b82f6;
        }
    </style>

    {{-- Overlay --}}
    <div class="hidden fixed inset-0 bg-black/55 z-[39] md:hidden" id="ov" onclick="closeSB()"></div>

    <div class="font-inter bg-slate-950 h-screen flex overflow-hidden text-slate-300 dark-mode" id="chat-container">

        {{-- ═══════════════ SIDEBAR ═══════════════ --}}
        <aside
            class="w-[280px] bg-slate-800 border-r border-slate-700 flex flex-col flex-shrink-0 transition-transform duration-300 ease-[cubic-bezier(0.4,0,0.2,1)] z-40 md:relative fixed top-0 left-0 h-full -translate-x-full md:translate-x-0"
            id="sb">
            <div class="p-4 border-b border-slate-700 flex items-center gap-2.5">
                <div
                    class="w-8.5 h-8.5 bg-gradient-to-r from-blue-500 to-purple-500 rounded-lg flex items-center justify-center text-base flex-shrink-0">
                    🤖</div>
                <span class="text-sm font-bold text-slate-100">AI Maslahatchi</span>
            </div>

            <button
                class="mx-4 my-3 w-[calc(100%-2rem)] px-4 py-2.5 flex items-center gap-2 bg-blue-500/10 border border-blue-500/22 rounded-lg text-blue-500 text-sm font-semibold transition-all duration-180 hover:bg-blue-500/20 hover:border-blue-500"
                onclick="newChat()">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2.5">
                    <path d="M12 5v14M5 12h14" />
                </svg>
                Yangi suhbat
            </button>

            <div class="px-4 py-2 text-[10px] font-bold tracking-widest uppercase text-slate-500">Suhbatlar tarixi</div>

            <div class="flex-1 overflow-y-auto p-2" id="sess-list">
                @forelse($sessions as $s)
                    <div class="p-2.5 px-3 rounded-lg cursor-pointer transition-colors duration-150 mb-0.5 border border-transparent hover:bg-white/4 {{ $currentSession?->id == $s->id ? 'bg-blue-500/10 border-blue-500/20' : '' }}"
                        id="si-{{ $s->id }}" onclick="loadSess({{ $s->id }})">
                        <div class="text-xs font-medium text-slate-100 truncate mb-1">{{ $s->title }}</div>
                        <div class="flex items-center gap-1 text-[10px] text-slate-500">
                            <span
                                class="text-[9px] font-bold px-1 py-0.5 rounded {{ $s->status === 'active' ? 'bg-emerald-500/15 text-emerald-500' : 'bg-white/6 text-slate-500' }}">
                                {{ $s->status === 'active' ? 'Faol' : 'Yopiq' }}
                            </span>
                            <span>{{ $s->message_count }}/{{ $maxMsgs }}</span>
                            <span>{{ $s->created_at->format('d.m') }}</span>
                        </div>
                        @if ($s->lastMessage)
                            <div class="text-[11px] text-slate-500 truncate mt-0.5">
                                {{ Str::limit($s->lastMessage->content, 48) }}</div>
                        @endif
                    </div>
                @empty
                    <div id="sess-empty" class="p-6 text-center text-xs text-slate-500">
                        Hali suhbat yo'q
                    </div>
                @endforelse
            </div>
        </aside>

        {{-- ═══════════════ MAIN ═══════════════ --}}
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

            <!-- Topbar -->
            <div class="p-3 bg-slate-800/50 border-b border-slate-700 flex items-center gap-3 flex-shrink-0">
                <button class="flex text-slate-300 p-1 items-center md:hidden" onclick="openSB()">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <line x1="3" y1="6" x2="21" y2="6" />
                        <line x1="3" y1="12" x2="21" y2="12" />
                        <line x1="3" y1="18" x2="21" y2="18" />
                    </svg>
                </button>
                <div class="flex-1 min-w-0">
                    <div class="text-sm font-semibold text-slate-100 truncate" id="tb-title">
                        {{ $currentSession?->title ?? 'AI Maslahatchi' }}</div>
                    <div class="text-xs text-slate-500 mt-0.5" id="tb-sub">
                        {{ $currentSession ? $currentSession->message_count . '/' . $maxMsgs . ' xabar' : 'Yangi suhbat boshlang' }}
                    </div>
                </div>
                <div class="flex items-center gap-2 w-28 flex-shrink-0">
                    <div class="flex-1 h-0.5 bg-slate-700 rounded-sm overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-blue-500 to-purple-500 rounded-sm transition-all duration-300"
                            id="prog-fill"
                            style="width:{{ $currentSession ? round(($currentSession->message_count / $maxMsgs) * 100) : 0 }}%">
                        </div>
                    </div>
                    <span class="text-[10px] text-slate-500 whitespace-nowrap font-mono"
                        id="prog-txt">{{ $currentSession?->message_count ?? 0 }}/{{ $maxMsgs }}</span>
                </div>
            </div>

            <!-- To'lganlik banneri -->
            <div class="hidden p-2 bg-red-500/8 border-b border-red-500/15 text-sm text-red-400 items-center gap-2 flex-shrink-0 {{ $currentSession?->isFull() ? 'flex' : '' }}"
                id="full-banner">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2">
                    <circle cx="12" cy="12" r="10" />
                    <line x1="12" y1="8" x2="12" y2="12" />
                    <line x1="12" y1="16" x2="12.01" y2="16" />
                </svg>
                Bu suhbat to'ldi ({{ $maxMsgs }} xabar).
                <button onclick="newChat()" class="text-blue-500 underline text-xs ml-1">
                    Yangi suhbat ochish →
                </button>
            </div>

            {{-- Messages --}}
            <div class="flex-1 overflow-y-auto p-6 flex flex-col gap-3.5 scroll-smooth" id="msgs">

                {{-- Qidiruv indikatori --}}
                <div class="hidden p-2 px-3 bg-blue-500/8 border border-blue-500/15 rounded-lg text-sm text-blue-500 items-center gap-2 mb-2 animate-fadeUp"
                    id="search-indicator">
                    <div class="w-1.5 h-1.5 bg-blue-500 rounded-full animate-bounce"></div>
                    <div class="w-1.5 h-1.5 bg-blue-500 rounded-full animate-bounce" style="animation-delay:.15s"></div>
                    <div class="w-1.5 h-1.5 bg-blue-500 rounded-full animate-bounce" style="animation-delay:.3s"></div>
                    <span id="search-text">Markazlar qidirilmoqda...</span>
                </div>

                @if ($messages->isEmpty())
                    <div class="flex-1 flex flex-col items-center justify-center text-center gap-3 p-8 animate-fadeUp"
                        id="empty-state">
                        <div
                            class="w-16 h-16 bg-gradient-to-r from-blue-500/12 to-purple-500/12 border border-blue-500/18 rounded-xl flex items-center justify-center text-2xl">
                            💬</div>
                        <h3 class="text-base font-semibold text-slate-100">Salom! Men AI maslahatchi</h3>
                        <p class="text-xs text-slate-500 max-w-[300px] leading-relaxed">O'quv markazlar, kurslar va
                            ta'lim haqida savol bering</p>
                        <div class="flex flex-wrap gap-1 justify-center mt-1">
                            <button
                                class="px-3.5 py-1.5 bg-slate-800/50 border border-slate-600 rounded-full text-xs text-slate-300 cursor-pointer transition-all duration-150 hover:border-blue-500 hover:text-blue-500 hover:bg-blue-500/6"
                                onclick="fillIn(this.textContent)">Toshkentda matematika kurslari</button>
                            <button
                                class="px-3.5 py-1.5 bg-slate-800/50 border border-slate-600 rounded-full text-xs text-slate-300 cursor-pointer transition-all duration-150 hover:border-blue-500 hover:text-blue-500 hover:bg-blue-500/6"
                                onclick="fillIn(this.textContent)">Ingliz tili o'rganmoqchiman</button>
                            <button
                                class="px-3.5 py-1.5 bg-slate-800/50 border border-slate-600 rounded-full text-xs text-slate-300 cursor-pointer transition-all duration-150 hover:border-blue-500 hover:text-blue-500 hover:bg-blue-500/6"
                                onclick="fillIn(this.textContent)">Dasturlash kurslari qayerda?</button>
                            <button
                                class="px-3.5 py-1.5 bg-slate-800/50 border border-slate-600 rounded-full text-xs text-slate-300 cursor-pointer transition-all duration-150 hover:border-blue-500 hover:text-blue-500 hover:bg-blue-500/6"
                                onclick="fillIn(this.textContent)">Arzon o'quv markazlar</button>
                            <button
                                class="px-3.5 py-1.5 bg-slate-800/50 border border-slate-600 rounded-full text-xs text-slate-300 cursor-pointer transition-all duration-150 hover:border-blue-500 hover:text-blue-500 hover:bg-blue-500/6"
                                onclick="fillIn(this.textContent)">Samarqandda IT kurslari</button>
                            <button
                                class="px-3.5 py-1.5 bg-slate-800/50 border border-slate-600 rounded-full text-xs text-slate-300 cursor-pointer transition-all duration-150 hover:border-blue-500 hover:text-blue-500 hover:bg-blue-500/6"
                                onclick="fillIn(this.textContent)">Qaysi o'quv markaz yaxshi?</button>
                        </div>
                    </div>
                @else
                    @foreach ($messages as $m)
                        <div class="flex gap-2.5 animate-fadeUp {{ $m->role === 'user' ? 'flex-row-reverse' : '' }}">
                            <div
                                class="w-8 h-8 rounded-full flex items-center justify-center text-[10px] font-bold flex-shrink-0 font-mono {{ $m->role === 'user' ? 'bg-gradient-to-r from-blue-500 to-purple-500 text-white' : 'bg-slate-800/50 border border-slate-600 text-blue-500' }}">
                                {{ $m->role === 'user' ? 'S' : 'AI' }}</div>
                            <div class="max-w-[74%] flex flex-col {{ $m->role === 'user' ? 'items-end' : '' }}">
                                <div
                                    class="px-4 py-3 rounded-[14px] text-sm leading-relaxed {{ $m->role === 'user' ? 'bg-gradient-to-r from-blue-500 to-purple-500 text-white rounded-br-sm' : 'bg-slate-800/50 border border-slate-600 text-slate-300 rounded-bl-sm' }}">
                                    @if ($m->role === 'assistant')
                                        <div class="ai-md">{!! \Illuminate\Support\Str::markdown($m->content) !!}</div>
                                    @else
                                        {{ $m->content }}
                                    @endif
                                </div>
                                <div class="text-[10px] text-slate-500 mt-1 px-0.5">
                                    {{ $m->created_at->format('H:i') }}</div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            {{-- Input --}}
            <div class="p-4 bg-slate-800/50 border-t border-slate-600 flex-shrink-0">
                <div
                    class="flex gap-1.5 items-end bg-slate-950 border border-slate-600 rounded-[14px] px-3.5 py-2.5 transition-colors duration-200 focus-within:border-blue-500">
                    <textarea id="inp"
                        class="flex-1 bg-transparent border-none outline-none text-slate-100 text-sm leading-relaxed resize-none min-6 max-32 p-0"
                        placeholder="Savol yozing... (masalan: Toshkentda ingliz tili kursi)" rows="1"></textarea>
                    <button
                        class="w-9 h-9 rounded-lg bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center flex-shrink-0 transition-all duration-180 shadow-lg shadow-blue-500/28 hover:scale-105 hover:shadow-xl hover:shadow-blue-500/42 disabled:opacity-40 disabled:cursor-not-allowed disabled:transform-none"
                        id="send-btn" onclick="send()">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" class="text-white">
                            <line x1="22" y1="2" x2="11" y2="13" />
                            <polygon points="22 2 15 22 11 13 2 9 22 2" />
                        </svg>
                    </button>
                </div>
                <div class="flex justify-between items-center mt-2 px-0.5 text-xs text-slate-500">
                    <span><kbd
                            class="bg-slate-950 border border-slate-600 rounded px-1 py-0.5 font-mono text-[9px] text-slate-300">Enter</kbd>
                        yuborish · <kbd
                            class="bg-slate-950 border border-slate-600 rounded px-1 py-0.5 font-mono text-[9px] text-slate-300">Shift+Enter</kbd>
                        yangi qator</span>
                    <span id="char-count" class="font-mono">0/2000</span>
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
        const CSRF = '{{ csrf_token() }}';
        const URL_SAVE = '{{ route('chat.save') }}';
        const URL_NEW = '{{ route('chat.new-session') }}';
        const URL_SESSION = '{{ url('chat/session') }}';
        const URL_SEARCH = '{{ route('chat.search-centers') }}';
        const MAX_MSGS = {{ $maxMsgs }};

        // Puter modellar
        const MODEL_MAIN = 'deepseek/deepseek-r1'; // Asosiy — chuqur fikrlash
        const MODEL_FAST = 'deepseek/deepseek-chat'; // Tez — keyword extraction

        /* ═══════════════════════════════════════════
           THEME MANAGEMENT
        ═══════════════════════════════════════════ */
        function initTheme() {
            const container = document.getElementById('chat-container');
            const saved = localStorage.getItem('chat-theme');

            // Check if user has saved preference
            if (saved === 'light') {
                container.classList.remove('dark-mode');
                container.classList.add('light-mode');
            } else {
                container.classList.remove('light-mode');
                container.classList.add('dark-mode');
                localStorage.setItem('chat-theme', 'dark'); // default to dark
            }
        }

        function toggleTheme() {
            const container = document.getElementById('chat-container');
            const isDark = container.classList.contains('dark-mode');

            if (isDark) {
                container.classList.remove('dark-mode');
                container.classList.add('light-mode');
                localStorage.setItem('chat-theme', 'light');
            } else {
                container.classList.remove('light-mode');
                container.classList.add('dark-mode');
                localStorage.setItem('chat-theme', 'dark');
            }
        }

        // Add theme toggle button
        function addThemeToggle() {
            const topbar = document.querySelector('.p-3.bg-slate-800\/50');
            if (!topbar) return;

            const toggleBtn = document.createElement('button');
            toggleBtn.className =
                'w-8 h-8 rounded-lg bg-slate-700\/50 border border-slate-600 flex items-center justify-center flex-shrink-0 transition-all duration-200 hover:bg-slate-600\/50 hover:border-slate-500';
            toggleBtn.onclick = toggleTheme;
            toggleBtn.title = 'Tungi/Kunduzgi rejim';
            toggleBtn.innerHTML = `
        <svg class="w-4 h-4 text-slate-300 dark-mode-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
        </svg>
        <svg class="w-4 h-4 text-slate-300 light-mode-icon hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
        </svg>
    `;

            // Insert before the last element in topbar
            const lastChild = topbar.lastElementChild;
            topbar.insertBefore(toggleBtn, lastChild);

            // Update icon based on current theme
            updateThemeIcon();
        }

        function updateThemeIcon() {
            const container = document.getElementById('chat-container');
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
        };
        let currentSID = {{ $currentSession?->id ?? 'null' }};
        let sessionFull = {{ $currentSession?->isFull() ? 'true' : 'false' }};
        let msgCount = {{ $currentSession?->message_count ?? 0 }};

        // AI uchun mahalliy tarix (oxirgi 6 xabar, har biri max 400 belgi)
        let localHistory = [];
        @foreach ($messages->take(6) as $m)
            localHistory.push({
                role: '{{ $m->role }}',
                content: @json(mb_substr($m->content, 0, 400))
            });
        @endforeach

        /* ═══════════════════════════════════════════
           SIDEBAR
        ═══════════════════════════════════════════ */
        function openSB() {
            document.getElementById('sb').classList.remove('-translate-x-full');
            document.getElementById('sb').classList.add('translate-x-0', 'shadow-2xl');
            document.getElementById('ov').classList.remove('hidden');
            document.getElementById('ov').classList.add('block');
        }

        function closeSB() {
            document.getElementById('sb').classList.add('-translate-x-full');
            document.getElementById('sb').classList.remove('translate-x-0', 'shadow-2xl');
            document.getElementById('ov').classList.add('hidden');
            document.getElementById('ov').classList.remove('block');
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
            document.querySelectorAll('.group\/\[280px\] > div > div > div').forEach(e => {
                e.classList.remove('bg-blue-500/10', 'border-blue-500/20');
                e.classList.add('border-transparent', 'hover:bg-white\/4');
            });
            const activeEl = document.getElementById('si-' + id);
            if (activeEl) {
                activeEl.classList.remove('border-transparent', 'hover:bg-white/4');
                activeEl.classList.add('bg-blue-500/10', 'border-blue-500/20');
            }

            const d = await api(URL_SESSION + '/' + id);
            if (!d.ok) return;

            currentSID = id;
            sessionFull = d.is_full;
            msgCount = d.session.message_count || 0;

            // Tarixni yangilash
            localHistory = d.messages.slice(-6).map(m => ({
                role: m.role,
                content: m.content.substring(0, 400)
            }));

            // Xabarlarni render qilish
            const box = document.getElementById('msgs');
            box.innerHTML = '';

            // Qidiruv indikatorini qayta qo'shish
            const ind = document.createElement('div');
            ind.className =
                'hidden p-2 px-3 bg-blue-500/8 border border-blue-500/15 rounded-lg text-sm text-blue-500 items-center gap-2 mb-2 animate-fadeUp';
            ind.id = 'search-indicator';
            ind.innerHTML =
                `<div class="w-1.5 h-1.5 bg-blue-500 rounded-full animate-bounce"></div><div class="w-1.5 h-1.5 bg-blue-500 rounded-full animate-bounce" style="animation-delay:.15s"></div><div class="w-1.5 h-1.5 bg-blue-500 rounded-full animate-bounce" style="animation-delay:.3s"></div><span id="search-text">Markazlar qidirilmoqda...</span>`;
            box.appendChild(ind);

            if (d.messages.length === 0) {
                box.innerHTML +=
                    `<div class="empty-state"><div class="empty-icon">💬</div><h3>Bo'sh suhbat</h3><p>Savol yozing...</p></div>`;
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

        inp.addEventListener('input', function() {
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
                const r = await puter.ai.chat(prompt, {
                    model: MODEL_FAST,
                    stream: false
                });
                const text = (r?.message?.content?.[0]?.text || r?.text || '').trim();
                const clean = text.replace(/^```json\s*/i, '').replace(/^```\s*/i, '').replace(/\s*```$/i, '').trim();
            return JSON.parse(clean);
        } catch {
            return {
                needs_search: false,
                province: null,
                subjects: [],
                query: ''
            };
        }
    }

    /* ═══════════════════════════════════════════
       MARKAZLARNI QIDIRISH (MySQL LIKE)
    ═══════════════════════════════════════════ */
    async function searchCenters(kw) {
        showSearchIndicator('Markazlar qidirilmoqda...');
        try {
            const r = await api(URL_SEARCH, 'POST', {
                keywords: kw
            });
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
        if (el) {
            el.classList.remove('hidden');
            el.classList.add('flex');
            if (tx) tx.textContent = text;
        }
    }

    function hideSearchIndicator() {
        const el = document.getElementById('search-indicator');
        if (el) {
            el.classList.add('hidden');
            el.classList.remove('flex');
        }
    }

    /* ═══════════════════════════════════════════
       ASOSIY YUBORISH FUNKSIYASI
    ═══════════════════════════════════════════ */
    async function send() {
        const msg = inp.value.trim();
        if (!msg) return;
        if (sessionFull) {
            updBanner(true);
            return;
        }

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
            let foundCount = 0;

            if (kw.needs_search) {
                const result = await searchCenters({
                    province: kw.province,
                    subjects: kw.subjects,
                    query: kw.query || msg,
                });

                if (result) {
                    foundCount = result.count;
                    centerContext = result.context;
                }
            }

            /* ── 3. System prompt ── */
            const systemPrompt = buildSystemPrompt(centerContext, foundCount);

            /* ── 4. AI ga yuborish ── */
            const messages = [{
                    role: 'system',
                    content: systemPrompt
                },
                ...localHistory,
                {
                    role: 'user',
                    content: msg
                }
            ];

            const stream = await puter.ai.chat(messages, {
                model: MODEL_MAIN,
                stream: true
            });

            typingEl.remove();

            const aiEl = appendMsg('ai', '', true);
            const aiMd = aiEl.querySelector('.ai-md');
            let fullResp = '';

            for await (const part of stream) {
                if (part?.text) {
                    fullResp += part.text;
                    aiMd.innerHTML = marked.parse(fullResp);
                    scrollBot();
                }
            }

            /* ── 5. Mahalliy tarixni yangilash ── */
            localHistory.push({
                role: 'user',
                content: msg.substring(0, 400)
            });
            localHistory.push({
                role: 'assistant',
                content: fullResp.substring(0, 400)
            });
            if (localHistory.length > 12) localHistory = localHistory.slice(-12);

            /* ── 6. DB ga saqlash ── */
            const saved = await api(URL_SAVE, 'POST', {
                session_id: currentSID,
                user_message: msg,
                ai_response: fullResp,
                model: MODEL_MAIN,
            });

            if (saved.ok) {
                currentSID = saved.session_id;
                msgCount += 2;
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
        const today = new Date().toLocaleDateString('uz-UZ', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });

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
        const box = document.getElementById('msgs');
        const t = time || new Date().toLocaleTimeString('uz', {
            hour: '2-digit',
            minute: '2-digit'
        });
        const div = document.createElement('div');
        div.className = `flex gap-2.5 animate-fadeUp ${role === 'user' ? 'flex-row-reverse' : ''}`;

        const avatar = document.createElement('div');
        avatar.className =
            `w-8 h-8 rounded-full flex items-center justify-center text-[10px] font-bold flex-shrink-0 font-mono ${role === 'user' ? 'bg-gradient-to-r from-blue-500 to-purple-500 text-white' : 'bg-slate-800/50 border border-slate-600 text-blue-500'}`;
        avatar.textContent = role === 'user' ? 'S' : 'AI';

        const body = document.createElement('div');
        body.className = `max-w-[74%] flex flex-col ${role === 'user' ? 'items-end' : ''}`;

        const bubble = document.createElement('div');
        bubble.className =
            `px-4 py-3 rounded-[14px] text-sm leading-relaxed ${role === 'user' ? 'bg-gradient-to-r from-blue-500 to-purple-500 text-white rounded-br-sm' : 'bg-slate-800/50 border border-slate-600 text-slate-300 rounded-bl-sm'}`;
        if (role === 'assistant') {
            bubble.innerHTML = `<div class="ai-md">${isStreaming ? '' : marked.parse(content)}</div>`;
        } else {
            bubble.textContent = content;
        }

        const msgTime = document.createElement('div');
        msgTime.className = 'text-[10px] text-slate-500 mt-1 px-0.5';
        msgTime.textContent = time ? (new Date(time)).toLocaleTimeString('uz-UZ', {
            hour: '2-digit',
            minute: '2-digit'
        }) : (new Date()).toLocaleTimeString('uz-UZ', {
            hour: '2-digit',
            minute: '2-digit'
        });

        body.appendChild(bubble);
        body.appendChild(msgTime);
        div.appendChild(avatar);
        div.appendChild(body);
        box.appendChild(div);

        scrollBot();
        return div;
    }

    function appendTyping() {
        const box = document.getElementById('msgs');
        const div = document.createElement('div');
        div.className = 'flex gap-2.5 animate-fadeUp';

        const avatar = document.createElement('div');
        avatar.className =
            'w-8 h-8 rounded-full flex items-center justify-center text-[10px] font-bold flex-shrink-0 font-mono bg-slate-800/50 border border-slate-600 text-blue-500';
        avatar.textContent = 'AI';

        const body = document.createElement('div');
        body.className = 'max-w-[74%] flex flex-col';

        const bubble = document.createElement('div');
        bubble.className =
            'px-4 py-3 rounded-[14px] text-sm leading-relaxed bg-slate-800/50 border border-slate-600 text-slate-300 rounded-bl-sm';
        bubble.innerHTML =
            '<div class="flex gap-1 items-center p-0.5"><span class="w-1.5 h-1.5 bg-blue-500 rounded-full animate-bounce"></span><span class="w-1.5 h-1.5 bg-blue-500 rounded-full animate-bounce" style="animation-delay:.2s"></span><span class="w-1.5 h-1.5 bg-blue-500 rounded-full animate-bounce" style="animation-delay:.4s"></span></div>';

        body.appendChild(bubble);
        div.appendChild(avatar);
        div.appendChild(body);
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
        document.getElementById('prog-txt').textContent = n + '/' + MAX_MSGS;
        document.getElementById('tb-sub').textContent = n + '/' + MAX_MSGS + ' xabar';
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
                    'X-CSRF-TOKEN': CSRF,
                    'Content-Type': 'application/json',
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
            initTheme();
            addThemeToggle();
            scrollBot();
            inp.focus();
        });
    </script>

</x-layout>
