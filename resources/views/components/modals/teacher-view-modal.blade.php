{{-- Teacher View Modal Component --}}
<div x-show="modals.teacherView" class="fixed inset-0 z-50 flex items-center justify-center" style="display: none;">
    <div class="absolute inset-0 bg-black/50" @click="closeTeacherViewModal()"></div>
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-2xl mx-4 relative z-10 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="font-semibold text-gray-900 dark:text-white">{{ __('user.modals.teacher_info') }}</h3>
            <button @click="closeTeacherViewModal()" class="text-gray-500 hover:text-gray-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        
        <div class="p-6">
            <!-- Teacher Info -->
            <div class="flex items-start gap-4 mb-6">
                <!-- Photo or Initial -->
                <div class="w-20 h-20 rounded-full flex items-center justify-center overflow-hidden flex-shrink-0"
                     :class="viewingTeacher && viewingTeacher.photo ? 'bg-transparent' : 'bg-purple-100 dark:bg-purple-900/30'">
                    <img x-show="viewingTeacher && viewingTeacher.photo" :src="viewingTeacher.photo" class="w-full h-full object-cover" alt="">
                    <span x-show="viewingTeacher && !viewingTeacher.photo" class="text-purple-600 dark:text-purple-400 font-bold text-2xl" x-text="viewingTeacher ? viewingTeacher.name.charAt(0) : ''"></span>
                </div>
                
                <div class="flex-1">
                    <h4 class="text-xl font-semibold text-gray-900 dark:text-white" x-text="viewingTeacher ? viewingTeacher.name : ''"></h4>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1" x-text="viewingTeacher ? (viewingTeacher.phone || '{{ __('user.modals.no_phone') }}') : ''"></p>
                    <p class="text-sm text-gray-700 dark:text-gray-300 mt-2" x-text="viewingTeacher ? (viewingTeacher.about || '{{ __('user.modals.no_bio') }}') : ''"></p>
                </div>
            </div>
            
            <!-- Assigned Subjects -->
            <div>
                <h5 class="text-lg font-medium text-gray-900 dark:text-white mb-3">{{ __('user.modals.assigned_subjects') }}</h5>
                <div x-show="viewingTeacher && viewingTeacher.subjects && viewingTeacher.subjects.length > 0" class="space-y-3">
                    <template x-for="subject in (viewingTeacher ? viewingTeacher.subjects : [])" :key="subject.id">
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white" x-text="subject.name"></p>
                                    <div class="flex items-center gap-4 mt-1">
                                        <span class="text-xs text-gray-500 dark:text-gray-400" x-show="subject.pivot && subject.pivot.subject_type" x-text="subject.pivot && subject.pivot.subject_type ? getSubjectTypeText(subject.pivot.subject_type) : ''"></span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400" x-show="subject.pivot && subject.pivot.period" x-text="subject.pivot && subject.pivot.period ? getPeriodText(subject.pivot.period) : ''"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-900 dark:text-white" x-show="subject.pivot && subject.pivot.price">
                                    <span x-text="subject.pivot && subject.pivot.price ? formatPrice(subject.pivot.price) : ''"></span>
                                    <span class="text-xs text-gray-500" x-text="subject.pivot && subject.pivot.currency ? subject.pivot.currency : 'UZS'"></span>
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1" x-show="subject.pivot && subject.pivot.description" x-text="subject.pivot && subject.pivot.description ? subject.pivot.description : ''"></p>
                            </div>
                        </div>
                    </template>
                </div>
                
                <div x-show="!viewingTeacher || !viewingTeacher.subjects || viewingTeacher.subjects.length === 0" class="text-center py-8">
                    <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    <p class="text-gray-500 dark:text-gray-400">Biriktirilgan fanlar yo'q</p>
                </div>
            </div>
        </div>
        
        <div class="flex gap-3 p-4 border-t border-gray-200 dark:border-gray-700">
            <button @click="closeTeacherViewModal()" class="flex-1 px-4 py-2 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700">{{ __('user.modals.close') }}</button>
            <button @click="openTeacherSubjectModal(viewingTeacher); closeTeacherViewModal();" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">{{ __('user.modals.assign_subject') }}</button>
        </div>
    </div>
</div>
