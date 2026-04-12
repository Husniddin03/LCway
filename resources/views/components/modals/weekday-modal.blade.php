{{-- Weekday Modal Component - Work Schedule Management --}}
<div x-show="modals.weekday" class="fixed inset-0 z-50 flex items-center justify-center" style="display: none;" x-cloak>
    <div class="absolute inset-0 bg-black/50" @click="closeWeekdayModal()"></div>
    
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-full max-w-3xl mx-4 relative z-10 max-h-[90vh] overflow-y-auto">
        {{-- Header --}}
        <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700 sticky top-0 bg-white dark:bg-gray-800 z-20">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 dark:text-white">Ish jadvali</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Hafta kunlari bo'yicha ish vaqti</p>
                </div>
            </div>
            <button @click="closeWeekdayModal()" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <div class="p-6 space-y-6">
            {{-- Current Schedule List --}}
            <div x-show="weekdays.length > 0">
                <div class="flex items-center justify-between mb-3">
                    <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300">Mavjad jadval</h4>
                    <span class="text-xs text-gray-500" x-text="weekdays.length + ' kun'"></span>
                </div>
                
                <div class="space-y-3">
                    <template x-for="day in weekdays" :key="day.id">
                        <div class="flex items-center gap-4 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-700">
                            {{-- Day Badge --}}
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                                <span x-text="day.weekdays.substring(0, 2)"></span>
                            </div>
                            
                            {{-- Day Info --}}
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-gray-900 dark:text-white" x-text="day.weekdays"></p>
                                <p class="text-sm text-gray-500 dark:text-gray-400" x-show="!day.open_time && !day.close_time">Ish vaqti kiritilmagan</p>
                                <p class="text-sm text-green-600 dark:text-green-400" x-show="day.open_time || day.close_time">
                                    <span x-text="day.open_time || '--:--'"></span> - <span x-text="day.close_time || '--:--'"></span>
                                </p>
                            </div>
                            
                            {{-- Actions --}}
                            <div class="flex items-center gap-2">
                                <button @click="editWeekday(day)" class="p-2 text-violet-500 hover:text-violet-700 hover:bg-violet-50 dark:hover:bg-violet-900/20 rounded-lg transition-colors" title="Tahrirlash">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                </button>
                                <button @click="deleteWeekday(day.id)" class="p-2 text-red-500 hover:text-red-700 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors" title="O'chirish">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
            
            {{-- Empty State --}}
            <div x-show="weekdays.length === 0" class="text-center py-8 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-1">Jadval hali qo'shilmagan</h4>
                <p class="text-gray-500 dark:text-gray-400">Ish vaqtini belgilash uchun quyidagi tugmani bosing</p>
            </div>

            {{-- Add/Edit Form --}}
            <div class="border-t border-gray-200 dark:border-gray-700 pt-6" x-show="weekdayForm.show">
                <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-4" x-text="weekdayForm.editing ? 'Jadvalni tahrirlash' : 'Yangi ish kuni qo\'shish'"></h4>
                
                <form @submit.prevent="saveWeekday()" class="space-y-4">
                    {{-- Day Selection --}}
                    <div x-show="!weekdayForm.editing">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Hafta kuni</label>
                        <select x-model="weekdayForm.weekdays" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-violet-500 focus:border-violet-500 dark:bg-gray-700 dark:text-white">
                            <option value="">Tanlang</option>
                            <option value="Dushanba">Dushanba</option>
                            <option value="Seshanba">Seshanba</option>
                            <option value="Chorshanba">Chorshanba</option>
                            <option value="Payshanba">Payshanba</option>
                            <option value="Juma">Juma</option>
                            <option value="Shanba">Shanba</option>
                            <option value="Yakshanba">Yakshanba</option>
                        </select>
                    </div>
                    
                    {{-- Time Inputs --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 flex items-center gap-1">
                                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Ochilish vaqti
                            </label>
                            <input type="time" x-model="weekdayForm.open_time"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-violet-500 focus:border-violet-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 flex items-center gap-1">
                                <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                Yopilish vaqti
                            </label>
                            <input type="time" x-model="weekdayForm.close_time"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-violet-500 focus:border-violet-500 dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>
                    
                    {{-- Form Actions --}}
                    <div class="flex gap-3 pt-2">
                        <button type="button" @click="weekdayForm.show = false; resetWeekdayForm()" class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">Bekor</button>
                        <button type="submit" class="flex-1 px-4 py-2 bg-violet-600 text-white rounded-lg hover:bg-violet-700">Saqlash</button>
                    </div>
                </form>
            </div>
            
            {{-- Add Button (when form hidden) --}}
            <div x-show="!weekdayForm.show" class="flex justify-center pt-4">
                <button @click="weekdayForm.show = true; weekdayForm.editing = false; resetWeekdayForm()" 
                        class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-medium rounded-xl transition-all shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Ish kuni qo'shish
                </button>
            </div>
        </div>
    </div>
</div>
