<x-layout>
    <x-slot:title>AI dan maslahat oling</x-slot:title>
    
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 flex">
        <!-- Sidebar -->
        <div class="w-80 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 flex flex-col hidden lg:flex">
            <!-- Sidebar Header -->
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">AI Assistant</h2>
                <p class="text-gray-600 dark:text-gray-400 text-sm">Kerakli ma'lumotlarni tekshiring. Suniy intellekt ham yordam beradi</p>
            </div>
            
            <!-- Chat List -->
            <div class="flex-1 overflow-y-auto p-4">
                <div class="space-y-2">
                    <!-- Active Chat -->
                    <div class="p-4 bg-primary-50 dark:bg-primary-900/20 border border-primary-200 dark:border-primary-800 rounded-xl cursor-pointer">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-r from-primary-500 to-accent-500 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900 dark:text-white">AI Assistant</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 truncate">Savollaringizni bering...</p>
                            </div>
                            <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                        </div>
                    </div>
                    
                    <!-- Previous Chats (Placeholder) -->
                    <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-xl cursor-pointer transition-colors">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gray-200 dark:bg-gray-600 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900 dark:text-white">Old Chat</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 truncate">Previous conversation...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar Footer -->
            <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                <div class="text-sm text-gray-500 dark:text-gray-400 text-center">
                    <p>Powered by AI</p>
                    <p class="text-xs mt-1">Available 24/7</p>
                </div>
            </div>
        </div>
        
        <!-- Main Chat Area -->
        <div class="flex-1 flex flex-col">
            <!-- Chat Header -->
            <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <!-- Mobile Menu Toggle -->
                        <button class="lg:hidden p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                            <svg class="w-6 h-6 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        
                        <div class="w-10 h-10 bg-gradient-to-r from-primary-500 to-accent-500 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 dark:text-white">AI Assistant</h3>
                            <p class="text-sm text-green-600 dark:text-green-400">Online • Always ready to help</p>
                        </div>
                    </div>
                    
                    <!-- Model Selection (Desktop) -->
                    <div class="hidden md:flex items-center space-x-2">
                        <label class="text-sm text-gray-600 dark:text-gray-400">Model:</label>
                        <select class="text-sm border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-1 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <option value="deepseek/deepseek-chat">DeepSeek Chat (Fast)</option>
                            <option value="deepseek/deepseek-r1">DeepSeek Reasoner (Smart)</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- Messages Area -->
            <div id="chat-history" class="flex-1 overflow-y-auto p-6 space-y-4">
                <!-- Welcome Message -->
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-gradient-to-r from-primary-500 to-accent-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">AI Assistantga xush kelibsiz!</h3>
                    <p class="text-gray-600 dark:text-gray-400">Savollaringizni bering, AI yordam beradi...</p>
                </div>
            </div>
            
            <!-- Input Area -->
            <div class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 p-6">
                <div class="max-w-4xl mx-auto">
                    <div class="flex space-x-4">
                        <input id="message-input" 
                               type="text" 
                               placeholder="AI dan savol bering..." 
                               class="flex-1 px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:text-white resize-none">
                        
                        <button onclick="sendMessage()" 
                                type="button" 
                                id="send-btn"
                                class="bg-gradient-to-r from-primary-600 to-accent-600 hover:from-primary-700 hover:to-accent-700 text-white p-3 rounded-xl transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Model Selection (Mobile) -->
                    <div class="mt-4 md:hidden">
                        <label class="text-sm text-gray-600 dark:text-gray-400">AI Model:</label>
                        <div class="flex space-x-4 mt-2">
                            <label class="flex items-center">
                                <input type="radio" name="ai-model" value="deepseek/deepseek-chat" checked class="mr-2">
                                <span class="text-sm text-gray-700 dark:text-gray-300">Fast</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="ai-model" value="deepseek/deepseek-r1" class="mr-2">
                                <span class="text-sm text-gray-700 dark:text-gray-300">Smart</span>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Quick Actions -->
                    <div class="mt-4 flex flex-wrap gap-2">
                        <button onclick="quickQuestion('Kurslar haqida ma\'lumot bering')" class="px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-full text-sm hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                            Kurslar haqida
                        </button>
                        <button onclick="quickQuestion('O\'qituvchilarni topishga yordam bering')" class="px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-full text-sm hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                            O'qituvchi topish
                        </button>
                        <button onclick="quickQuestion('Eng yaxshi o\'quv markazlar qaysilar?')" class="px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-full text-sm hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                            Top markazlar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                showNotification('Iltimos, savol kiriting!', 'warning');
                return;
            }

            // Tanlangan modelni olish
            const selectedModel = document.querySelector('input[name="ai-model"]:checked')?.value || 'deepseek/deepseek-chat';

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
                showNotification('Xatolik yuz berdi', 'error');
            } finally {
                // Inputni yoqish
                input.disabled = false;
                sendBtn.disabled = false;
                input.focus();
            }
        }

        // Tezkor savol funksiyasi
        function quickQuestion(question) {
            document.getElementById('message-input').value = question;
            sendMessage();
        }

        // Chatga xabar qo'shish
        function addMessageToChat(type, content) {
            const chatHistoryDiv = document.getElementById('chat-history');
            const messageId = 'msg-' + Date.now();

            const messageDiv = document.createElement('div');
            messageDiv.id = messageId;
            messageDiv.className = 'flex animate-fade-in';
            
            if (type === 'user') {
                messageDiv.innerHTML = `
                    <div class="flex-1"></div>
                    <div class="max-w-xs lg:max-w-md">
                        <div class="bg-gradient-to-r from-primary-600 to-accent-600 text-white p-4 rounded-2xl rounded-br-none shadow-lg">
                            <div class="flex items-start space-x-2">
                                <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium">Siz</p>
                                    <p class="text-sm mt-1">${escapeHtml(content)}</p>
                                </div>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 text-right">${new Date().toLocaleTimeString()}</p>
                    </div>
                `;
            } else if (type === 'ai') {
                messageDiv.innerHTML = `
                    <div class="max-w-xs lg:max-w-md">
                        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 p-4 rounded-2xl rounded-bl-none shadow-lg">
                            <div class="flex items-start space-x-2">
                                <div class="w-8 h-8 bg-gradient-to-r from-primary-500 to-accent-500 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">AI Assistant</p>
                                    <div class="ai-content text-sm text-gray-600 dark:text-gray-300 mt-1">${content}</div>
                                </div>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">${new Date().toLocaleTimeString()}</p>
                    </div>
                    <div class="flex-1"></div>
                `;
            } else if (type === 'error') {
                messageDiv.innerHTML = `
                    <div class="flex-1"></div>
                    <div class="max-w-xs lg:max-w-md">
                        <div class="bg-danger-50 dark:bg-danger-900/20 border border-danger-200 dark:border-danger-800 text-danger-700 dark:text-danger-300 p-4 rounded-2xl rounded-br-none shadow-lg">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5 text-danger-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-sm">${content}</p>
                            </div>
                        </div>
                    </div>
                `;
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

        // Bildirishnomani ko'rsatish
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 p-4 rounded-xl shadow-lg z-50 animate-fade-in ${
                type === 'error' ? 'bg-danger-500 text-white' : 
                type === 'warning' ? 'bg-warning-500 text-white' : 
                'bg-primary-500 text-white'
            }`;
            notification.innerHTML = `
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>${message}</span>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 3000);
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

        // Mobile sidebar toggle (placeholder)
        document.addEventListener('click', function(e) {
            if (e.target.closest('button') && e.target.closest('button').querySelector('svg path[d*="M4 6h16M4 12h16M4 18h16"]')) {
                // Mobile sidebar toggle functionality would go here
                showNotification('Mobile sidebar - coming soon!', 'info');
            }
        });
    </script>

    <style>
        /* AI javobidagi kod bloklari uchun */
        .ai-content pre {
            background: #f3f4f6;
            dark:bg-gray-700;
            padding: 1rem;
            border-radius: 0.5rem;
            overflow-x: auto;
            margin: 0.5rem 0;
        }

        .ai-content code {
            background: #f3f4f6;
            dark:bg-gray-700;
            padding: 0.2rem 0.4rem;
            border-radius: 0.25rem;
            font-family: monospace;
            font-size: 0.875rem;
        }

        .ai-content h1,
        .ai-content h2,
        .ai-content h3,
        .ai-content h4 {
            margin-top: 1rem;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: inherit;
        }

        .ai-content h1 { font-size: 1.5rem; }
        .ai-content h2 { font-size: 1.25rem; }
        .ai-content h3 { font-size: 1.125rem; }
        .ai-content h4 { font-size: 1rem; }

        .ai-content ul,
        .ai-content ol {
            margin-left: 1.5rem;
            margin-top: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .ai-content li {
            margin-bottom: 0.25rem;
        }

        .ai-content p {
            margin-bottom: 0.75rem;
            line-height: 1.6;
        }

        .ai-content a {
            color: #3b82f6;
            text-decoration: underline;
        }

        .ai-content a:hover {
            color: #2563eb;
        }

        /* Scroll bar dizayni */
        #chat-history::-webkit-scrollbar {
            width: 6px;
        }

        #chat-history::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        #chat-history::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 3px;
        }

        #chat-history::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Animatsiyalar */
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.3s ease-out;
        }

        /* Dark mode uchun */
        @media (prefers-color-scheme: dark) {
            .ai-content pre {
                background: #374151;
            }
            
            .ai-content code {
                background: #374151;
            }
        }
    </style>
</x-layout>
