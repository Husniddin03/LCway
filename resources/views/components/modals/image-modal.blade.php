{{-- Image Modal Component - Enhanced with Gallery and Lightbox --}}
<div x-show="modals.image" class="fixed inset-0 z-50 flex items-center justify-center" style="display: none;" x-cloak>
    <div class="absolute inset-0 bg-black/70" @click="closeImageModal()"></div>
    
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl w-full max-w-4xl mx-4 relative z-10 max-h-[90vh] overflow-y-auto">
        {{-- Header --}}
        <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700 sticky top-0 bg-white dark:bg-gray-800 z-20">
            <h3 class="font-semibold text-gray-900 dark:text-white">{{ __('user.modals.image_management') }}</h3>
            <button @click="closeImageModal()" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <div class="p-6 space-y-6">
            {{-- Existing Images Gallery --}}
            <div x-show="images.length > 0">
                <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">{{ __('user.modals.existing_images') }}</h4>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                    <template x-for="(image, index) in images" :key="image.id">
                        <div class="relative group aspect-square">
                            <img :src="image.url" 
                                 @click="openLightbox(index)"
                                 class="w-full h-full object-cover rounded-lg cursor-pointer hover:opacity-90 transition-opacity border border-gray-200 dark:border-gray-700">
                            
                            {{-- Delete Button --}}
                            <button @click="deleteImage(image.id)" 
                                    class="absolute top-2 right-2 w-8 h-8 bg-red-500 hover:bg-red-600 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all shadow-lg"
                                    title="{{ __('user.modals.delete') }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                            
                            {{-- View Indicator --}}
                            <div class="absolute bottom-2 left-2 right-2 bg-black/50 rounded px-2 py-1 text-white text-xs text-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer"
                                 @click="openLightbox(index)">
                                {{ __('user.modals.view') }}
                            </div>
                        </div>
                    </template>
                </div>
            </div>
            
            <div x-show="images.length === 0" class="text-center py-8 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p class="text-gray-500 dark:text-gray-400">{{ __('user.modals.no_images') }}</p>
            </div>

            {{-- Upload Section --}}
            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">{{ __('user.modals.upload_new_image') }}</h4>
                
                {{-- Drag & Drop Zone --}}
                <div x-ref="dropZone"
                     @dragover.prevent="$refs.dropZone.classList.add('border-violet-500', 'bg-violet-50', 'dark:bg-violet-900/20')"
                     @dragleave.prevent="$refs.dropZone.classList.remove('border-violet-500', 'bg-violet-50', 'dark:bg-violet-900/20')"
                     @drop.prevent="handleImageDrop($event)"
                     class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-8 text-center hover:border-violet-400 dark:hover:border-violet-500 transition-all cursor-pointer"
                     @click="$refs.imageInput.click()">
                    
                    <input type="file" x-ref="imageInput" @change="handleImageSelect($event)" accept="image/*" multiple class="hidden">
                    
                    <div class="w-16 h-16 mx-auto mb-4 bg-violet-100 dark:bg-violet-900/30 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                    </div>
                    <p class="text-gray-700 dark:text-gray-300 font-medium mb-1">{{ __('user.modals.drag_drop_images') }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('user.modals.image_formats') }}</p>
                </div>

                {{-- Preview Selected Images --}}
                <div x-show="imageUploads.previews.length > 0" class="mt-4">
                    <div class="flex items-center justify-between mb-3">
                        <h5 class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('user.modals.selected_images') }} (<span x-text="imageUploads.previews.length"></span>)</h5>
                        <button @click="clearImageUploads()" class="text-red-500 hover:text-red-700 text-sm flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            {{ __('user.modals.clear') }}
                        </button>
                    </div>
                    <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-3">
                        <template x-for="(preview, idx) in imageUploads.previews" :key="idx">
                            <div class="relative aspect-square">
                                <img :src="preview" class="w-full h-full object-cover rounded-lg border border-gray-200 dark:border-gray-700">
                                <button @click="removeImagePreview(idx)" class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center shadow-md hover:bg-red-600">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                            </div>
                        </template>
                    </div>
                    
                    {{-- Upload Button --}}
                    <button @click="uploadImages()" 
                            :disabled="imageUploads.uploading"
                            class="mt-4 w-full py-3 bg-violet-600 hover:bg-violet-700 disabled:bg-violet-400 text-white font-medium rounded-lg transition-colors flex items-center justify-center gap-2">
                        <svg x-show="!imageUploads.uploading" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                        <svg x-show="imageUploads.uploading" class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span x-text="imageUploads.uploading ? '{{ __('user.modals.uploading') }}...' : '{{ __('user.modals.upload') }}'"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Lightbox --}}
    <div x-show="lightbox.show" class="fixed inset-0 z-[60] bg-black/95 flex items-center justify-center" x-cloak @click.self="closeLightbox()">
        <button @click="closeLightbox()" class="absolute top-4 right-4 w-10 h-10 bg-white/10 hover:bg-white/20 text-white rounded-full flex items-center justify-center transition-colors z-50">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        
        <button @click="prevLightboxImage()" x-show="images.length > 1" class="absolute left-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white/10 hover:bg-white/20 text-white rounded-full flex items-center justify-center transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </button>
        
        <button @click="nextLightboxImage()" x-show="images.length > 1" class="absolute right-4 top-1/2 -translate-y-1/2 w-12 h-12 bg-white/10 hover:bg-white/20 text-white rounded-full flex items-center justify-center transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </button>
        
        <img :src="lightbox.currentImage" class="max-w-[90%] max-h-[85vh] object-contain rounded-lg">
        
        <div x-show="images.length > 1" class="absolute bottom-4 left-1/2 -translate-x-1/2 bg-black/50 text-white px-4 py-2 rounded-full text-sm">
            <span x-text="lightbox.currentIndex + 1"></span> / <span x-text="images.length"></span>
        </div>
    </div>
</div>
