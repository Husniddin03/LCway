<x-layout>
    <x-slot:title>
        AI dan maslahat oling
    </x-slot>

    <!-- ===== Contact Start ===== -->
    <section id="support" class="i pg fh rm ji gp uq">
        <!-- Bg Shapes -->
        <img src="{{ asset('images/shape-06.svg') }}" alt="Shape" class="h aa y" />
        <img src="{{ asset('images/shape-03.svg') }}" alt="Shape" class="h ca u" />
        <img src="{{ asset('images/shape-07.svg') }}" alt="Shape" class="h w da ee" />
        <img src="{{ asset('images/shape-12.svg') }}" alt="Shape" class="h p s" />
        <img src="{{ asset('images/shape-13.svg') }}" alt="Shape" class="h r q" />

        <!-- Section Title Start -->
        <div x-data="{ sectionTitle: `AI dan maslahat oling.`, sectionTitleText: `Kerakli malumotlarni tekshiring. Suniy intelekt ham dashadi` }">
            <div class="animate_top bb ze rj ki xn vq">
                <h2 x-text="sectionTitle" class="fk vj pr kk wm on/5 gq/2 bb _b"></h2>
                <p class="bb on/5 wo/5 hq" x-text="sectionTitleText"></p>
            </div>
        </div>
        <!-- Section Title End -->

        <div class="i va bb ye ki xn wq jb mo">
            <div class="tc uf sn tf rn un zf xl:gap-10" style="align-items: center; justify-content: center;">
                <div class="animate_top w-full vk sg hh sm yh tq">

                    <!-- Chat history container -->
                    <div id="chat-history"
                        style="max-height: 500px; overflow-y: auto; margin-bottom: 1rem; padding: 1rem; border-radius: 8px;">
                        <p style="text-align: center; margin-bottom: 5px">Savollaringizni bering, AI yordam beradi...</p>
                    </div>

                    <!-- Input section -->
                    <div class="tc sf yo ap zf ep qb">
                        <div class="vd to">
                            <div class="bb ye ki xn vq jb jo">
                                <div class="animate_top" style="display: flex; gap: 0.5rem; align-items: center;">
                                    <input id="message-input" type="text" placeholder="AI dan savol bering..."
                                        class="vd ph sg zk xm _g ch pm hm dm dn em pl/50 xi mi" style="flex: 1;" />

                                    <button onclick="sendMessage()" type="button" id="send-btn"
                                        style="padding: 0.5rem; background: #3b82f6; border-radius: 8px; border: none; cursor: pointer;">
                                        <img src="https://img.icons8.com/?size=100&id=HCYq7G4siTbb&format=png&color=FFFFFF"
                                            alt="Yuborish" width="44" height="44">
                                    </button>
                                </div>

                                <!-- Model selection -->
                                <div style="margin-top: 1rem; display: flex; gap: 1rem; justify-content: center;">
                                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                                        <input type="radio" name="ai-model" value="deepseek/deepseek-chat" checked>
                                        <span>DeepSeek Chat (Tez)</span>
                                    </label>
                                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                                        <input type="radio" name="ai-model" value="deepseek/deepseek-r1">
                                        <span>DeepSeek Reasoner (Aqlli)</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ===== Contact End ===== -->

    <!-- Puter.js va Marked.js kutubxonalari -->
    <script src="https://js.puter.com/v2/"></script>
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

    <script>
        // Chat tarixini saqlash
        let chatHistory = [];

        // Xabar yuborish funksiyasi
        async function sendMessage() {
            const input = document.getElementById('message-input');
            const message = input.value.trim();
            const chatHistoryDiv = document.getElementById('chat-history');
            const sendBtn = document.getElementById('send-btn');

            // Bo'sh xabarni tekshirish
            if (!message) {
                alert('Iltimos, savol kiriting!');
                return;
            }

            // Tanlangan modelni olish
            const selectedModel = document.querySelector('input[name="ai-model"]:checked').value;

            // Foydalanuvchi xabarini ko'rsatish
            addMessageToChat('user', message);

            // Inputni tozalash va bloklash
            input.value = '';
            input.disabled = true;
            sendBtn.disabled = true;

            // Yuklash holatini ko'rsatish
            const loadingId = addMessageToChat('ai', '💭 Javob tayyorlanmoqda...');

            try {
                // AI dan javob olish (streaming bilan)
                const response = await puter.ai.chat(message, {
                    model: selectedModel,
                    stream: true
                });

                // Yuklash xabarini o'chirish
                removeMessage(loadingId);

                // AI javobini qo'shish
                const aiMessageId = addMessageToChat('ai', '');
                let fullResponse = '';

                // Javobni qism-qism olish va ko'rsatish
                for await (const part of response) {
                    if (part?.text) {
                        fullResponse += part.text;
                        updateMessage(aiMessageId, fullResponse);
                    }
                }

                // Chat tarixiga qo'shish
                chatHistory.push({
                    role: 'user',
                    content: message
                });
                chatHistory.push({
                    role: 'assistant',
                    content: fullResponse
                });

            } catch (error) {
                console.error('Xato:', error);
                removeMessage(loadingId);
                addMessageToChat('error', '❌ Xatolik yuz berdi. Iltimos, qaytadan urinib ko\'ring.');
            } finally {
                // Inputni yoqish
                input.disabled = false;
                sendBtn.disabled = false;
                input.focus();
            }
        }

        // Chatga xabar qo'shish
        function addMessageToChat(type, content) {
            const chatHistoryDiv = document.getElementById('chat-history');
            const messageId = 'msg-' + Date.now();

            const messageDiv = document.createElement('div');
            messageDiv.id = messageId;
            messageDiv.style.cssText = `
                margin-bottom: 1rem;
                padding: 1rem;
                border-radius: 8px;
                ${type === 'user' ? 'background: #3b82f6; color: white; margin-left: 20%;' : ''}
                ${type === 'ai' ? 'background: #3b82f6; color: white; border: 1px solid #e5e7eb; margin-right: 20%;' : ''}
                ${type === 'error' ? 'background: #3b82f6; color: white; border: 1px solid #fecaca;' : ''}
            `;

            if (type === 'user') {
                messageDiv.innerHTML = `<strong>Siz:</strong><br>${escapeHtml(content)}`;
            } else if (type === 'ai') {
                messageDiv.innerHTML = `<strong>AI:</strong><br><div class="ai-content">${content}</div>`;
            } else {
                messageDiv.innerHTML = content;
            }

            chatHistoryDiv.appendChild(messageDiv);
            chatHistoryDiv.scrollTop = chatHistoryDiv.scrollHeight;

            return messageId;
        }

        // Xabarni yangilash (streaming uchun)
        function updateMessage(messageId, content) {
            const messageDiv = document.getElementById(messageId);
            if (messageDiv) {
                const aiContent = messageDiv.querySelector('.ai-content');
                if (aiContent) {
                    // Markdown ni HTML ga o'girish
                    aiContent.innerHTML = marked.parse(content);
                }
                messageDiv.parentElement.scrollTop = messageDiv.parentElement.scrollHeight;
            }
        }

        // Xabarni o'chirish
        function removeMessage(messageId) {
            const messageDiv = document.getElementById(messageId);
            if (messageDiv) {
                messageDiv.remove();
            }
        }

        // HTML teglarini escape qilish (XSS oldini olish)
        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        // Enter tugmasini bosganda yuborish
        document.getElementById('message-input').addEventListener('keypress', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        });

        // Sahifa yuklanganda inputga focus qilish
        window.addEventListener('load', function() {
            document.getElementById('message-input').focus();
        });
    </script>

    <style>
        /* AI javobidagi kod bloklari uchun */
        .ai-content pre {
            background: #f3f4f6;
            padding: 1rem;
            border-radius: 6px;
            overflow-x: auto;
            margin: 0.5rem 0;
        }

        .ai-content code {
            background: #f3f4f6;
            padding: 0.2rem 0.4rem;
            border-radius: 3px;
            font-family: monospace;
        }

        .ai-content h1,
        .ai-content h2,
        .ai-content h3 {
            margin-top: 1rem;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        .ai-content ul,
        .ai-content ol {
            margin-left: 1.5rem;
            margin-top: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .ai-content li {
            margin-bottom: 0.25rem;
        }

        /* Scroll bar dizayni */
        #chat-history::-webkit-scrollbar {
            width: 8px;
        }

        #chat-history::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        #chat-history::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        #chat-history::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
</x-layout>
