{{-- Connection Modal Component --}}
<div x-show="modals.connection" class="fixed inset-0 z-50 flex items-center justify-center" style="display: none;">
    <div class="absolute inset-0 bg-black/50" @click="closeConnectionModal()"></div>
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-md mx-4 relative z-10">
        <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="font-semibold text-gray-900 dark:text-white" x-text="editing.connection ? 'Aloqani tahrirlash' : 'Yangi aloqa'"></h3>
            <button @click="closeConnectionModal()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form @submit.prevent="validateAndSaveConnection()" class="p-4 space-y-4">
            <!-- Validation error message -->
            <div x-show="connectionError" x-text="connectionError" class="text-red-500 text-sm bg-red-50 dark:bg-red-900/20 p-2 rounded-lg"></div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nomi</label>
                <input type="text" x-model="forms.connection.name" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-violet-500 focus:border-violet-500 dark:bg-gray-700 dark:text-white" placeholder="Telefon, Telegram, Email..." required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">URL / Manzil</label>
                <input type="text" x-model="forms.connection.url" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-violet-500 focus:border-violet-500 dark:bg-gray-700 dark:text-white" placeholder="https://t.me/username yoki +998901234567" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Ikonka</label>
                <input type="hidden" x-model="forms.connection.icon" id="connection-icon-input">
                
                <!-- Icon Picker Grid -->
                <div class="grid grid-cols-6 gap-2 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl border border-gray-200 dark:border-gray-600 mt-2">
                    <!-- Telegram -->
                    <button type="button" 
                        @click="selectConnectionIcon('telegram', 'Telegram')"
                        :class="forms.connection.icon === 'telegram' ? 'bg-violet-100 dark:bg-violet-900/30 border-violet-500' : 'hover:bg-gray-100 dark:hover:bg-gray-600 border-transparent'"
                        class="icon-btn w-10 h-10 flex items-center justify-center rounded-lg hover:bg-white dark:hover:bg-gray-700 hover:shadow-md transition-all border border-transparent hover:border-gray-200 dark:hover:border-gray-600"
                        style="color: #0088cc">
                        <svg class="w-5 h-5" viewBox="0 0 496 512" fill="currentColor"><path d="M248 8C111 8 0 119 0 256s111 248 248 248 248-111 248-248S385 8 248 8zm121.8 169.9l-40.7 191.8c-3 13.6-11.1 16.9-22.4 10.5l-62-45.7-29.9 28.8c-3.3 3.3-6.1 6.1-12.5 6.1l4.4-63.1 114.9-103.8c5-4.4-1.1-6.9-7.7-2.5l-142 89.4-61.2-19.1c-13.3-4.2-13.6-13.3 2.8-19.7l239.1-92.2c11.1-4 20.8 2.7 17.2 19.5z"/></svg>
                    </button>
                    <!-- Phone -->
                    <button type="button" 
                        @click="selectConnectionIcon('phone', 'Telefon')"
                        :class="forms.connection.icon === 'phone' ? 'bg-green-100 dark:bg-green-900/30 border-green-500' : 'hover:bg-gray-100 dark:hover:bg-gray-600 border-transparent'"
                        class="icon-btn w-10 h-10 flex items-center justify-center rounded-lg hover:bg-white dark:hover:bg-gray-700 hover:shadow-md transition-all border border-transparent hover:border-gray-200 dark:hover:border-gray-600"
                        style="color: #10B981">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.81 12.81 0 0 0 .62 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l2.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.62A2 2 0 0 1 22 16.92z"/></svg>
                    </button>
                    <!-- Email -->
                    <button type="button" 
                        @click="selectConnectionIcon('email', 'Email')"
                        :class="forms.connection.icon === 'email' ? 'bg-red-100 dark:bg-red-900/30 border-red-500' : 'hover:bg-gray-100 dark:hover:bg-gray-600 border-transparent'"
                        class="icon-btn w-10 h-10 flex items-center justify-center rounded-lg hover:bg-white dark:hover:bg-gray-700 hover:shadow-md transition-all border border-transparent hover:border-gray-200 dark:hover:border-gray-600"
                        style="color: #EF4444">
                        <svg class="w-5 h-5" viewBox="0 0 512 512" fill="currentColor"><path d="M502.3 190.8c3.9-3.1 9.7-.2 9.7 4.7V400c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V195.6c0-5 5.8-7.8 9.7-4.7 22.4 17.4 52.1 39.5 154.1 113.5 21.1 15.4 56.7 47.8 92.2 47.6 35.5.2 71-32.2 92.2-47.6 102-74.1 131.6-96.3 154-113.5zM256 320c23.2.4 56.6-29.2 73.4-41.4 132.7-96.3 142.8-104.7 173.4-128.7 5.8-4.5 9.2-11.5 9.2-18.9v-19c0-26.5-21.5-48-48-48H48C21.5 64 0 85.5 0 112v19c0 7.4 3.4 14.5 9.2 18.9 30.6 23.9 40.7 32.4 173.4 128.7 16.8 12.2 50.2 41.8 73.4 41.4z"/></svg>
                    </button>
                    <!-- Instagram -->
                    <button type="button" 
                        @click="selectConnectionIcon('instagram', 'Instagram')"
                        :class="forms.connection.icon === 'instagram' ? 'bg-pink-100 dark:bg-pink-900/30 border-pink-500' : 'hover:bg-gray-100 dark:hover:bg-gray-600 border-transparent'"
                        class="icon-btn w-10 h-10 flex items-center justify-center rounded-lg hover:bg-white dark:hover:bg-gray-700 hover:shadow-md transition-all border border-transparent hover:border-gray-200 dark:hover:border-gray-600"
                        style="color: #E1306C">
                        <svg class="w-5 h-5" viewBox="0 0 448 512" fill="currentColor"><path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/></svg>
                    </button>
                    <!-- Clock/Time -->
                    <button type="button" 
                        @click="selectConnectionIcon('clock', 'Ish vaqti')"
                        :class="forms.connection.icon === 'clock' ? 'bg-blue-100 dark:bg-blue-900/30 border-blue-500' : 'hover:bg-gray-100 dark:hover:bg-gray-600 border-transparent'"
                        class="icon-btn w-10 h-10 flex items-center justify-center rounded-lg hover:bg-white dark:hover:bg-gray-700 hover:shadow-md transition-all border border-transparent hover:border-gray-200 dark:hover:border-gray-600"
                        style="color: #3B82F6">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </button>
                    <!-- Facebook -->
                    <button type="button" 
                        @click="selectConnectionIcon('facebook', 'Facebook')"
                        :class="forms.connection.icon === 'facebook' ? 'bg-blue-100 dark:bg-blue-900/30 border-blue-500' : 'hover:bg-gray-100 dark:hover:bg-gray-600 border-transparent'"
                        class="icon-btn w-10 h-10 flex items-center justify-center rounded-lg hover:bg-white dark:hover:bg-gray-700 hover:shadow-md transition-all border border-transparent hover:border-gray-200 dark:hover:border-gray-600"
                        style="color: #1877F2">
                        <svg class="w-5 h-5" viewBox="0 0 512 512" fill="currentColor"><path d="M504 256C504 119 393 8 256 8S8 119 8 256c0 123.78 90.69 226.38 209.25 245V327.69h-63V256h63v-54.64c0-62.15 37-96.48 93.67-96.48 27.14 0 55.52 4.84 55.52 4.84v61h-31.28c-30.8 0-40.41 19.12-40.41 38.73V256h68.78l-11 71.69h-57.78V501C413.31 482.38 504 379.78 504 256z"/></svg>
                    </button>
                    <!-- Website/Globe -->
                    <button type="button" 
                        @click="selectConnectionIcon('website', 'Veb-sayt')"
                        :class="forms.connection.icon === 'website' ? 'bg-indigo-100 dark:bg-indigo-900/30 border-indigo-500' : 'hover:bg-gray-100 dark:hover:bg-gray-600 border-transparent'"
                        class="icon-btn w-10 h-10 flex items-center justify-center rounded-lg hover:bg-white dark:hover:bg-gray-700 hover:shadow-md transition-all border border-transparent hover:border-gray-200 dark:hover:border-gray-600"
                        style="color: #3B82F6">
                        <svg class="w-5 h-5" viewBox="0 0 512 512" fill="currentColor"><path d="M352 256c0 22.2-1.2 43.6-3.3 64H163.3c-2.2-20.4-3.3-41.8-3.3-64s1.2-43.6 3.3-64h185.4c2.2 20.4 3.3 41.8 3.3 64zm151.9-64c5.3 20.5 8.1 41.9 8.1 64s-2.8 43.5-8.1 64H380.8c2.1-20.6 3.2-42 3.2-64s-1.1-43.4-3.2-64h123.1zm-10.5-32H376.7c-10-63.8-29.8-117.4-55.3-151.6 78.3 20.7 142 77.5 170.1 151.6zm-105.1 0H175.7c9.3-59.7 27.8-110.1 51.3-143.3 19.3-27.3 41.2-45.6 69-45.6s49.7 18.3 69 45.6c23.5 33.2 42.1 83.6 51.3 143.3zM8.1 192c-5.3 20.5-8.1 41.9-8.1 64s2.8 43.5 8.1 64h123.1c-2.1-20.6-3.2-42-3.2-64s1.1-43.4 3.2-64H8.1zm110.4-32C146.6 85.9 210.3 29.1 288.6 8.4c-25.5 34.2-45.3 87.8-55.3 151.6H118.5zm3.1 192h115.2c10 63.8 29.8 117.4 55.3 151.6-78.3-20.7-142-77.5-170.1-151.6zm105.1 0h218.6c-9.3 59.7-27.8 110.1-51.3 143.3-19.3 27.3-41.2 45.6-69 45.6s-49.7-18.3-69-45.6c-23.5-33.2-42.1-83.6-51.3-143.3zM393.5 352h110.4c-28.1 74.1-91.8 130.9-170.1 151.6 25.5-34.2 45.3-87.8 55.3-151.6z"/></svg>
                    </button>
                    <!-- YouTube -->
                    <button type="button" 
                        @click="selectConnectionIcon('youtube', 'YouTube')"
                        :class="forms.connection.icon === 'youtube' ? 'bg-red-100 dark:bg-red-900/30 border-red-500' : 'hover:bg-gray-100 dark:hover:bg-gray-600 border-transparent'"
                        class="icon-btn w-10 h-10 flex items-center justify-center rounded-lg hover:bg-white dark:hover:bg-gray-700 hover:shadow-md transition-all border border-transparent hover:border-gray-200 dark:hover:border-gray-600"
                        style="color: #FF0000">
                        <svg class="w-5 h-5" viewBox="0 0 576 512" fill="currentColor"><path d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-318.71 213.986V195.669l142.739 71.37-142.739 71.03z"/></svg>
                    </button>
                    <!-- WhatsApp -->
                    <button type="button" 
                        @click="selectConnectionIcon('whatsapp', 'WhatsApp')"
                        :class="forms.connection.icon === 'whatsapp' ? 'bg-green-100 dark:bg-green-900/30 border-green-500' : 'hover:bg-gray-100 dark:hover:bg-gray-600 border-transparent'"
                        class="icon-btn w-10 h-10 flex items-center justify-center rounded-lg hover:bg-white dark:hover:bg-gray-700 hover:shadow-md transition-all border border-transparent hover:border-gray-200 dark:hover:border-gray-600"
                        style="color: #25D366">
                        <svg class="w-5 h-5" viewBox="0 0 448 512" fill="currentColor"><path d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-97.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 185.7-186.4 185.7zm101.9-138.8c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7s-12.5-30.1-17.1-41.2c-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2s-9.7 1.4-14.8 6.9c-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/></svg>
                    </button>
                    <!-- LinkedIn -->
                    <button type="button" 
                        @click="selectConnectionIcon('linkedin', 'LinkedIn')"
                        :class="forms.connection.icon === 'linkedin' ? 'bg-blue-100 dark:bg-blue-900/30 border-blue-500' : 'hover:bg-gray-100 dark:hover:bg-gray-600 border-transparent'"
                        class="icon-btn w-10 h-10 flex items-center justify-center rounded-lg hover:bg-white dark:hover:bg-gray-700 hover:shadow-md transition-all border border-transparent hover:border-gray-200 dark:hover:border-gray-600"
                        style="color: #0A66C2">
                        <svg class="w-5 h-5" viewBox="0 0 448 512" fill="currentColor"><path d="M416 32H31.9C14.3 32 0 46.5 0 64.3v383.4C0 465.5 14.3 480 31.9 480H416c17.6 0 32-14.5 32-32.3V64.3c0-17.8-14.4-32.3-32-32.3zM135.4 416H69V202.2h66.5V416zm-33.2-243c-21.3 0-38.5-17.3-38.5-38.5S80.9 96 102.2 96c21.2 0 38.5 17.3 38.5 38.5 0 21.3-17.2 38.5-38.5 38.5zm282.1 243h-66.4V312c0-24.8-.5-56.7-34.5-56.7-34.6 0-39.9 27-39.9 54.9V416h-66.4V202.2h63.7v29.2h.9c8.9-16.8 30.6-34.5 62.9-34.5 67.2 0 79.7 44.3 79.7 101.9V416z"/></svg>
                    </button>
                    <!-- Twitter/X -->
                    <button type="button" 
                        @click="selectConnectionIcon('twitter', 'Twitter')"
                        :class="forms.connection.icon === 'twitter' ? 'bg-gray-200 dark:bg-gray-600 border-gray-500' : 'hover:bg-gray-100 dark:hover:bg-gray-600 border-transparent'"
                        class="icon-btn w-10 h-10 flex items-center justify-center rounded-lg hover:bg-white dark:hover:bg-gray-700 hover:shadow-md transition-all border border-transparent hover:border-gray-200 dark:hover:border-gray-600"
                        style="color: #1DA1F2">
                        <svg class="w-5 h-5" viewBox="0 0 512 512" fill="currentColor"><path d="M459.37 151.72c.32 4.55.32 9.1.32 13.65 0 138.72-105.58 298.56-298.56 298.56-59.45 0-114.68-17.22-161.14-47.11 8.45.97 16.57 1.3 25.12 1.3 49.05 0 94.21-16.58 130.13-44.83-46.13-.97-84.79-31.19-98.11-72.77 6.5.97 13 1.62 19.82 1.62 9.42 0 18.84-1.3 27.61-3.57-48.08-9.75-84.14-52-84.14-102.98v-1.3c13.97 7.79 30.21 12.67 47.43 13.32-28.26-18.84-46.79-51.3-46.79-87.85 0-19.49 5.2-37.36 14.35-52.95 51.72 63.67 129.32 105.26 216.37 109.81-1.62-7.8-2.6-15.92-2.6-24.04 0-57.82 46.79-104.62 104.62-104.62 30.21 0 57.48 12.67 76.67 33.14 23.73-4.55 46.13-13.32 66.24-25.69-7.79 24.04-24.04 44.34-46.13 57.05 21.12-2.27 41.58-8.15 60.43-16.3-14.03 20.77-32.48 39.31-52.63 54.25z"/></svg>
                    </button>
                    <!-- TikTok -->
                    <button type="button" 
                        @click="selectConnectionIcon('tiktok', 'TikTok')"
                        :class="forms.connection.icon === 'tiktok' ? 'bg-gray-200 dark:bg-gray-600 border-gray-500' : 'hover:bg-gray-100 dark:hover:bg-gray-600 border-transparent'"
                        class="icon-btn w-10 h-10 flex items-center justify-center rounded-lg hover:bg-white dark:hover:bg-gray-700 hover:shadow-md transition-all border border-transparent hover:border-gray-200 dark:hover:border-gray-600"
                        style="color: #ff0050">
                        <svg class="w-5 h-5" viewBox="0 0 448 512" fill="currentColor"><path d="M448 209.9a210.1 210.1 0 0 1 -122.8-39.25V349.4A162.6 162.6 0 1 1 185 188.3V278.2a74.62 74.62 0 1 0 52.23 71.18V0l88 0a121.18 121.18 0 0 0 1.86 22.17A122.2 122.2 0 0 0 381 102.39a121.43 121.43 0 0 0 67 20.14V209.9z"/></svg>
                    </button>
                    <!-- Location -->
                    <button type="button" 
                        @click="selectConnectionIcon('location', 'Manzil')"
                        :class="forms.connection.icon === 'location' ? 'bg-orange-100 dark:bg-orange-900/30 border-orange-500' : 'hover:bg-gray-100 dark:hover:bg-gray-600 border-transparent'"
                        class="icon-btn w-10 h-10 flex items-center justify-center rounded-lg hover:bg-white dark:hover:bg-gray-700 hover:shadow-md transition-all border border-transparent hover:border-gray-200 dark:hover:border-gray-600"
                        style="color: #DC2626">
                        <svg class="w-5 h-5" viewBox="0 0 384 512" fill="currentColor"><path d="M172.3 501.7C27 291 0 269.4 0 192 0 86 86 0 192 0s192 86 192 192c0 77.4-27 99-172.3 309.7-9.5 13.8-29.8 13.8-39.5 0zM192 272c44.2 0 80-35.8 80-80s-35.8-80-80-80-80 35.8-80 80 35.8 80 80 80z"/></svg>
                    </button>
                </div>
                
                <!-- Selected icon display -->
                <div x-show="forms.connection.icon" class="mt-2 flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                    <span>Tanlangan:</span>
                    <span x-text="forms.connection.icon" class="font-medium text-violet-600 dark:text-violet-400 capitalize"></span>
                </div>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" @click="closeConnectionModal()" class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">Bekor</button>
                <button type="submit" class="flex-1 px-4 py-2 bg-violet-600 text-white rounded-lg hover:bg-violet-700">Saqlash</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Icon names mapping for auto-fill
    const iconNames = {
        'telegram': 'Telegram',
        'phone': 'Telefon',
        'email': 'Email',
        'instagram': 'Instagram',
        'facebook': 'Facebook',
        'website': 'Veb-sayt',
        'youtube': 'YouTube',
        'whatsapp': 'WhatsApp',
        'linkedin': 'LinkedIn',
        'twitter': 'Twitter',
        'tiktok': 'TikTok',
        'location': 'Manzil',
        'clock': 'Ish vaqti'
    };

    // Select icon and auto-fill name
    function selectConnectionIcon(icon, defaultName) {
        // Set icon
        const modalEl = document.querySelector('[x-show="modals.connection"]');
        const alpineData = modalEl ? Alpine.$data(modalEl) : null;
        
        if (alpineData && alpineData.forms && alpineData.forms.connection) {
            alpineData.forms.connection.icon = icon;
            // Only auto-fill name if it's empty or matches previous icon's default name
            const currentName = alpineData.forms.connection.name;
            const isNameEmpty = !currentName || currentName.trim() === '';
            const isDefaultName = Object.values(iconNames).includes(currentName);
            if (isNameEmpty || isDefaultName) {
                alpineData.forms.connection.name = defaultName;
            }
        }
        
        // Update hidden input
        const iconInput = document.getElementById('connection-icon-input');
        if (iconInput) iconInput.value = icon;
    }

    // Validation function
    function validateAndSaveConnection() {
        const modalEl = document.querySelector('[x-show="modals.connection"]');
        const alpineData = modalEl ? Alpine.$data(modalEl) : null;
        
        if (!alpineData || !alpineData.forms || !alpineData.forms.connection) {
            return;
        }
        
        const connection = alpineData.forms.connection;
        let error = '';
        
        // Validate name
        if (!connection.name || connection.name.trim() === '') {
            error = 'Nomi kiritilishi shart';
        }
        // Validate URL
        else if (!connection.url || connection.url.trim() === '') {
            error = 'URL / Manzil kiritilishi shart';
        }
        // Validate icon
        else if (!connection.icon || connection.icon.trim() === '') {
            error = 'Ikonka tanlanishi shart';
        }
        
        if (error) {
            // Show error
            alpineData.connectionError = error;
            return;
        }
        
        // Clear error and save
        alpineData.connectionError = '';
        alpineData.saveConnection();
    }
</script>
