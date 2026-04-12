{{-- Subject Modal Component --}}
<div x-show="modals.subject" class="fixed inset-0 z-50 flex items-center justify-center" style="display: none;">
    <div class="absolute inset-0 bg-black/50" @click="closeSubjectModal()"></div>
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-md mx-4 relative z-10">
        <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="font-semibold text-gray-900 dark:text-white" x-text="editing.subject ? 'Fanni tahrirlash' : 'Yangi fan'"></h3>
            <button @click="closeSubjectModal()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form @submit.prevent="saveSubject()" class="p-4 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fan nomi</label>
                <input type="text" x-model="forms.subject.name" list="existingSubjects" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-violet-500 focus:border-violet-500 dark:bg-gray-700 dark:text-white" required>
                @if(isset($existingSubjects) && $existingSubjects->count() > 0)
                <datalist id="existingSubjects">
                    @foreach($existingSubjects as $subj)
                        <option value="{{ $subj }}">
                    @endforeach
                </datalist>
                @else
                <datalist id="existingSubjects"></datalist>
                @endif
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" @click="closeSubjectModal()" class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">Bekor</button>
                <button type="submit" class="flex-1 px-4 py-2 bg-violet-600 text-white rounded-lg hover:bg-violet-700">Saqlash</button>
            </div>
        </form>
    </div>
</div>
