{{-- Teacher-Subject Assignment Modal --}}
<div x-show="modals.teacherSubject" class="fixed inset-0 z-50 flex items-center justify-center" style="display: none;">
    <div class="absolute inset-0 bg-black/50" @click="closeTeacherSubjectModal()"></div>
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-lg mx-4 relative z-10 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="font-semibold text-gray-900 dark:text-white">
                <span x-text="selectedTeacher ? selectedTeacher.name + ' - Fan biriktirish' : 'Fan biriktirish'"></span>
            </h3>
            <button @click="closeTeacherSubjectModal()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="p-4 space-y-4">
            <!-- Subject Selection -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fan *</label>
                <select x-model="teacherSubjectForm.subject_id" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-violet-500 focus:border-violet-500 dark:bg-gray-700 dark:text-white">
                    <option value="">Fan tanlang</option>
                    <template x-for="subject in availableSubjects" :key="subject.id">
                        <option :value="subject.id" x-text="subject.name"></option>
                    </template>
                </select>
            </div>

            <!-- Subject Type -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fan turi</label>
                <select x-model="teacherSubjectForm.subject_type" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-violet-500 focus:border-violet-500 dark:bg-gray-700 dark:text-white">
                    <option value="">Tanlang</option>
                    <option value="individual">Individual</option>
                    <option value="group">Guruhli</option>
                    <option value="both">Ikkalasi ham</option>
                </select>
            </div>

            <!-- Subject Icon -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fan ikonkasi</label>
                <input type="text" x-model="teacherSubjectForm.subject_icon" placeholder="Masalan: book, calculator, code" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-violet-500 focus:border-violet-500 dark:bg-gray-700 dark:text-white">
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tavsif</label>
                <textarea x-model="teacherSubjectForm.description" rows="2" placeholder="Fan haqida qo'shimcha ma'lumot" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-violet-500 focus:border-violet-500 dark:bg-gray-700 dark:text-white"></textarea>
            </div>

            <!-- Price and Currency -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Narx</label>
                    <input type="number" x-model="teacherSubjectForm.price" placeholder="0" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-violet-500 focus:border-violet-500 dark:bg-gray-700 dark:text-white">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Valyuta</label>
                    <select x-model="teacherSubjectForm.currency" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-violet-500 focus:border-violet-500 dark:bg-gray-700 dark:text-white">
                        <option value="UZS">UZS (so'm)</option>
                        <option value="USD">USD ($)</option>
                    </select>
                </div>
            </div>

            <!-- Period -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Davr</label>
                <select x-model="teacherSubjectForm.period" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-violet-500 focus:border-violet-500 dark:bg-gray-700 dark:text-white">
                    <option value="">Tanlang</option>
                    <option value="monthly">Oylik</option>
                    <option value="course">Kurs davomida</option>
                    <option value="hourly">Soatbay</option>
                    <option value="per_lesson">Dars uchun</option>
                </select>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="button" @click="closeTeacherSubjectModal()" class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">Bekor</button>
                <button type="button" @click="saveTeacherSubject()" class="flex-1 px-4 py-2 bg-violet-600 text-white rounded-lg hover:bg-violet-700">Saqlash</button>
            </div>
        </div>
    </div>
</div>
