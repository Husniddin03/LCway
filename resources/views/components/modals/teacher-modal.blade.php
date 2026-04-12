{{-- Teacher Modal Component --}}
<div x-show="modals.teacher" class="fixed inset-0 z-50 flex items-center justify-center" style="display: none;">
    <div class="absolute inset-0 bg-black/50" @click="closeTeacherModal()"></div>
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-lg mx-4 relative z-10 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="font-semibold text-gray-900 dark:text-white" x-text="editing.teacher ? '{{ __('user.modals.edit_teacher') }}' : '{{ __('user.modals.new_teacher') }}'"></h3>
            <button @click="closeTeacherModal()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form @submit.prevent="saveTeacher()" class="p-4 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('user.modals.name') }}</label>
                <input type="text" x-model="forms.teacher.name" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-violet-500 focus:border-violet-500 dark:bg-gray-700 dark:text-white" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('user.modals.bio') }}</label>
                <textarea x-model="forms.teacher.about" rows="3" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-violet-500 focus:border-violet-500 dark:bg-gray-700 dark:text-white"></textarea>
            </div>
            <!-- Image Upload -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('user.modals.photo') }}</label>
                <div class="flex items-center gap-4">
                    <!-- Image Preview -->
                    <div x-show="teacherImagePreview || forms.teacher.photo" class="relative">
                        <img :src="teacherImagePreview || forms.teacher.photo" class="w-20 h-20 rounded-lg object-cover border border-gray-300 dark:border-gray-600">
                        <button type="button" @click="removeTeacherImage()" class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center text-xs hover:bg-red-600">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                    <!-- Upload Button -->
                    <div class="flex-1">
                        <input type="file" id="teacher-image-input" accept="image/*" class="hidden" @change="previewTeacherImage($event)">
                        <label for="teacher-image-input" class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span x-text="teacherImagePreview || forms.teacher.photo ? '{{ __('user.modals.change_photo') }}' : '{{ __('user.modals.select_photo') }}'"></span>
                        </label>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ __('user.modals.photo_requirements') }}</p>
                    </div>
                </div>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" @click="closeTeacherModal()" class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">{{ __('user.modals.cancel') }}</button>
                <button type="button" x-show="editing.teacher && editing.teacher.id" @click="closeTeacherModal(); openTeacherSubjectModal(editing.teacher)" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    {{ __('user.modals.assign_subject') }}
                </button>
                <button type="submit" class="flex-1 px-4 py-2 bg-violet-600 text-white rounded-lg hover:bg-violet-700">{{ __('user.modals.save') }}</button>
            </div>
        </form>
    </div>
</div>
